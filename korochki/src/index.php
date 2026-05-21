<?php
require 'conn_db.php';

$error = "";
$success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $fio = $_POST['fio'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    

    if (strlen($login) < 6 && !preg_match('/[а-яА-Я]/', $login)) {
        $error = "Логин должен быть минимум 6 символов и содержать кириллицу";
    }elseif (strlen($password) < 6) {
        $error = "Пароль должен быть минимум 6 символов";
    }elseif(!preg_match("/[а-яА-Я]/", $fio)){
        $error = "фио должно быть кириллицой";
    }else {
        $check_sql = "SELECT ID FROM USER WHERE Login = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Этот логин уже занят";
        } else {
            $sql = "INSERT INTO USER (FIO, Phone, Email, Login, Password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $fio, $phone, $email, $login, $password);
            
            if ($stmt->execute()) {
                $success = "Регистрация успешна!";
                header("main_page.php");
            } else {
                $error = "Ошибка при регистрации: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Регистрация</h3>
                    </div>
                    <div class="card-body">                        
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="fio" class="form-label">ФИО</label>
                                <input type="text" class="form-control" id="fio" name="fio" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Телефон</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="login" class="form-label">Логин (минимум 6 символов кириллицей)</label>
                                <input type="text" class="form-control" id="login" name="login" required 
                                       pattern=".*[а-яА-Я].*" minlength="6">
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль (минимум 6 символов)</label>
                                <input type="password" class="form-control" id="password" name="password" required 
                                       minlength="6">
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="auto.php">Уже есть аккаунт? Войти</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const fioInput = document.getElementById('fio');
    const loginInput = document.getElementById('login');
    const passwordInput = document.getElementById('password');
    const phoneInput = document.getElementById('phone');
    const emailInput = document.getElementById('email');
    const form = document.querySelector('form');


    const cyrillicRegex = /^[а-яА-ЯёЁ\s\-]+$/;
    const loginRegex = /^[а-яА-ЯёЁ\s\-]{6,}$/;
    const phoneRegex = /^[\d\s\-\+\(\)]{10,}$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


    function createErrorElement(input) {
        const errorElement = document.createElement('div');
        errorElement.className = 'invalid-feedback';
        input.parentNode.appendChild(errorElement);
        return errorElement;
    }


    const fioError = createErrorElement(fioInput);
    const loginError = createErrorElement(loginInput);
    const passwordError = createErrorElement(passwordInput);
    const phoneError = createErrorElement(phoneInput);
    const emailError = createErrorElement(emailInput);

    function validateFio() {
        const value = fioInput.value.trim();
        if (value === '') {
            fioInput.classList.remove('is-valid');
            fioInput.classList.add('is-invalid');
            fioError.textContent = 'ФИО обязательно для заполнения';
            return false;
        }
        if (!cyrillicRegex.test(value)) {
            fioInput.classList.remove('is-valid');
            fioInput.classList.add('is-invalid');
            fioError.textContent = 'ФИО должно содержать только кириллические символы, пробелы и дефисы';
            return false;
        }
        fioInput.classList.remove('is-invalid');
        fioInput.classList.add('is-valid');
        fioError.textContent = '';
        return true;
    }

    function validateLogin() {
        const value = loginInput.value.trim();
        if (value === '') {
            loginInput.classList.remove('is-valid');
            loginInput.classList.add('is-invalid');
            loginError.textContent = 'Логин обязателен для заполнения';
            return false;
        }
        if (value.length < 6) {
            loginInput.classList.remove('is-valid');
            loginInput.classList.add('is-invalid');
            loginError.textContent = 'Логин должен содержать минимум 6 символов';
            return false;
        }
        if (!/.*[а-яА-Я].*/.test(value)) {
            loginInput.classList.remove('is-valid');
            loginInput.classList.add('is-invalid');
            loginError.textContent = 'Логин должен содержать хотя бы один кириллический символ';
            return false;
        }
        loginInput.classList.remove('is-invalid');
        loginInput.classList.add('is-valid');
        loginError.textContent = '';
        return true;
    }

    function validatePassword() {
        const value = passwordInput.value;
        if (value === '') {
            passwordInput.classList.remove('is-valid');
            passwordInput.classList.add('is-invalid');
            passwordError.textContent = 'Пароль обязателен для заполнения';
            return false;
        }
        if (value.length < 6) {
            passwordInput.classList.remove('is-valid');
            passwordInput.classList.add('is-invalid');
            passwordError.textContent = 'Пароль должен содержать минимум 6 символов';
            return false;
        }
        passwordInput.classList.remove('is-invalid');
        passwordInput.classList.add('is-valid');
        passwordError.textContent = '';
        return true;
    }


    function validatePhone() {
        const value = phoneInput.value.trim();
        if (value === '') {
            phoneInput.classList.remove('is-valid');
            phoneInput.classList.add('is-invalid');
            phoneError.textContent = 'Телефон обязателен для заполнения';
            return false;
        }
        phoneInput.classList.remove('is-invalid');
        phoneInput.classList.add('is-valid');
        phoneError.textContent = '';
        return true;
    }

    function validateEmail() {
        const value = emailInput.value.trim();
        if (value === '') {
            emailInput.classList.remove('is-valid');
            emailInput.classList.add('is-invalid');
            emailError.textContent = 'Email обязателен для заполнения';
            return false;
        }
        if (!emailRegex.test(value)) {
            emailInput.classList.remove('is-valid');
            emailInput.classList.add('is-invalid');
            emailError.textContent = 'Введите корректный email адрес';
            return false;
        }
        emailInput.classList.remove('is-invalid');
        emailInput.classList.add('is-valid');
        emailError.textContent = '';
        return true;
    }

    fioInput.addEventListener('input', validateFio);
    fioInput.addEventListener('blur', validateFio);
    
    loginInput.addEventListener('input', validateLogin);
    loginInput.addEventListener('blur', validateLogin);
    
    passwordInput.addEventListener('input', validatePassword);
    passwordInput.addEventListener('blur', validatePassword);
    
    phoneInput.addEventListener('input', validatePhone);
    phoneInput.addEventListener('blur', validatePhone);
    
    emailInput.addEventListener('input', validateEmail);
    emailInput.addEventListener('blur', validateEmail);


    form.addEventListener('submit', function(event) {
        const isFioValid = validateFio();
        const isLoginValid = validateLogin();
        const isPasswordValid = validatePassword();
        const isPhoneValid = validatePhone();
        const isEmailValid = validateEmail();

        if (!isFioValid || !isLoginValid || !isPasswordValid || !isPhoneValid || !isEmailValid) {
            event.preventDefault();

            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });

    fioInput.classList.add('is-invalid');
    loginInput.classList.add('is-invalid');
    passwordInput.classList.add('is-invalid');
    phoneInput.classList.add('is-invalid');
    emailInput.classList.add('is-invalid');
});
</script>

</body>
</html>

