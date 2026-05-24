<?php

function getViewer($conn, $sort = 'id', $page = 1)
{
    $perPage = 10;
    $offset  = ($page - 1) * $perPage;

    switch ($sort) {
        case 'lastname':
            $orderBy = 'lastname ASC, firstname ASC';
            break;
        case 'birthdate':
            $orderBy = 'birthdate ASC';
            break;
        default:
            $orderBy = 'id ASC';
    }

    $countResult = $conn->query("SELECT COUNT(*) AS cnt FROM contacts");
    $total = 0;
    if ($countResult) {
        $row   = $countResult->fetch_assoc();
        $total = (int)$row['cnt'];
    }

    $totalPages = max(1, ceil($total / $perPage));
    if ($page > $totalPages) $page = $totalPages;
    $offset = ($page - 1) * $perPage;

    // Fetch records
    $stmt = $conn->prepare(
        "SELECT id, lastname, firstname, middlename, gender, birthdate, phone, address, email, comment
         FROM contacts
         ORDER BY $orderBy
         LIMIT ? OFFSET ?"
    );
    $stmt->bind_param('ii', $perPage, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $html = '';

    if ($total === 0) {
        $html .= '<p style="color:#888; margin-top:20px;">База данных пуста. Добавьте первую запись.</p>';
        return $html;
    }

    // Table
    $html .= '<table>';
    $html .= '<thead><tr>
        <th>#</th>
        <th>Фамилия</th>
        <th>Имя</th>
        <th>Отчество</th>
        <th>Пол</th>
        <th>Дата рождения</th>
        <th>Телефон</th>
        <th>Адрес</th>
        <th>E-mail</th>
        <th>Комментарий</th>
    </tr></thead><tbody>';

    $num = $offset + 1;
    while ($row = $result->fetch_assoc()) {
        $bd = $row['birthdate'] ? date('d.m.Y', strtotime($row['birthdate'])) : '—';
        $html .= '<tr>';
        $html .= '<td>' . $num++ . '</td>';
        $html .= '<td>' . htmlspecialchars($row['lastname'])   . '</td>';
        $html .= '<td>' . htmlspecialchars($row['firstname'])  . '</td>';
        $html .= '<td>' . htmlspecialchars($row['middlename']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['gender'])     . '</td>';
        $html .= '<td>' . htmlspecialchars($bd)                . '</td>';
        $html .= '<td>' . htmlspecialchars($row['phone'])      . '</td>';
        $html .= '<td>' . htmlspecialchars($row['address'])    . '</td>';
        $html .= '<td>' . htmlspecialchars($row['email'])      . '</td>';
        $html .= '<td>' . htmlspecialchars($row['comment'])    . '</td>';
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';

    // Pagination
    if ($totalPages > 1) {
        $html .= '<div class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $active = ($i === $page) ? ' active' : '';
            $html .= '<a href="index.php?section=view&sort=' . htmlspecialchars($sort) . '&page=' . $i . '" class="' . trim($active) . '">' . $i . '</a>';
        }
        $html .= '</div>';
    }

    $stmt->close();
    return $html;
}
