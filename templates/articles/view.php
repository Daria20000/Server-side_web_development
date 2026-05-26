<?php include __DIR__ . '/../main/header.php'; ?>

<h2><?= $article->getName() ?></h2>
<p><?= $article->getText() ?></p>
<p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
<a href="/articles/<?= $article->getId() ?>/edit">
    Редактировать статью
</a>

<?php include __DIR__ . '/../main/footer.php'; ?>