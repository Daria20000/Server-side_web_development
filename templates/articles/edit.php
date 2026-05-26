<?php include __DIR__ . '/../main/header.php'; ?>

<form method="post" action="/articles/<?= $article->getId() ?>/edit">

    <label>
        Название:
        <input
            type="text"
            name="name"
            value="<?= htmlspecialchars($article->getName() ?? '') ?>">
    </label>

    <br><br>

    <label>
        Текст:
        <textarea name="text" rows="5" cols="50"><?= htmlspecialchars($article->getText() ?? '') ?></textarea>
    </label>

    <br><br>

    <button type="submit">Сохранить</button>
</form>


<?php include __DIR__ . '/../main/footer.php'; ?>