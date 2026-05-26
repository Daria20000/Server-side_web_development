# Shop — PHP + MySQL

Минималистичный каталог товаров. Весь backend и логика — чистый PHP

## Стек

- **Frontend**: HTML + CSS
- **Backend**: PHP 8+ (сессии, PDO, формы)
- **БД**: MySQL 8+

---

## Быстрый старт

### 1. База данных

```bash
mysql -u root -p < config/schema.sql
```

### 2. Настройка подключения

Отредактируй `config/db.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'shop_db');
```

### 3. Запуск

```bash
php -S localhost:8000
```

---
