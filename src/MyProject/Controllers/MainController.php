<?php

namespace MyProject\Controllers;


class MainController
{
    private $view;
    public function __construct()
    {
        $this->view = new \MyProject\View\View(__DIR__ . '/../../../templates');
    }

    public function main()
    {
        $articles = [
            ['name' => 'Статья 1', 'text' => 'Текст статьи 1'],
            ['name' => 'Статья 2', 'text' => 'Текст статьи 2'],
        ];
        $title = 'Главная страница';
        $this->view->renderHtml('main/main.php', ['articles' => $articles, 'title' => $title]);
    }

    public function sayHello(string $name)
    {
        $title = 'Страница приветствия';
        $this->view->renderHtml('main/hello.php', ['name' => $name, 'title' => $title]);
    }

    public function sayBye(string $name)
    {
        $title = 'Страница прощания';
        $this->view->renderHtml('main/bye.php', ['name' => $name, 'title' => $title]);
    }
}
