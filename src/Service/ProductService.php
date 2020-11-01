<?php


namespace App\Service;


use App\Entity\Product;
use App\Mail\EmailProvider;
use App\Repository\ProductRepository;
use Ramsey\Uuid\Uuid;

class ProductService
{
    /** @var ProductRepository  */
    protected $productRepository;

    /** @var EmailProvider */
    protected $emailProvider;

    public function __construct(ProductRepository $productRepository, EmailProvider $emailProvider)
    {
        $this->productRepository = $productRepository;
        $this->emailProvider = $emailProvider;
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
     * @param Product $product
     * @param array $requestJson
     * @return Product
     * @throws \Exception
     */
    public function updateProduct(Product $product, $requestJson): Product
    {
        $updatedProduct = new Product(
            $product->getUuid(),
            $requestJson['name'] ?? $product->getName(),
            $requestJson['brand'] ?? $product->getBrand(),
            $requestJson['stock'] ?? $product->getStock(),
            $product->getId()
        );
        $this->productRepository->update($updatedProduct);
        if ($product->getStock() !== $updatedProduct->getStock()) {
            $this->sendUpdatedProductMail($product,$updatedProduct);
        }

        return $updatedProduct;
    }
    private function sendUpdatedProductMail(Product $product,Product $updatedProduct)
    {
        $this->emailProvider->sendStockChangedEmail(
            $product->getName(),
            $product->getStock(),
            $updatedProduct->getStock()
        );

    }

    /**
     * @return ProductRepository
     */
    public function getProductRepository(): ProductRepository
    {
        return $this->productRepository;
    }

}
