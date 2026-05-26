<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Services\Db;
use MyProject\View\View;

class MainController
{
    private $view;
    private $db;

    // public function __construct()
    // {
    //     $this->view = new View(__DIR__ . '/../../../templates');
    //     $this->db = new Db();
    // }

    // public function main()
    // {
    //     $articles = $this->db->query('SELECT * FROM `articles`;', [], Article::class);

    //     $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    // }

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }
}
