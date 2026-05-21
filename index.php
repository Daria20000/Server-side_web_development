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

    /* Базовый сброс */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    body {
      background: #f4f6f9;
    }

    /* Центрирование */
    main {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Карточка */
    .card {
      background: #ffffff;
      padding: 30px;
      border-radius: 12px;
      width: 420px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .card h2 {
      margin-bottom: 20px;
      text-align: center;
    }

    /* Группы */
    .form-group {
      margin-bottom: 18px;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      font-size: 14px;
      color: #333;
    }

    /* Inputs */
    input,
    select,
    textarea {
      width: 100%;
      padding: 10px 12px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 14px;
      transition: 0.2s;
    }

    textarea {
      min-height: 100px;
      resize: vertical;
    }

    input:focus,
    select:focus,
    textarea:focus {
      border-color: #4a90e2;
      outline: none;
    }

    /* Чекбоксы */
    .checkbox-group {
      display: flex;
      gap: 15px;
    }

    .checkbox-group label {
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    /* Кнопки */
    .actions {
      margin-top: 20px;
      display: flex;
      justify-content: space-between;
      gap: 10px;
    }

    .btn {
      flex: 1;
      text-align: center;
      padding: 10px;
      border-radius: 8px;
      text-decoration: none;
      font-size: 14px;
      transition: 0.2s;
      border: none;
      cursor: pointer;
    }

    /* Primary */
    .btn-primary {
      background: #4a90e2;
      color: white;
    }

    .btn-primary:hover {
      background: #357abd;
    }

    /* Secondary */
    .btn-secondary {
      background: #e0e0e0;
      color: #333;
    }

    .btn-secondary:hover {
      background: #cfcfcf;
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?>
  <main>
    <div class="card">
      <h2>Обратная связь</h2>

      <form action="https://httpbin.org/post" method="POST">

        <div class="form-group">
          <label for="name">Имя пользователя</label>
          <input type="text" id="name" name="name" placeholder="Иванов Иван Иванович" required />
        </div>

        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" placeholder="example@mail.ru" required />
        </div>

        <div class="form-group">
          <label for="type">Тип обращения</label>
          <select id="type" name="type" required>
            <option value="" disabled selected>— Выберите тип —</option>
            <option value="complaint">Жалоба</option>
            <option value="suggestion">Предложение</option>
            <option value="gratitude">Благодарность</option>
          </select>
        </div>

        <div class="form-group">
          <label for="message">Текст обращения</label>
          <textarea id="message" name="message" placeholder="Опишите ваше обращение..." required></textarea>
        </div>

        <div class="form-group">
          <label>Вариант ответа</label>
          <div class="checkbox-group">
            <label>
              <input type="checkbox" name="reply[]" value="sms" />
              СМС
            </label>
            <label>
              <input type="checkbox" name="reply[]" value="email" />
              Email
            </label>
          </div>
        </div>

        <div class="actions">
          <button type="submit" class="btn btn-primary">Отправить</button>
          <a href="page2.php" class="btn btn-secondary">Перейти на страницу 2 →</a>
        </div>

      </form>
    </div>
  </main>

  <?php include 'footer.php'; ?>

</body>

</html>