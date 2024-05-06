<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .calculadora {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            margin: 0 auto;
        }

        .calculadora h1 {
            margin-bottom: 10px;
            padding-bottom: 10px;
            text-align: center;
            color: #333;
            border-bottom: 2px solid #ccc;
        }

        .calculadora h3 {
            margin-top: 5px;
            text-align: center;
            color: #666;
        }

        input[type="text"],
        select,
        button {
            margin-bottom: 10px;
            padding: 10px;
            width: calc(100% - 20px);
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        body {
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
        }

        .historico {
            background-color: #e0e0e0;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .historico input[type="text"] {
            width: 100%;
            margin-bottom: 5px;
            padding: 5px;
            box-sizing: border-box;
            border: none;
            background-color: #ccc;
            font-weight: bold;
            text-align: center;
        }

        .historico ul {
            list-style-type: none;
            padding: 0;
        }

        .historico li {
            margin-bottom: 5px;
            padding: 5px;
            background-color: #d3d3d3;
            border-radius: 5px;
        }
    </style>
    <title>Calculadora</title>
</head>

<body>
    <div class="calculadora">
        <h1>Calculadora PHP</h1>
        <h3>Alunos: Gabriel Couto, Kayc Chauchuti, Matheus Dias</h3>
        <form method="post" action="">
            <div class="operacoes">
                <input type="text" name="n1" placeholder="Número 1">
                <select name="operator">
                    <option value="+">+</option>
                    <option value="-">-</option>
                    <option value="*">*</option>
                    <option value="/">/</option>
                    <option value="^">^</option>
                    <option value="!">!</option>
                </select>
                <input type="text" name="n2" placeholder="Número 2">
            </div>
            <button type="submit" name="calculate">Calcular</button>
            <button type="button" onclick="retrieveFromMemory()">Memória</button>
        </form>

        <?php
session_start();

if (isset($_POST['calculate'])) {
    $num1 = isset($_POST['n1']) ? $_POST['n1'] : '';
    $num2 = isset($_POST['n2']) ? $_POST['n2'] : '';
    $operator = isset($_POST['operator']) ? $_POST['operator'] : '+';

    
    if (empty($num1) || ($operator !== '!' && empty($num2))) {
        $result = 'Por favor, preencha todos os campos obrigatórios.';
    } else {
        
        if ($operator == '/' && $num2 == 0) {
            $result = 'Divisão por zero não é permitida';
        } else {
            switch ($operator) {
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
                    $result = fatorial($num1);
                    break;
                default:
                    $result = 'Operador inválido';
            }
        }
    }

    $_SESSION['historico'][] = "$num1 $operator $num2 = $result";
    echo "<input type='text' value='$result' readonly>";
}

if (isset($_POST['clearHistory'])) {
    unset($_SESSION['historico']);
}

function fatorial($num)
{
    if ($num === 0 || $num === 1)
        return 1;
    for ($i = $num - 1; $i >= 1; $i--) {
        $num *= $i;
    }
    return $num;
}
?>



        <div class="historico">
            <input type="text" value="HISTÓRICO" readonly>
            <ul>
                <?php if (isset($_SESSION['historico'])): ?>
                    <?php foreach ($_SESSION['historico'] as $operation): ?>
                        <li><?php echo $operation; ?></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
            <form method="post" action="">
                <button type="submit" name="clearHistory">Apagar Histórico</button>
            </form>
        </div>
    </div>

    <script>
        function retrieveFromMemory() {
            var historico = <?php echo json_encode($_SESSION['historico'] ?? null); ?>;
            if (historico && historico.length > 0) {
                var lastOperation = historico[historico.length - 1];
                var parts = lastOperation.split(" ");
                document.querySelector('input[name="n1"]').value = parts[0];
                document.querySelector('select[name="operator"]').value = parts[1];
                document.querySelector('input[name="n2"]').value = parts[2];
            }
        }
    </script>
</body>

</html>
