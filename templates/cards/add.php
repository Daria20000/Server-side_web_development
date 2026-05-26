<?php include __DIR__ . '/../main/header.php'; ?>

<div class="form-page">
    <div class="form-page-header">
        <a href="/" class="btn btn-ghost btn-sm" style="margin-bottom:16px">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Назад
        </a>
        <h1 class="form-page-title">Добавить товар</h1>
        <p class="form-page-sub">Внесите изменения и сохраните.</p>
    </div>

    <div class="form-card">
        <form method="post" method="post" action="/card/add" class="form-wrap">

            <div class="field">
                <label for="name">Название *</label>
                <input id="name" name="name" type="text"
                    value=""
                    placeholder="например, AirPods Pro" required>
            </div>

            <div class="field">
                <label for="description">Описание</label>
                <textarea id="description" name="description" rows="3"
                    placeholder="Краткое описание товара…"></textarea>
            </div>

            <div class="form-row">

                <div class="field">
                    <label for="price">Цена ($) *</label>
                    <input id="price" name="price" type="number" step="0.01" min="0"
                        placeholder="0.00" required>
                </div>
                <div class="field">
                    <label for="stock">Остаток (шт.)</label>
                    <input id="stock" name="stock" type="number" min="0"
                        placeholder="0">
                </div>
            </div>

            <div class="form-row">
                <div class="field">
                    <label for="category">Категория</label>
                    <input id="category" name="category" type="text"
                        placeholder="например, Audio">
                </div>
                <div class="field">
                    <label for="image_url">Ссылка на изображение</label>
                    <input id="image_url" name="image_url" type="url"
                        placeholder="https://…">
                </div>
            </div>

            <div class="form-actions">
                <a href="/" class="btn btn-ghost">Отмена</a>
                <button type="submit" class="btn btn-primary">
                    Добавить товар
                </button>
            </div>
        </form>
    </div>
</div>