<?php
session_start();

// Captura de erros de login e registro da sessão
$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];

// Captura mensagem de sucesso (por exemplo, após registro)
$success = $_SESSION['register_success'] ?? '';

// Definindo qual formulário está ativo
$activeForm = $_SESSION['active_form'] ?? 'login';

// Limpa apenas as variáveis de sessão usadas
unset($_SESSION['login_error'], $_SESSION['register_error'], $_SESSION['active_form'], $_SESSION['register_success']);

// Função para mostrar mensagens de erro
function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

// Função para mostrar mensagens de sucesso
function showSuccess($message) {
    return !empty($message) ? "<p class='success-message'>$message</p>" : '';
}

// Função para verificar qual formulário está ativo
function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIM VI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style_login.css">
    <script type="text/javascript" src="assets/js/validation.js" defer></script>
</head>
<body>
    <div class="container">
        <!-- Formulário de Login -->
        <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
            <form id="form" action="login_register.php" method="post">
                <h2>LOGIN</h2>
                <?= showError($errors['login']); ?>
                <!-- E-mail Login -->        
                <div class="input-group">
                <label for="email-input">                        
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                        <path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480v58q0 59-40.5 100.5T740-280q-35 0-66-15t-52-43q-29 29-65.5 43.5T480-280q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480v58q0 26 17 44t43 18q26 0 43-18t17-44v-58q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93h200v80H480Zm0-280q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Z"/>
                    </svg>
                </label>
            <input type="email" name="email" id="email-input" placeholder="E-mail" required>
</div> 
                <!-- Senha Login--> 
                <div class="input-group">
                <label for="password-input">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                        <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/>
                    </svg>
                </label>
                <div class="password-wrapper">
                     <input type="password" name="password" id="password-input-login" placeholder="Senha" required>
                     <i class="fas fa-eye toggle-password" data-target="password-input-login"></i>
</div>
</div>

                <button type="submit" name="login">Login</button>
                <p>Não possui uma conta? <a href="#" onclick="showForm('register-form')">Cadastrar-se</a></p>
            </form>
        </div>

        <!-- Formulário de Registro -->
        <div class="form-box <?= isActiveForm('register', $activeForm); ?>" id="register-form">
            <form action="login_register.php" method="post">
            
                <h2>REGISTRAR-SE</h2>
                <?= showSuccess($success); ?>
                <?= showError($errors['register']); ?>
                    <!-- Campo do Nome -->
                    <div class="input-group">
                 <label for="fname-input">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                        <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Z"/>
                    </svg>
                </label>
             <input type="text" name="FullName" id="fname-input" placeholder="Nome Completo" required>
</div>

                    <!-- Campo do E-mail -->        
                    <div class="input-group">
                <label for="email-input">                        
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                        <path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480v58q0 59-40.5 100.5T740-280q-35 0-66-15t-52-43q-29 29-65.5 43.5T480-280q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480v58q0 26 17 44t43 18q26 0 43-18t17-44v-58q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93h200v80H480Zm0-280q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Z"/>
                    </svg>
                </label>
            <input type="email" name="email" id="email-input" placeholder="E-mail" required>
</div>
                    <!-- Campo da Senha --> 
                    <div class="input-group">
                <label for="password-input">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                        <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/>
                    </svg>
                </label>
                <div class="password-wrapper">
                     <input type="password" name="password" id="password-input-register" placeholder="Senha" required>
                     <i class="fas fa-eye toggle-password" data-target="password-input-register"></i>
</div>
</div>

                    <!-- Repetir Senha--> 
                     <div class="input-group">
                <label for="repeat-password-input">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                        <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/>
                    </svg>
                </label>
                <div class="password-wrapper">
                     <input type="password" name="repeat-password" id="repeat-password-input" placeholder="Repetir Senha" required>
                     <i class="fas fa-eye toggle-password" data-target="repeat-password-input"></i>
</div>
</div>
                   <!-- Tipo de Conta -->
                    <div class="input-group">
                <label for ="role-select">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                        <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q14-36 44-58t68-22q38 0 68 22t44 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm280-670q13 0 21.5-8.5T510-820q0-13-8.5-21.5T480-850q-13 0-21.5 8.5T450-820q0 13 8.5 21.5T480-790Zm0 350q58 0 99-41t41-99q0-58-41-99t-99-41q-58 0-99 41t-41 99q0 58 41 99t99 41ZM200-200h560v-46q-54-53-125.5-83.5T480-360q-83 0-154.5 30.5T200-246v46Z"/>
                    </svg>
                </label>
                <select id="role-select" name="role" required>
                    <option value="">--Selecione o tipo de conta--</option>
                    <option value="user">Usuário</option>
                    <option value="admin">Administrador</option>
                </select>
</div>
                <!-- Botão Cadastrar-se -->
                <button type="submit" name="register">Cadastrar-se</button>
                <p>Já possui uma conta? <a href="#" onclick="showForm('login-form')">Login</a></p>
            </form>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
