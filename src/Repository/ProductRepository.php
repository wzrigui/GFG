<?php
namespace App\Repository;

use App\Entity\Product;
use Doctrine\DBAL\Driver\Connection;

class ProductRepository
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Product[]
     */
    public function getAll()
    {
        $query = 'SELECT * FROM product ORDER BY product.id_product';
        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $this->buildArray($statement->fetchAllAssociative());
    }

    public function getById(int $productId)
    {
        $query = 'SELECT * FROM product WHERE id_product = :id_product';
        $statement = $this->connection->prepare($query);
        $statement->execute([':id_product' => $productId]);

        $products = $this->buildArray($statement->fetchAllAssociative());

        if (empty($products)) {
            throw new \Exception(
                sprintf(
                    'Product with Id %s not found',
                    $productId
                )
            );
        }

        return $products[0];
    }

    public function add(Product $product): string
    {
        $query =
            'INSERT INTO product (uuid, name, brand, stock)
              VALUES (:uuid, :name, :brand, :stock)';

        $statement = $this->connection->prepare($query);
        $success = $statement->execute(
            [
                ':uuid' => $product->getUuid(),
                ':name' => $product->getName(),
                ':brand' => $product->getBrand(),
                ':stock' => $product->getStock(),
            ]
        );

        if (false === $success) {
            throw new \Exception(
                sprintf(
                    'Failed to add product %s to the repository',
                    $product->getUuid()
                )
            );
        }

        return $this->connection->lastInsertId();
    }

    public function update(Product $product)
    {
        $query =
            'UPDATE product SET 
                name = :name,
                brand = :brand,
                stock = :stock
              WHERE id_product = :id_product';

        $statement = $this->connection->prepare($query);

        $success = $statement->execute(
            [
                ':id_product' => $product->getId(),
                ':name' => $product->getName(),
                ':brand' => $product->getBrand(),
                ':stock' => $product->getStock(),
            ]
        );

        if (false === $success) {
            throw new \Exception(
                sprintf(
                    'Failed to update product %s in the repository',
                    $product->getUuid()
                )
            );
        }
    }

    public function deleteById(int $productId)
    {
        $query = 'DELETE FROM product WHERE id_product = :id_product';

        $statement = $this->connection->prepare($query);
        $success = $statement->execute(
            [
                ':id_product' => $productId,
            ]
        );

        if (false === $success) {
            throw new \Exception(
                sprintf(
                    'Failed to delete product %s from the repository',
                    $productId
                )
            );
        }
    }

    /**
     * @param array $statementResults
     * @return Product[]
     */
    private function buildArray(array $statementResults): array
    {
        return array_map(
            fn($result) =>
                new Product(
                    $result['uuid'],
                    $result['name'],
                    $result['brand'],
                    $result['stock'],
                    $result['id_product']
                ),
            $statementResults
        );
    }
}
