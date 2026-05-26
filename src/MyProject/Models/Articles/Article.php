<?php

namespace MyProject\Models\Articles;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Services\Db;
use MyProject\Models\Users\User;


class Article extends ActiveRecordEntity
{
    protected $name;
    protected $text;
    protected $author_id;
    protected $created_at;

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }

    public function setAuthor(User $author): void
    {
        $this->author_id = $author->getId();
    }

    public function getAuthor(): User
    {
        return User::getById($this->author_id);
    }
}
