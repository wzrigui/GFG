<?php

namespace App\Controller;

use App\Service\ProductService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends AbstractFOSRestController
{
    private  $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @return Response
     *
     * @Rest\Get("/products")
     */
    public function findAllAction(): Response
    {
        $products = $this->productService->getProductRepository()->getAll();
        $view = $this->view($products, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @param int $productId
     * @return JsonResponse
     * @throws \Exception
     */
    public function findByIdAction(int $productId): JsonResponse
    {
        $product = $this->productService->getProductRepository()->getById($productId);
        if (!$product) {
            return $this->json([], Response::HTTP_NOT_FOUND);
        }
        $view = $this->view($product, Response::HTTP_OK);

        return $this->json($product);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     *
     * @Rest\Post("/products")
     */
    public function newAction(Request $request): Response
    {
        $requestJson = json_decode($request->getContent(), true);
        $product = $this->productService->addProduct($requestJson);

        $view = $this->view($product, Response::HTTP_CREATED);

        return $this->handleView($view);
    }

    /**
     * @param int $productId
     * @param Request $request
     * @return Response
     * @throws \Exception
     *
     * @Rest\Put("/products/{productId}")
     */
    public function updateByIdAction(int $productId, Request $request): Response
    {
        $requestJson = json_decode($request->getContent(), true);
        $updatedProduct = $this->productService->updateProduct($productId, $requestJson);
        $view = $this->view($updatedProduct, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @param $productId
     * @return Response
     *
     * @Rest\Delete("/products/{productId}")
     */
    public function deleteByIdAction($productId): Response
    {
        try {
            $this->productService->getProductRepository()->deleteById($productId);
            $view = $this->view(true, Response::HTTP_NO_CONTENT);
        } catch (\Throwable $e) {
            $view = $this->view(false, Response::HTTP_GONE);
        }

        return $this->handleView($view);
    }
}
