<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Лабораторная работа №2.1 — Hello, World!</title>
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

    /* ───── HEADER ───── */
    header {
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      padding: 14px 24px;
      background: rgb(46, 46, 46);
      border-bottom: 1px solid #e0e0e0;
      min-height: 68px;
    }

    .logo-wrap {
      position: absolute;
      left: 24px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo-wrap img {
      height: 40px;
      width: auto;
      display: block;
    }

    .header-title {
      font-size: 15px;
      font-weight: 600;
      text-align: center;
      color: #dedede;
      max-width: 800px;
      line-height: 1.4;
    }

    /* ───── MAIN ───── */
    main {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px 24px;
      gap: 24px;
    }

    .greeting-card {
      background: #ffffff;
      border: 1px solid #e0e0e0;
      border-radius: 12px;
      padding: 32px 40px;
      text-align: center;
      width: 100%;
      max-width: 480px;
    }

    .greeting-text {
      font-size: 28px;
      font-weight: 600;
      color: #1a1a1a;
      margin-bottom: 6px;
      transition: opacity 0.3s ease;
    }

    .greeting-sub {
      font-size: 13px;
      color: #888;
      margin-bottom: 24px;
    }

    .counter-row {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
    }

    .counter-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      border: 1px solid #ccc;
      background: transparent;
      cursor: pointer;
      font-size: 20px;
      line-height: 1;
      color: #1a1a1a;
      transition: background 0.15s;
    }

    .counter-btn:hover {
      background: #f0f0f0;
    }

    .counter-val {
      font-size: 24px;
      font-weight: 600;
      min-width: 48px;
      text-align: center;
      color: #1a1a1a;
    }

    .counter-label {
      font-size: 12px;
      color: #aaa;
      margin-top: 8px;
    }

    .time-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #e8f0fb;
      color: #1a5abf;
      font-size: 14px;
      font-weight: 500;
      padding: 7px 18px;
      border-radius: 8px;
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?>
  <main>
    <div class="greeting-card">
      <div class="greeting-text" id="hello">Hello, World! 👋</div>
      <div class="greeting-sub">Динамический HTML-элемент</div>

      <div class="counter-row">
        <button class="counter-btn" onclick="change(-1)" aria-label="Уменьшить">−</button>
        <span class="counter-val" id="count">0</span>
        <button class="counter-btn" onclick="change(1)" aria-label="Увеличить">+</button>
      </div>
      <div class="counter-label">счётчик кликов</div>
    </div>

    <div class="time-badge">
      🕐 <span id="clock">--:--:--</span>
    </div>
  </main>

  <?php include 'footer.php'; ?>

  <script>
    let count = 0;

    function change(delta) {
      count += delta;
      document.getElementById('count').textContent = count;

      const el = document.getElementById('hello');
      el.style.opacity = '0';
      setTimeout(function() {
        if (count === 0) {
          el.textContent = 'Hello, World! 👋';
        } else if (count > 0) {
          el.textContent = 'Привет × ' + count;
        } else {
          el.textContent = 'Минус ' + Math.abs(count);
        }
        el.style.opacity = '1';
      }, 200);
    }

    function tick() {
      document.getElementById('clock').textContent =
        new Date().toLocaleTimeString('ru-RU');
    }

    tick();
    setInterval(tick, 1000);
  </script>

</body>

</html>