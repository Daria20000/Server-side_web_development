<?php
require_once 'db.php';
require_once 'menu.php';
require_once 'viewer.php';

// Determine active section
$section = isset($_GET['section']) ? $_GET['section'] : 'view';
$allowed = ['view', 'add', 'edit', 'delete'];
if (!in_array($section, $allowed)) $section = 'view';

// Sorting and pagination for viewer
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$allowed_sorts = ['id', 'lastname', 'birthdate'];
if (!in_array($sort, $allowed_sorts)) $sort = 'id';

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Записная книжка</title>
</head>

<?php require_once 'header.php'; ?>

<body>

    <div id="header">
        <?php echo getMenu($section); ?>
    </div>

    <?php if ($section === 'view'): ?>
        <div id="submenu">
            <?php echo getSubMenu($sort); ?>
        </div>
    <?php endif; ?>

    <div id="content">
        <?php
        switch ($section) {
            case 'view':
                echo getViewer($conn, $sort, $page);
                break;
            case 'add':
                require_once 'add.php';
                break;
            case 'edit':
                require_once 'edit.php';
                break;
            case 'delete':
                require_once 'delete.php';
                break;
        }
        ?>
    </div>

</body>

<?php require_once 'footer.php'; ?>

</html>