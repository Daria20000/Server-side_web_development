<?php

namespace MyProject\Models\Cards;

use MyProject\Models\ActiveRecordEntity;


class Card extends ActiveRecordEntity
{
    protected $name;
    protected $description;
    protected $price;
    protected $image_url;
    protected $category;
    protected $stock;
    protected $created_at;
    protected $updatedAt;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getImageURL(): string
    {
        return $this->image_url;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getStock(): string
    {
        return $this->stock;
    }


    // public function getAuthorId(): int
    // {
    //     return $this->author_id;
    // }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function setPrice(string $price)
    {
        $this->price = $price;
    }

    public function setImageURL(string $image_url)
    {
        $this->image_url = $image_url;
    }

    public function setCategory(string $category)
    {
        $this->category = $category;
    }

    public function setstock(string $stock)
    {
        $this->stock = $stock;
    }

    protected static function getTableName(): string
    {
        return 'products';
    }

    // public function setAuthor(User $author): void
    // {
    //     $this->author_id = $author->getId();
    // }

    // public function getAuthor(): User
    // {
    //     return User::getById($this->author_id);
    // }
}
