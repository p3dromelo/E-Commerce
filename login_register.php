<?php
session_start();
require_once 'assets/includes/config.php'; // Certifique-se de que este arquivo define $conn corretamente

// Função para sanitizar entradas
function sanitizeInput($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

// === REGISTRO DE NOVO USUÁRIO ===
if (isset($_POST['register'])) {
    // Verifica se todos os campos foram preenchidos
    if (empty($_POST['FullName']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['repeat-password']) || empty($_POST['role'])) {
        $_SESSION['register_error'] = 'Preencha todos os campos.';
        $_SESSION['active_form'] = 'register';
        header("Location: index.php");
        exit();
    }

    $name = sanitizeInput($_POST['FullName']);
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat-password'];
    $role = sanitizeInput($_POST['role']);

    // Verifica formato do e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = 'E-mail inválido.';
        $_SESSION['active_form'] = 'register';
        header("Location: index.php");
        exit();
    }

    // Verifica tamanho da senha
    if (strlen($password) < 6) {
        $_SESSION['register_error'] = 'A senha deve ter pelo menos 6 caracteres.';
        $_SESSION['active_form'] = 'register';
        header("Location: index.php");
        exit();
    }

    // Verifica se as senhas coincidem
    if ($password !== $repeat_password) {
        $_SESSION['register_error'] = 'As senhas não coincidem.';
        $_SESSION['active_form'] = 'register';
        header("Location: index.php");
        exit();
    }

    // Verifica se o e-mail já está cadastrado
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $_SESSION['register_error'] = 'Este e-mail já está registrado!';
        $_SESSION['active_form'] = 'register';
        $stmt->close();
        header("Location: index.php");
        exit();
    }
    $stmt->close();


    // Criptografa a senha
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insere o novo usuário
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $passwordHash, $role);

    if ($stmt->execute()) {
        $_SESSION['register_success'] = 'Cadastro realizado com sucesso!';
        $stmt->close();
        header("Location: http://localhost/PIM_VI_Ordep_Store/assets/includes/register_success.php");
        exit();
    } else {
        $_SESSION['register_error'] = 'Erro ao registrar usuário.';
        $stmt->close();
    }
}

// === LOGIN DE USUÁRIO ===
if (isset($_POST['login'])) {
    // Verifica se campos foram preenchidos
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $_SESSION['login_error'] = 'Preencha todos os campos.';
        $_SESSION['active_form'] = 'login';
        header("Location: index.php");
        exit();
    }

    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Autenticação bem-sucedida
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: admin_page.php");
            } else {
                header("Location: user_page.php");
            }
            exit();
        } else {
            $_SESSION['login_error'] = 'Senha incorreta.';
        }
    } else {
        $_SESSION['login_error'] = 'E-mail não encontrado.';
    }

    $_SESSION['active_form'] = 'login';
    $stmt->close();
    header("Location: /PIM_VI_Ordep_Store/index.php");
    exit();
}
?>
