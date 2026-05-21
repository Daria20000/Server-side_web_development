<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Лабораторная работа №4.1 — Feedback form</title>
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: #f5f5f5;
            color: #1a1a1a;
        }

        .card.large {
            max-width: 680px;
            width: 100%;
        }

        .card h2 {
            margin-bottom: 16px;
            text-align: center;
        }

        .result {
            width: 100%;
            min-height: 260px;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-family: monospace;
            font-size: 13px;
            line-height: 1.4;
            background: #f9fafc;
            resize: none;
        }

        .result:focus {
            outline: none;
            border-color: #4a90e2;
        }
    </style>
</head>

<body>

    <?php
    include 'header.php';

    $url = 'https://httpbin.org/post';
    $headers = get_headers($url, true);

    $output = '';
    if ($headers === false) {
        $output = 'Не удалось получить заголовки для: ' . $url;
    } else {
        $output .= 'URL: ' . $url . "\n";
        $output .= str_repeat('-', 60) . "\n";
        foreach ($headers as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    $output .= (is_int($key) ? '' : $key . ': ') . $v . "\n";
                }
            } else {
                $output .= (is_int($key) ? '' : $key . ': ') . $value . "\n";
            }
        }
    }
    ?>

    <main>
        <div class="card" style="max-width: 680px;">
            <h2>Результат get_headers()</h2>
            <textarea class="result" readonly><?= htmlspecialchars($output) ?></textarea>
            <div class="actions" style="margin-top: 16px;">
                <a href="index.php" class="btn btn-secondary">← Вернуться к форме</a>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>

</html>