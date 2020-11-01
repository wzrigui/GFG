<?php

namespace App\Controller;

use App\Service\ProductService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends AbstractFOSRestController
{
    /**
     * @param ProductService $productService
     * @return Response
     *
     * @Rest\Get("/products")
     */
    public function findAllAction(ProductService $productService): Response
    {
        $product = $productService->getProductRepository()->getAll();
        $view = $this->view($product, 200);

        return $this->handleView($view);
    }

    /**
     * @param int $productId
     * @param ProductService $productService
     * @return Response
     * @throws \Exception
     *
     * @Rest\Get("/products/{productId}")
     */
    public function findByIdAction(int $productId, ProductService $productService): Response
    {
        $product = $productService->getProductRepository()->getById($productId);
        $view = $this->view($product, 200);

        return $this->handleView($view);
    }

    /**
     * @param Request $request
     * @param ProductService $productService
     * @return Response
     * @throws \Exception
     *
     * @Rest\Post("/products")
     */
    public function newAction(Request $request, ProductService $productService): Response
    {
        $requestJson = json_decode($request->getContent(), true);
        $product = $productService->addProduct($requestJson);

        $view = $this->view($product, 200);

        return $this->handleView($view);
    }

    /**
     * @param int $productId
     * @param Request $request
     * @param ProductService $productService
     * @return Response
     * @throws \Exception
     *
     * @Rest\Put("/products/{productId}")
     */
    public function updateByIdAction(int $productId, Request $request, ProductService $productService): Response
    {
        $requestJson = json_decode($request->getContent(), true);
        $productService->updateProduct($productId, $requestJson);
        $product = $productService->getProductRepository()->getById($productId);
        $updatedProduct = $productService->updateProduct($product);
        $view = $this->view($updatedProduct, 200);

        return $this->handleView($view);
    }

    /**
     * @param $productId
     * @param ProductService $productService
     * @return Response
     *
     * @Rest\Delete("/products/{productId}")
     */
    public function deleteByIdAction($productId, ProductService $productService): Response
    {
        try {
            $productService->getProductRepository()->deleteById($productId);
            $view = $this->view(true, 200);
        } catch (\Throwable $e) {
            $view = $this->view(false, 200);
        }

        return $this->handleView($view);
    }
}
