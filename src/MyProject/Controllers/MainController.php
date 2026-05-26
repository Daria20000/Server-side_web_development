<?php

namespace MyProject\Controllers;

use MyProject\Models\Users\User;
use MyProject\Models\Cards\Card;
use MyProject\View\View;

class MainController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function main()
    {
        $users = User::findAll();
        $cards = Card::findAll();
        $this->view->renderHtml('main/main.php', ['user' => $users[0], 'cards' => $cards]);
    }
}
