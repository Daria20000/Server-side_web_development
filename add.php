<?php
// add.php — форма добавления новой записи

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $lastname   = trim($_POST['lastname']   ?? '');
    $firstname  = trim($_POST['firstname']  ?? '');
    $middlename = trim($_POST['middlename'] ?? '');
    $gender     = trim($_POST['gender']     ?? '');
    $birthdate  = trim($_POST['birthdate']  ?? '');
    $phone      = trim($_POST['phone']      ?? '');
    $address    = trim($_POST['address']    ?? '');
    $email      = trim($_POST['email']      ?? '');
    $comment    = trim($_POST['comment']    ?? '');

    if ($lastname === '' || $firstname === '') {
        $message = '<p class="msg-error">Ошибка: запись не добавлена (фамилия и имя обязательны).</p>';
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO contacts (lastname, firstname, middlename, gender, birthdate, phone, address, email, comment)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            'sssssssss',
            $lastname, $firstname, $middlename, $gender,
            $birthdate, $phone, $address, $email, $comment
        );
        if ($stmt->execute()) {
            $message = '<p class="msg-success">Запись добавлена.</p>';
        } else {
            $message = '<p class="msg-error">Ошибка: запись не добавлена.</p>';
        }
        $stmt->close();
    }
}
?>

<div class="form-container">
    <h2>Добавление записи</h2>
    <?php echo $message; ?>
    <form method="POST" action="index.php?section=add">
        <input type="hidden" name="action" value="add">

        <div class="form-row">
            <label>Фамилия *</label>
            <input type="text" name="lastname" maxlength="100" required>
        </div>
        <div class="form-row">
            <label>Имя *</label>
            <input type="text" name="firstname" maxlength="100" required>
        </div>
        <div class="form-row">
            <label>Отчество</label>
            <input type="text" name="middlename" maxlength="100">
        </div>
        <div class="form-row">
            <label>Пол</label>
            <select name="gender">
                <option value="">— не указан —</option>
                <option value="Мужской">Мужской</option>
                <option value="Женский">Женский</option>
            </select>
        </div>
        <div class="form-row">
            <label>Дата рождения</label>
            <input type="date" name="birthdate">
        </div>
        <div class="form-row">
            <label>Телефон</label>
            <input type="text" name="phone" maxlength="30">
        </div>
        <div class="form-row">
            <label>Адрес</label>
            <input type="text" name="address" maxlength="255">
        </div>
        <div class="form-row">
            <label>E-mail</label>
            <input type="email" name="email" maxlength="150">
        </div>
        <div class="form-row">
            <label>Комментарий</label>
            <textarea name="comment"></textarea>
        </div>

        <button type="submit" class="btn-submit">Добавить</button>
    </form>
</div>
