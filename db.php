<?php

$conn = new mysqli("127.0.0.1", "root", "root", "contacts_db");

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$conn->set_charset("utf8");
