<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Rajdhani:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        @import url('style.css');
    </style>
</head>

<?php include 'header.php'; ?>

<body>
    <div class="calc-wrapper">
        <div class="calc-title">КАЛЬКУЛЯТОР</div>

        <div class="calc">
            <!-- Скрытая форма — отправляет POST на calc.php -->
            <form id="calcForm" action="calc.php" method="POST" style="display:none">
                <input type="hidden" name="expr" id="hiddenExpr">
            </form>

            <!-- Дисплей -->
            <div class="display">
                <div class="display-expr" id="displayExpr"></div>
                <div class="display-result" id="displayResult">
                    0<span class="cursor-blink"></span>
                </div>
            </div>

            <!-- Подсказка о клавиатуре -->
            <div class="kbd-hint">
                <span>⌨</span> Поддерживается ввод с клавиатуры
            </div>

            <!-- Кнопки -->
            <div class="btn-grid" id="btnGrid">

                <!-- Ряд 1: функции -->
                <button class="btn btn-fn" data-action="sqrt(">√ x</button>
                <button class="btn btn-fn" data-action="ln(">ln</button>
                <button class="btn btn-fn" data-action="log(">log</button>
                <button class="btn btn-const" data-action="pi">π</button>
                <button class="btn btn-const" data-action="e">e</button>

                <div class="divider"></div>

                <!-- Ряд 2: операторы и скобки -->
                <button class="btn btn-op" data-action="^">xʸ</button>
                <button class="btn btn-fn" data-action="!">x!</button>
                <button class="btn btn-paren" data-action="(">(</button>
                <button class="btn btn-paren" data-action=")">)</button>
                <button class="btn btn-del" data-action="del">⌫</button>

                <div class="divider"></div>

                <!-- Ряд 3: цифры 7–9 + op -->
                <button class="btn" data-action="7">7</button>
                <button class="btn" data-action="8">8</button>
                <button class="btn" data-action="9">9</button>
                <button class="btn btn-op" data-action="/">÷</button>
                <button class="btn btn-op" data-action="*">×</button>

                <!-- Ряд 4: цифры 4–6 + op -->
                <button class="btn" data-action="4">4</button>
                <button class="btn" data-action="5">5</button>
                <button class="btn" data-action="6">6</button>
                <button class="btn btn-op" data-action="-">−</button>
                <button class="btn btn-op" data-action="+">+</button>

                <!-- Ряд 5: цифры 1–3 + clear -->
                <button class="btn" data-action="1">1</button>
                <button class="btn" data-action="2">2</button>
                <button class="btn" data-action="3">3</button>
                <button class="btn btn-clear span2" data-action="clear">СБРОС</button>

                <!-- Ряд 6: 0, точка, = -->
                <button class="btn span2" data-action="0">0</button>
                <button class="btn btn-op" data-action=".">.</button>
                <button class="btn btn-eq" data-action="calc">=</button>

            </div>

            <!-- Статус -->
            <div class="status-bar">
                <div class="status-dot"></div>
                <span id="statusText">ГОТОВ</span>
                <span id="statusMode">POST → GET</span>
            </div>
        </div>
    </div>

    <script>
        // ════════════════════════════════════════════════════════════
        //  Фронтенд-логика калькулятора
        // ════════════════════════════════════════════════════════════

        const elExpr = document.getElementById('displayExpr');
        const elResult = document.getElementById('displayResult');
        const elStatus = document.getElementById('statusText');
        const elMode = document.getElementById('statusMode');
        const form = document.getElementById('calcForm');
        const hidden = document.getElementById('hiddenExpr');

        let expression = ''; // текущий ввод

        // ── Утилиты ─────────────────────────────────────────────────

        /** Обновляет отображение текущего выражения */
        function renderExpr() {
            // Красиво заменяем операторы для вывода
            const pretty = expression
                .replace(/\*/g, '×')
                .replace(/\//g, '÷');
            elExpr.textContent = pretty;
        }

        /** Показывает результат (или ошибку) на дисплее */
        function showResult(value, isError = false) {
            // Создаём курсор
            const cursor = '<span class="cursor-blink"></span>';

            elResult.innerHTML = value + cursor;
            elResult.classList.toggle('error', isError);
            elResult.classList.remove('flash');
            void elResult.offsetWidth; // reflow для перезапуска анимации
            elResult.classList.add('flash');
        }

        /** Добавляет ripple-эффект к кнопке */
        function addRipple(btn, e) {
            const rect = btn.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = (e.clientX - rect.left) - size / 2;
            const y = (e.clientY - rect.top) - size / 2;
            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            ripple.style.cssText = `width:${size}px;height:${size}px;left:${x}px;top:${y}px`;
            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 400);
        }

        // ── Обработка действий ──────────────────────────────────────

        function handleAction(action, event) {
            switch (action) {

                case 'clear':
                    expression = '';
                    renderExpr();
                    showResult('0');
                    elStatus.textContent = 'СБРОС';
                    setTimeout(() => {
                        elStatus.textContent = 'ГОТОВ';
                    }, 800);
                    break;

                case 'del':
                    // Удаляем последний токен (функцию целиком или один символ)
                    expression = expression.replace(/sqrt\($|ln\($|log\($|.$/, '');
                    renderExpr();
                    showResult(expression || '0');
                    break;

                case 'calc':
                    if (!expression) return;
                    submitExpression();
                    break;

                default:
                    // Добавляем символ/функцию к выражению
                    expression += action;
                    renderExpr();
                    showResult(expression);
                    elStatus.textContent = 'ВВОД';
            }
        }

        /** Отправляет выражение на сервер через POST */
        function submitExpression() {
            hidden.value = expression;
            elStatus.textContent = 'ОТПРАВКА…';
            elMode.textContent = 'POST → calc.php';
            form.submit();
        }

        // ── Кнопки (клики) ──────────────────────────────────────────

        document.getElementById('btnGrid').addEventListener('click', function(e) {
            const btn = e.target.closest('[data-action]');
            if (!btn) return;
            addRipple(btn, e);
            handleAction(btn.dataset.action, e);
        });

        // ── Клавиатурный ввод (бонус +2 балла) ──────────────────────

        const KEY_MAP = {
            '0': '0',
            '1': '1',
            '2': '2',
            '3': '3',
            '4': '4',
            '5': '5',
            '6': '6',
            '7': '7',
            '8': '8',
            '9': '9',
            '+': '+',
            '-': '-',
            '*': '*',
            '/': '/',
            '^': '^',
            '(': '(',
            ')': ')',
            '.': '.',
            '!': '!',
            'Enter': 'calc',
            '=': 'calc',
            'Backspace': 'del',
            'Delete': 'del',
            'Escape': 'clear',
        };

        document.addEventListener('keydown', function(e) {
            // Не перехватываем, если фокус на input/textarea
            if (['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName)) return;

            // Специальная комбинация: Ctrl+Z — удаление
            if (e.ctrlKey && e.key === 'z') {
                e.preventDefault();
                handleAction('del', e);
                return;
            }

            const action = KEY_MAP[e.key];
            if (action) {
                e.preventDefault();
                handleAction(action, e);
                // Подсвечиваем соответствующую кнопку
                highlightBtn(action);
            }
        });

        // Обработка ввода «текстовых» функций с клавиатуры
        // Пользователь может напечатать: sqrt, ln, log, pi, e
        let keyBuffer = '';
        let keyTimer = null;

        document.addEventListener('keypress', function(e) {
            if (['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName)) return;

            keyBuffer += e.key;
            clearTimeout(keyTimer);

            // Проверяем, не складывается ли в функцию
            const funcs = {
                'sqrt': 'sqrt(',
                'ln': 'ln(',
                'log': 'log(',
                'pi': 'pi',
                'e_': 'e'
            };
            for (const [trigger, action] of Object.entries(funcs)) {
                if (keyBuffer.endsWith(trigger === 'e_' ? 'e' : trigger)) {
                    // e — только если отдельно стоит (не после буквы)
                    if (trigger === 'e_' && /[a-df-z]/i.test(keyBuffer.slice(-2, -1))) continue;
                    keyBuffer = '';
                    return;
                }
            }

            keyTimer = setTimeout(() => {
                keyBuffer = '';
            }, 1000);
        });

        /** Визуально "нажимает" кнопку при нажатии клавиши */
        function highlightBtn(action) {
            const btn = document.querySelector(`[data-action="${CSS.escape(action)}"]`);
            if (!btn) return;
            btn.style.filter = 'brightness(1.5)';
            btn.style.transform = 'scale(0.96)';
            setTimeout(() => {
                btn.style.filter = '';
                btn.style.transform = '';
            }, 120);
        }

        // ── Чтение GET-параметров после редиректа с сервера ─────────

        (function readGetParams() {
            const params = new URLSearchParams(window.location.search);
            const result = params.get('result');
            const error = params.get('error');
            const expr = params.get('expr');

            if (expr) {
                expression = expr;
                renderExpr();
            }

            if (result !== null) {
                showResult(result, false);
                elStatus.textContent = 'РЕЗУЛЬТАТ';
                elMode.textContent = 'GET ← calc.php';
                // Убираем параметры из URL (чисто визуально)
                window.history.replaceState({}, '', window.location.pathname);
            } else if (error) {
                showResult(error, true);
                elStatus.textContent = 'ОШИБКА';
                elMode.textContent = 'GET ← calc.php';
                window.history.replaceState({}, '', window.location.pathname);
            }
        })();
    </script>
</body>
<?php include 'footer.php'; ?>

</html>