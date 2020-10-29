<?php
namespace App\Entity;

class Product
{
    /** @var int|null */
    private $id;

    /** @var string */
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
