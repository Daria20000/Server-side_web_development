<?php

namespace MyProject\Controllers;

use MyProject\Services\Db;
use MyProject\View\View;
use MyProject\Models\Articles\Article;
use MyProject\Models\Articles\User;


class ArticlesController

{
    /** @var View */
    private $view;

    /** @var Db */
    private $db;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->db = new Db();
    }

    public function view(int $articleId)
    {
        $result = $this->db->query('SELECT * FROM `articles` WHERE id = :id;', [':id' => $articleId], Article::class);

        if ($result === []) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        } else {
            $users = $this->db->query('SELECT * FROM `users` WHERE id = :id;', [':id' => $result[0]->getAuthorId()], User::class);
        }

        $this->view->renderHtml('articles/view.php', ['article' => $result[0], 'users' => $users[0]]);
    }
}
