<?php

function getMenu($activeSection = 'view')
{
    $items = [
        'view'   => 'Просмотр',
        'add'    => 'Добавление записи',
        'edit'   => 'Редактирование записи',
        'delete' => 'Удаление записи',
    ];

    $html = '<nav id="submenu">';
    foreach ($items as $key => $label) {
        $active = ($activeSection === $key) ? ' active' : '';
        $html .= '<a href="index.php?section=' . $key . '" class="' . trim($active) . '">' . htmlspecialchars($label) . '</a>';
    }
    $html .= '</nav>';

    return $html;
}

function getSubMenu($activeSort = 'id')
{
    $sorts = [
        'id'        => 'По порядку добавления',
        'lastname'  => 'По фамилии',
        'birthdate' => 'По дате рождения',
    ];

    $html = '';
    foreach ($sorts as $key => $label) {
        $active = ($activeSort === $key) ? ' active' : '';
        $html .= '<a href="index.php?section=view&sort=' . $key . '" class="' . trim($active) . '">' . htmlspecialchars($label) . '</a>';
    }

    return $html;
}
