<?php include 'header.php'; ?>

<nav class="navbar">
    <a href="/" class="nav-brand">Shop</a>
    <div class="nav-spacer"></div>
    <nav class="nav-user">
        <?php if (true): ?>
            <span><?= $user->getName() ?></span>
            <!-- <form method="post" action="/templates/main/logout.php" style="display:inline">
                <button type="submit" class="btn btn-ghost btn-sm">Выйти</button>
            </form>
        <?php else: ?>
            <a href="/login.php" class="btn btn-ghost btn-sm">Войти</a>
        <?php endif; ?> -->
    </nav>
</nav>

<main class="page">
    <div class="toolbar">
        <div class="toolbar-spacer"></div>
        <a href="/card/add" class="btn btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M12 5v14M5 12h14" />
            </svg>
            Добавить товар
        </a>
    </div>
    <div class="products-grid">
        <?php foreach ($cards as $p): ?>
            <div class="product-card">
                <div class="card-image">
                    <?php if (!empty($p->getImageURL())): ?>
                        <img src="<?= $p->getImageURL() ?>" alt="<?= $p->getName() ?>" loading="lazy">
                    <?php else: ?>
                        <div class="card-image-placeholder">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <path d="M21 15l-5-5L5 21" />
                            </svg>
                            <span>Нет фото</span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <?php if (!empty($p->getImageURL())): ?>
                        <div class="card-category"><?= $p->getCategory() ?></div>
                    <?php endif; ?>
                    <div class="card-name"><?= $p->getName() ?></div>
                    <?php if (!empty($p->getDescription())): ?>
                        <div class="card-desc"><?= $p->getDescription() ?></div>
                    <?php endif; ?>
                    <div class="card-footer">
                        <div>
                            <div class="card-price">$<?= number_format((float)$p->getPrice(), 2) ?></div>
                            <div class="card-stock">
                                <?= $p->getStock() > 0 ? 'В наличии: ' . (int)$p->getStock() . ' шт.' : 'Нет в наличии' ?>
                            </div>
                        </div>
                        <div class="card-actions">
                            <a href="/card/<?= (int)$p->getId() ?>/edit" class="btn btn-ghost btn-sm">Изменить</a>
                            <a href="/card/<?= (int)$p->getId() ?>/delete" class="btn btn-danger-soft btn-sm">Удалить</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'footer.php'; ?>