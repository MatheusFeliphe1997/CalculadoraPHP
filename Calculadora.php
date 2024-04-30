<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    .calculator h1 {
        margin-bottom: 20px;
        text-align: center;
    }

    input[type="text"],
    select,
    button {
        margin-bottom: 10px;
        padding: 8px;
        width: calc(100% - 20px);
    }

    button {
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }


    button:hover {
        background-color: #45a049;
    }

    body {
        background-color: gray;
    }
    </style>
    <title>Calculadora</title>
</head>

<body>
    <div class="calculator">
        <h1>Calculadora PHP</h1>
        <form method="post" action="">
            <input type="text" name="num1" placeholder="Número 1">
            <select name="operator">
                <option value="+">+</option>
                <option value="-">-</option>
                <option value="*">*</option>
                <option value="/">/</option>
                <option value="^">^</option>
                <option value="!">!</option>
            </select>
            <input type="text" name="num2" placeholder="Número 2">
            <button type="submit" name="calculate">Calcular</button>
        </form>

        <input type="text" name="result" value="<?php
            $num1 = $_POST['num1'];
            $operador = $_POST['operator'];
            $num2 = $_POST['num2'];
            $resultado = $_POST['result'];

            echo $num1 . " " . $operador . " " . $num2 . " = " . $resultado;
?>">

        <?php
session_start();

// Função para calcular fatorial
function factorial($num) {
    if ($num === 0 || $num === 1)
        return 1;
    for ($i = $num - 1; $i >= 1; $i--) {
        $num *= $i;
    }
    return $num;
}

if (isset($_POST['calculate'])) {
    $num1 = isset($_POST['num1']) ? $_POST['num1'] : 0;
    $num2 = isset($_POST['num2']) ? $_POST['num2'] : 0;
    $operator = isset($_POST['operator']) ? $_POST['operator'] : '+';

    switch($operator) {
        case '+':
            $result = $num1 + $num2;
            break;
        case '-':
            $result = $num1 - $num2;
            break;
        case '*':
            $result = $num1 * $num2;
            break;
        case '/':
            $result = $num1 / $num2;
            break;
        case '^':
            $result = pow($num1, $num2);
            break;
        case '!':
            $result = factorial($num1);
            break;
        default:
            $result = 'Operador inválido';
    }

    // Salvando o histórico
    $_SESSION['history'][] = "$num1 $operator $num2 = $result";
}

// Botão de memória
if (isset($_POST['memory'])) {
    $_SESSION['memory'] = array(
        'num1' => isset($_POST['num1']) ? $_POST['num1'] : 0,
        'operator' => isset($_POST['operator']) ? $_POST['operator'] : '+',
        'num2' => isset($_POST['num2']) ? $_POST['num2'] : 0
    );
}

// Resgatando valores da memória
if (isset($_POST['retrieve']) && isset($_SESSION['memory'])) {
    $num1 = $_SESSION['memory']['num1'];
    $operator = $_SESSION['memory']['operator'];
    $num2 = $_SESSION['memory']['num2'];
}
?>
        <div class=" history">
            <input type="text" value="HISTÓRICO" readonly>
            <ul>
                <?php if (isset($_SESSION['history'])): ?>
                <?php foreach ($_SESSION['history'] as $operation): ?>
                <li><?php echo $operation; ?></li>
                <?php endforeach; ?>
                <?php endif; ?>
            </ul>
            <form method="post" action="">
                <button type="submit" name="clearHistory">Apagar Histórico</button>
            </form>
        </div>

</body>

</html>