<?php

namespace MyProject\Models\Articles;

// use MyProject\Models\Users\User;


class User
{
    private $id;
    private $nickname;
    private $email;
    private $is_confirmed;
    private $role;
    private $password_hash;
    private $auth_token;
    private $created_at;

    public function __set($nickname, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($nickname);
        $this->$camelCaseName = $value;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->nickname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }
}
