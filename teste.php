<?php
session_start();

// Verifica se o botão de calcular foi pressionado
if (isset($_POST['calculate'])) {
    // Pega os números e o operador do formulário
    $num1 = $_POST['n1'] ?? '';
    $num2 = $_POST['n2'] ?? '';
    $operator = $_POST['operator'] ?? '+';
    
    // Inicializa a variável de resultado
    $result = '';

    // Verifica se os campos necessários estão preenchidos
    if (empty($num1) || ($operator !== '!' && empty($num2))) {
        $result = 'Por favor, preencha todos os campos obrigatórios.';
    } else {
        // Executa a operação correspondente
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
                // Verifica se o divisor é zero
                if ($num2 == 0) {
                    $result = 'Divisão por zero não é permitida';
                } else {
                    $result = $num1 / $num2;
                }
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

    // Adiciona a operação ao histórico
    $_SESSION['historico'][] = "$num1 $operator $num2 = $result";

    // Exibe o resultado
    echo "<input type='text' value='$result' readonly>";
}

// Função para calcular fatorial
function fatorial($num)
{
    if ($num === 0 || $num === 1)
        return 1;
    for ($i = $num - 1; $i >= 1; $i--) {
        $num *= $i;
    }
    return $num;
}

// Limpa o histórico
if (isset($_POST['clearHistory'])) {
    unset($_SESSION['historico']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Estilos omitidos para simplificação */
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
