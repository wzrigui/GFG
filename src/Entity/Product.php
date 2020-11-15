<?php
namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 *
 * @Hateoas\Relation(
 *     "self",
 *     attributes={"type": "GET"},
 *     href = "expr('/products/' ~ object.getId())",
 *     )
 * @Hateoas\Relation(
 *     "Create",
 *     attributes={"type": "POST"},
 *     href = "expr('/products')"
 * )
 * @Hateoas\Relation(
 *     "Update",
 *     attributes={"type": "PUT"},
 *     href = "expr('/products/' ~ object.getId())"
 * )
 * @Hateoas\Relation(
 *     "Delete",
 *     attributes={"type": "DELETE"},
 *     href = "expr('/products/' ~ object.getId())"
 * )
 */
class Product
{
    /**
     *
     * @var int|null
     */
    private $id;

    /**
     * @Serializer\Groups({"default"})
     * @var string
     */
    private $uuid;

    /** @var string */
    private $name;

    /** @var string */
    private $brand;

    /** @var int */
    private $stock;



    public function __construct(
        string $uuid,
        string $name,
        string $brand,
        int $stock,
        int $id = null
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->brand = $brand;
        $this->stock = $stock;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

}
