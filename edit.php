<?php
// edit.php — редактирование существующей записи

$message = '';

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id         = intval($_POST['id'] ?? 0);
    $lastname   = trim($_POST['lastname']   ?? '');
    $firstname  = trim($_POST['firstname']  ?? '');
    $middlename = trim($_POST['middlename'] ?? '');
    $gender     = trim($_POST['gender']     ?? '');
    $birthdate  = trim($_POST['birthdate']  ?? '');
    $phone      = trim($_POST['phone']      ?? '');
    $address    = trim($_POST['address']    ?? '');
    $email      = trim($_POST['email']      ?? '');
    $comment    = trim($_POST['comment']    ?? '');

    if ($id <= 0 || $lastname === '' || $firstname === '') {
        $message = '<p class="msg-error">Ошибка: запись не обновлена.</p>';
    } else {
        $stmt = $conn->prepare(
            "UPDATE contacts SET lastname=?, firstname=?, middlename=?, gender=?, birthdate=?, phone=?, address=?, email=?, comment=? WHERE id=?"
        );
        $stmt->bind_param(
            'sssssssssi',
            $lastname, $firstname, $middlename, $gender,
            $birthdate, $phone, $address, $email, $comment, $id
        );
        if ($stmt->execute() && $stmt->affected_rows >= 0) {
            $message = '<p class="msg-success">Запись обновлена.</p>';
        } else {
            $message = '<p class="msg-error">Ошибка: запись не обновлена.</p>';
        }
        $stmt->close();
    }
}

// Fetch all contacts for list (sorted by lastname, firstname)
$contacts = [];
$listResult = $conn->query("SELECT id, lastname, firstname, middlename FROM contacts ORDER BY lastname ASC, firstname ASC");
if ($listResult) {
    while ($row = $listResult->fetch_assoc()) {
        $contacts[] = $row;
    }
}

// Determine selected contact ID
// After POST keep the same id; otherwise use GET; default to first
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $selectedId = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
    $selectedId = intval($_GET['id']);
} else {
    $selectedId = !empty($contacts) ? (int)$contacts[0]['id'] : 0;
}

// Fetch selected contact data
$selected = null;
if ($selectedId > 0) {
    $stmt = $conn->prepare("SELECT * FROM contacts WHERE id=?");
    $stmt->bind_param('i', $selectedId);
    $stmt->execute();
    $res = $stmt->get_result();
    $selected = $res->fetch_assoc();
    $stmt->close();
}

// If nothing found, fall back to first
if (!$selected && !empty($contacts)) {
    $selectedId = (int)$contacts[0]['id'];
    $stmt = $conn->prepare("SELECT * FROM contacts WHERE id=?");
    $stmt->bind_param('i', $selectedId);
    $stmt->execute();
    $res = $stmt->get_result();
    $selected = $res->fetch_assoc();
    $stmt->close();
}

$v = function($field) use ($selected) {
    return htmlspecialchars($selected[$field] ?? '');
};
?>

<div style="max-width: 900px;">
    <h2 style="color:#1a2a4a; font-weight:normal; letter-spacing:1px; margin-bottom:16px; border-bottom:1px solid #e0d8c8; padding-bottom:10px;">Редактирование записи</h2>

    <?php if (empty($contacts)): ?>
        <p style="color:#888;">База данных пуста. Нечего редактировать.</p>
    <?php else: ?>

    <!-- Contact list -->
    <div class="record-list">
        <?php foreach ($contacts as $c): ?>
            <?php
            $isActive = ((int)$c['id'] === $selectedId);
            $name = htmlspecialchars($c['lastname'] . ' ' . $c['firstname']);
            ?>
            <a href="index.php?section=edit&id=<?php echo $c['id']; ?>"
               class="<?php echo $isActive ? 'active' : ''; ?>">
                <?php echo $name; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Edit form -->
    <div class="form-container">
        <?php echo $message; ?>
        <?php if ($selected): ?>
        <form method="POST" action="index.php?section=edit">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?php echo $v('id'); ?>">

            <div class="form-row">
                <label>Фамилия *</label>
                <input type="text" name="lastname" maxlength="100" value="<?php echo $v('lastname'); ?>" required>
            </div>
            <div class="form-row">
                <label>Имя *</label>
                <input type="text" name="firstname" maxlength="100" value="<?php echo $v('firstname'); ?>" required>
            </div>
            <div class="form-row">
                <label>Отчество</label>
                <input type="text" name="middlename" maxlength="100" value="<?php echo $v('middlename'); ?>">
            </div>
            <div class="form-row">
                <label>Пол</label>
                <select name="gender">
                    <option value="">— не указан —</option>
                    <option value="Мужской"  <?php echo ($selected['gender'] === 'Мужской'  ? 'selected' : ''); ?>>Мужской</option>
                    <option value="Женский"  <?php echo ($selected['gender'] === 'Женский'  ? 'selected' : ''); ?>>Женский</option>
                </select>
            </div>
            <div class="form-row">
                <label>Дата рождения</label>
                <input type="date" name="birthdate" value="<?php echo $v('birthdate'); ?>">
            </div>
            <div class="form-row">
                <label>Телефон</label>
                <input type="text" name="phone" maxlength="30" value="<?php echo $v('phone'); ?>">
            </div>
            <div class="form-row">
                <label>Адрес</label>
                <input type="text" name="address" maxlength="255" value="<?php echo $v('address'); ?>">
            </div>
            <div class="form-row">
                <label>E-mail</label>
                <input type="email" name="email" maxlength="150" value="<?php echo $v('email'); ?>">
            </div>
            <div class="form-row">
                <label>Комментарий</label>
                <textarea name="comment"><?php echo $v('comment'); ?></textarea>
            </div>

            <button type="submit" class="btn-submit">Сохранить</button>
        </form>
        <?php endif; ?>
    </div>

    <?php endif; ?>
</div>
