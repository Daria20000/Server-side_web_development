<?php

namespace MyProject\Models\Users;

use MyProject\Models\ActiveRecordEntity;

class User extends ActiveRecordEntity
{
    protected $nickname;
    protected $email;
    protected $is_confirmed;
    protected $role;
    protected $password_hash;
    protected $auth_token;
    protected $created_at;

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }
}
