
<?php
session_start();
require_once('./controller/processar_cadastro.php');
require_once('./database/ConexaoPdo.php');
if (isset($_POST['username']) && isset($_POST['password'])) {
    $cone = new DatabaseConnection();
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $usuario = new clienteController($cone->connect());
   $autenticado =  $usuario->usuarioAutenticado($username,$password);
    if ($autenticado) {
        $_SESSION['username'] = $username;
        $_SESSION['loggedin'] = true;
        $_SESSION['USER'] = true;
        $_SESSION['id'] = $autenticado['id'];

        if ($usuario->VerfificarClienteADM($username)) {
            $_SESSION['ADM'] = true;  
        }
        header("Location:home.php");
        exit;
    } else {
        header("Location: login.php?error=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="./css/geral.css" >
    <link rel="stylesheet" href="./css/menu.css">
    <link rel="shortcut icon" type="imagex/png" href="./assets/icone.ico">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo '<p class="error-message">Credenciais inválidas. Tente novamente.</p>';
        }
        ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Login">
        </form>
    </div>
    <footer>
        <p>© 2023 Meu Site. Todos os direitos reservados.</p>
    </footer>
</body>
</html>