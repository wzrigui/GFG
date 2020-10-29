<?php

namespace App\Controller;

use App\Entity\Product;
use App\Mail\EmailProvider;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/products/findAll")
     */
    public function findAllAction(ProductRepository $productRepository): Response
    {
        $product = $productRepository->getAll();
        $view = $this->view($product, 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/products/findById/{productId}")
     */
    public function findByIdAction(ProductRepository $productRepository, int $productId): Response
    {
        $product = $productRepository->getById($productId);
        $view = $this->view($product, 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/products/new")
     */
    public function newAction(ProductRepository $productRepository, Request $request): Response
    {
        $requestJson = json_decode($request->getContent(), true);

        $uuid = Uuid::uuid1(1)->toString();

        $product = new Product(
            $uuid,
            $requestJson['name'],
            $requestJson['brand'],
            $requestJson['stock']
        );

        $productId = $productRepository->add($product);
        $product = $productRepository->getById($productId);

        $view = $this->view($product, 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/products/updateById/{productId}")
     */
    public function updateByIdAction(ProductRepository $productRepository, Request $request, int $productId): Response
    {
        $requestJson = json_decode($request->getContent(), true);

        $product = $productRepository->getById($productId);
        $updatedProduct = new Product(
            $product->getUuid(),
            $requestJson['name'] ?? $product->getName(),
            $requestJson['brand'] ?? $product->getBrand(),
            $requestJson['stock'] ?? $product->getStock(),
            $productId
        );

        $productRepository->update($updatedProduct);

        if ($product->getStock() !== $updatedProduct->getStock()) {
            (new EmailProvider())->sendStockChangedEmail(
                $product->getName(),
                $product->getStock(),
                $updatedProduct->getStock()
            );
        }

        $view = $this->view($updatedProduct, 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/products/deleteById/{productId}")
     */
    public function deleteByIdAction(ProductRepository $productRepository, $productId): Response
    {
        try {
            $productRepository->deleteById($productId);
            $view = $this->view(true, 200);
        } catch (\Throwable $e) {
            $view = $this->view(false, 200);
        }

        return $this->handleView($view);
    }
}
