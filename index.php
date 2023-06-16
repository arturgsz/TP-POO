
<!DOCTYPE html>
<html>
<head>
    <title>Página de Login</title>
</head>
<body>
    <h1>Página de Login</h1>

    <form method="POST">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required>
        <br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <br>

        <input type="submit" name="btn_cadastrar" value="Cadastrar novo usuário">
        <input type="submit" name="btn_login" value="Login">
    </form>

    <?php
    require_once "./src/System.php";
    $aut = new UserAuthenticate();

    function Login($login, $senha) {
        // Aqui você pode adicionar a lógica de autenticação do usuário.
        // Verifique o login e senha fornecidos e realize as ações necessárias.
        // Por exemplo, verificar no banco de dados se as credenciais estão corretas.

        if ($login === "admin" && $senha === "123") {
            echo "Bem-vindo, $login!";
        } else {
            echo "Credenciais inválidas!";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["btn_login"])) {
            $login = $_POST["login"];
            $senha = $_POST["senha"];

           $aut->LogIn($login, $senha);
           echo"\n";
           print_r(Travel::getRecords());


        } elseif (isset($_POST["btn_cadastrar"])) {
            
        }
    }
    ?>
</body>
</html>
