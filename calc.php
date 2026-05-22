<?php

function calc_add(float $a, float $b): float
{
    return $a + $b;
}
function calc_sub(float $a, float $b): float
{
    return $a - $b;
}
function calc_mul(float $a, float $b): float
{
    return $a * $b;
}

function calc_div(float $a, float $b): float
{
    if ($b == 0) throw new RuntimeException('Деление на ноль');
    return $a / $b;
}

function calc_pow(float $a, float $b): float
{
    return $a ** $b;
}

function calc_sqrt(float $a): float
{
    if ($a < 0) throw new RuntimeException('Корень из отрицательного числа');
    return sqrt($a);
}

function calc_ln(float $a): float
{
    if ($a <= 0) throw new RuntimeException('ln не определён для числа ≤ 0');
    return log($a);
}

function calc_log10(float $a): float
{
    if ($a <= 0) throw new RuntimeException('log не определён для числа ≤ 0');
    return log10($a);
}

function calc_factorial(float $n): float
{
    $n = (int)$n;
    if ($n < 0)  throw new RuntimeException('Факториал отрицательного числа не определён');
    if ($n <= 1) return 1;
    return calc_mul($n, calc_factorial($n - 1));
}

function tokenize(string $expr): array
{
    $pattern = '/(\d+\.?\d*|sqrt|ln|log|pi\b|e\b|[+\-*\/^()!])/u';
    preg_match_all($pattern, $expr, $matches);
    return $matches[1];
}

class Parser
{
    private array $tokens;
    private int   $pos = 0;

    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
    }

    private function peek(): ?string
    {
        return $this->tokens[$this->pos] ?? null;
    }

    private function consume(): string
    {
        $t = $this->tokens[$this->pos] ?? null;
        if ($t === null) throw new RuntimeException('Неожиданный конец выражения');
        $this->pos++;
        return $t;
    }

    private function expect(string $expected): void
    {
        $t = $this->consume();
        if ($t !== $expected)
            throw new RuntimeException("Ожидалось $expected, получено $t");
    }

    public function parse(): float
    {
        $val = $this->parseExpr();
        if ($this->peek() !== null)
            throw new RuntimeException('Лишние символы после выражения: ' . $this->peek());
        return $val;
    }


    private function parseExpr(): float
    {
        $left = $this->parseTerm();
        while (($op = $this->peek()) === '+' || $op === '-') {
            $this->consume();
            $right = $this->parseTerm();
            $left  = ($op === '+') ? calc_add($left, $right) : calc_sub($left, $right);
        }
        return $left;
    }


    private function parseTerm(): float
    {
        $left = $this->parseFactor();
        while (($op = $this->peek()) === '*' || $op === '/') {
            $this->consume();
            $right = $this->parseFactor();
            $left  = ($op === '*') ? calc_mul($left, $right) : calc_div($left, $right);
        }
        return $left;
    }


    private function parseFactor(): float
    {
        $base = $this->parseBase();
        if ($this->peek() === '^') {
            $this->consume();
            $exp = $this->parseFactor();
            return calc_pow($base, $exp);
        }
        return $base;
    }


    private function parseBase(): float
    {
        $val = $this->parseUnary();
        while ($this->peek() === '!') {
            $this->consume();
            $val = calc_factorial($val);
        }
        return $val;
    }


    private function parseUnary(): float
    {
        if ($this->peek() === '-') {
            $this->consume();
            return calc_mul(-1, $this->parseUnary());
        }
        return $this->parsePrimary();
    }


    private function parsePrimary(): float
    {
        $t = $this->peek();

        if ($t === null)
            throw new RuntimeException('Неожиданный конец выражения');


        if ($t === 'pi') {
            $this->consume();
            return M_PI;
        }
        if ($t === 'e') {
            $this->consume();
            return M_E;
        }


        if (in_array($t, ['sqrt', 'ln', 'log'], true)) {
            $this->consume();
            $this->expect('(');
            $arg = $this->parseExpr();
            $this->expect(')');
            return match ($t) {
                'sqrt' => calc_sqrt($arg),
                'ln'   => calc_ln($arg),
                'log'  => calc_log10($arg),
            };
        }


        if ($t === '(') {
            $this->consume();
            $val = $this->parseExpr();
            $this->expect(')');
            return $val;
        }


        if (is_numeric($t)) {
            $this->consume();
            return (float)$t;
        }

        throw new RuntimeException("Неизвестный токен: $t");
    }
}



function validate_expr(string $expr): void
{
    if (!preg_match('/^[\d\s\+\-\*\/\^\(\)\.!sqrtnlogpie]+$/u', $expr)) {
        throw new RuntimeException('Выражение содержит недопустимые символы');
    }

    $depth = 0;
    for ($i = 0; $i < strlen($expr); $i++) {
        if ($expr[$i] === '(') $depth++;
        elseif ($expr[$i] === ')') {
            $depth--;
            if ($depth < 0) throw new RuntimeException('Лишняя закрывающая скобка');
        }
    }
    if ($depth !== 0) throw new RuntimeException('Незакрытая открывающая скобка');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw  = trim($_POST['expr'] ?? '');
    $back = $_SERVER['HTTP_REFERER'] ?? 'index.html';

    if ($raw === '') {
        header('Location: ' . $back . '?error=' . urlencode('Введите выражение'));
        exit;
    }


    $expr = preg_replace('/\s+/', '', $raw);

    try {
        validate_expr($expr);
        $tokens = tokenize($expr);
        $parser = new Parser($tokens);
        $result = $parser->parse();


        $formatted = rtrim(rtrim(number_format($result, 10, '.', ''), '0'), '.');

        header('Location: ' . $back . '?result=' . urlencode($formatted)
            . '&expr='   . urlencode($raw));
    } catch (RuntimeException $e) {
        header('Location: ' . $back . '?error=' . urlencode($e->getMessage())
            . '&expr='  . urlencode($raw));
    }
    exit;
}


header('Location: index.html');
exit;
