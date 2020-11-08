<?php


namespace App\Service;


use App\Entity\Product;
use App\Mail\EmailProvider;
use App\Mail\SendingProviderInterface;
use App\Repository\ProductRepository;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use Ramsey\Uuid\Uuid;

class ProductService
{
    /** @var ProductRepository */
    protected $productRepository;

    /** @var EmailProvider */
    protected $sendingProvider;

    public function __construct(ProductRepository $productRepository, SendingProviderInterface $sendingProvider)
    {
        $this->productRepository = $productRepository;
        $this->sendingProvider = $sendingProvider;
    }

    /**
     * @param $requestJson
     * @return Product
     * @throws \Exception
     */
    public function addProduct($requestJson): Product
    {
        $uuid = Uuid::uuid1(1)->toString();

        $product = new Product(
            $uuid,
            $requestJson['name'],
            $requestJson['brand'],
            $requestJson['stock']
        );

        $productId = $this->productRepository->add($product);

        return $this->productRepository->getById($productId);
    }

    /**
     * @param  $productId
     * @param array $requestJson
     * @return Product
     * @throws \Exception
     */
    public function updateProduct($productId, $requestJson): Product
    {
        $product = $this->productRepository->getById($productId);
        $updatedProduct = new Product(
            $product->getUuid(),
            $requestJson['name'] ?? $product->getName(),
            $requestJson['brand'] ?? $product->getBrand(),
            $requestJson['stock'] ?? $product->getStock(),
            $product->getId()
        );
        $this->productRepository->update($updatedProduct);
        if ($product->getStock() !== $updatedProduct->getStock()) {
            $this->sendUpdatedProductMail($product, $updatedProduct);
        }

        return $updatedProduct;
    }

    private function sendUpdatedProductMail(Product $product, Product $updatedProduct)
    {
        $this->sendingProvider->sendStockChanged(
            $product->getName(),
            $product->getStock(),
            $updatedProduct->getStock()
        );

    }

    /**
     * @param $request
     * @return Product[]|PaginatedRepresentation
     */
    public function getProducts($request)
    {
        $query = ['name' => ':name' ,'brand' => ':brand'];
        $filter['execute'] = array_filter( [':name' => $request->get('name') ,':brand' => $request->get('brand')], 'strlen' );
        //building where condition
        $filter['query'] = array_intersect($query, array_keys($filter['execute']));
        $filter['query'] = urldecode(http_build_query($filter['query'], ' ', ' AND '));

        $products = $this->productRepository->getAll($request->get('sort'), $filter);
        $limit = $request->get('size', 0);
        $page = $request->get('page', 1);
        if ($limit) {
            $offset = ($page - 1) * $limit;
            $collection = new CollectionRepresentation(array_slice($products, $offset, $limit));
            $numberOfPages = $limit ? (int)ceil(count($products) / $limit) : 1;

            $products = new PaginatedRepresentation(
                $collection,
                'get_products',
                array(),
                $page,
                $limit,
                $numberOfPages,
                'page',
                'limit',
                true,
                count($products)
            );
        }

        return $products;
    }

    /**
     * @return ProductRepository
     */
    public function getProductRepository(): ProductRepository
    {
        return $this->productRepository;
    }

}
