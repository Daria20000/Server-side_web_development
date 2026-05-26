<?php

namespace MyProject\Controllers;

use MyProject\View\View;
use MyProject\Models\Cards\Card;
use MyProject\Models\Users\User;

class CardController

{
    /** @var View */
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function view(int $cardId): void
    {
        $card = Card::getById($cardId);

        if ($card === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $this->view->renderHtml('cards/view.php', [
            'card' => $card
        ]);
    }

    public function edit(int $cardId): void
    {
        /** @var card $card */
        $card = card::getById($cardId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $card->setName($_POST['name']);
            $card->setDescription($_POST['description']);
            $card->setPrice($_POST['price']);
            $card->setImageURL($_POST['image_url']);
            $card->setCategory($_POST['category']);
            $card->setStock($_POST['stock']);

            $card->save();

            header('Location: /');
            exit;
        }

        if ($card === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $this->view->renderHtml('cards/edit.php', [
            'card' => $card
        ]);
    }

    public function add(): void
    {
        $card = new card();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $card->setName($_POST['name']);
            $card->setDescription($_POST['description']);
            $card->setPrice($_POST['price']);
            $card->setImageURL($_POST['image_url']);
            $card->setCategory($_POST['category']);
            $card->setStock($_POST['stock']);

            $card->save();
            header('Location: /');
            exit;
        }

        if ($card === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $this->view->renderHtml('cards/add.php', [
            'card' => $card
        ]);
    }

    public function delete(int $cardId): void
    {
        $card = card::getById($cardId);

        $card->delete();

        $this->view->renderHtml('cards/delete.php', [
            'card' => $card
        ]);
    }
}
