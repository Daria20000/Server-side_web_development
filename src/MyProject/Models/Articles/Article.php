<?php

namespace MyProject\Models\Articles;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Services\Db;
use MyProject\Models\Users\User;


class Article extends ActiveRecordEntity
{
    private $name;
    private $text;
    private $author_id;
    private $created_at;

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

    protected static function getTableName(): string
    {
        return 'articles';
    }

    public function getAuthor(): User
    {
        return User::getById($this->author_id);
    }
}
