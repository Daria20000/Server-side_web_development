<?php
// delete.php — удаление записи

$deleteMessage = '';

// Handle deletion via GET param
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);

    if ($deleteId > 0) {
        // Fetch lastname before deleting
        $stmt = $conn->prepare("SELECT lastname FROM contacts WHERE id=?");
        $stmt->bind_param('i', $deleteId);
        $stmt->execute();
        $res = $stmt->get_result();
        $rec = $res->fetch_assoc();
        $stmt->close();

        if ($rec) {
            $deletedLastname = $rec['lastname'];
            $stmt = $conn->prepare("DELETE FROM contacts WHERE id=?");
            $stmt->bind_param('i', $deleteId);
            if ($stmt->execute()) {
                $deleteMessage = '<div class="delete-msg">Запись с фамилией <strong>' . htmlspecialchars($deletedLastname) . '</strong> удалена.</div>';
            } else {
                $deleteMessage = '<div class="delete-msg" style="border-color:#888;">Ошибка при удалении записи.</div>';
            }
            $stmt->close();
        }
    }
}

// Fetch remaining contacts (sorted by lastname, firstname)
$contacts = [];
$listResult = $conn->query("SELECT id, lastname, firstname, middlename FROM contacts ORDER BY lastname ASC, firstname ASC");
if ($listResult) {
    while ($row = $listResult->fetch_assoc()) {
        $contacts[] = $row;
    }
}
?>

<div style="max-width: 700px;">
    <h2 style="color:#1a2a4a; font-weight:normal; letter-spacing:1px; margin-bottom:16px; border-bottom:1px solid #e0d8c8; padding-bottom:10px;">Удаление записи</h2>

    <?php echo $deleteMessage; ?>

    <?php if (empty($contacts)): ?>
        <p style="color:#888;">База данных пуста. Нечего удалять.</p>
    <?php else: ?>
        <p style="color:#666; font-size:0.88rem; margin-bottom:14px;">Нажмите на имя контакта, чтобы удалить его из базы данных.</p>
        <div class="record-list">
            <?php foreach ($contacts as $c): ?>
                <?php
                // Format: Фамилия И.О.
                $initials = '';
                if (!empty($c['firstname'])) {
                    $initials .= mb_strtoupper(mb_substr($c['firstname'], 0, 1)) . '.';
                }
                if (!empty($c['middlename'])) {
                    $initials .= mb_strtoupper(mb_substr($c['middlename'], 0, 1)) . '.';
                }
                $label = htmlspecialchars($c['lastname']);
                if ($initials) $label .= ' ' . htmlspecialchars($initials);
                ?>
                <a href="index.php?section=delete&delete_id=<?php echo $c['id']; ?>"
                   onclick="return confirm('Удалить запись «<?php echo htmlspecialchars($c['lastname']); ?>»?');">
                    <?php echo $label; ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
