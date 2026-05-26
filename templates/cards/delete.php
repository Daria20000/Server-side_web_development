<?php include __DIR__ . '/../main/header.php'; ?>
<div class="confirm-wrap">
    <div class="confirm-card">
        <div class="confirm-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="3 6 5 6 21 6" />
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                <path d="M10 11v6M14 11v6" />
                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
            </svg>
        </div>
        <h1 class="confirm-title">Удалить товар?</h1>
        <p class="confirm-text">
            Вы уверены, что хотите удалить <strong><?= $card->getName() ?></strong>?<br>
            Это действие нельзя отменить.
        </p>
        <div class="confirm-actions">
            <a href="/" class="btn btn-ghost">Отмена</a>
            <form method="post" action="/">
                <button type="submit" name="confirm" value="1" class="btn btn-danger-soft">
                    Да, удалить
                </button>
            </form>
        </div>
    </div>
</div>