<?php
include "db.php";

$message = "";

if(isset($_POST['register'])) {

    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];

    $check = mysqli_query($conn,
    "SELECT * FROM users WHERE login='$login'");

    if(mysqli_num_rows($check) > 0) {

        $message = "Логин уже существует";

    } else {

        $password = md5($password);

        mysqli_query($conn,
        "INSERT INTO users(fullname, phone, email, login, password)
        VALUES('$fullname','$phone','$email','$login','$password')");

        $message = "Регистрация успешна";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Регистрация</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <script src="script.js"></script>

</head>
<body>

<div class="container d-flex justify-content-center align-items-center"
style="min-height: 100vh;">

    <div class="card main-card p-4 w-100" style="max-width: 500px;">

        <h2 class="text-center fw-bold mb-4">
            Регистрация
        </h2>

        <form method="POST" onsubmit="return validateRegister()">

            <input type="text"
            name="fullname"
            id="fullname"
            class="form-control mb-3"
            placeholder="ФИО"
            required>

            <input type="text"
            name="phone"
            id="phone"
            class="form-control mb-3"
            placeholder="+7(XXX)-XXX-XX-XX"
            required>

            <input type="email"
            name="email"
            class="form-control mb-3"
            placeholder="Email"
            required>

            <input type="text"
            name="login"
            class="form-control mb-3"
            placeholder="Логин"
            required>

            <input type="password"
            name="password"
            id="password"
            class="form-control mb-3"
            placeholder="Пароль"
            required>

            <button class="btn btn-dark btn-custom w-100"
            name="register">

                Зарегистрироваться

            </button>

        </form>

        <?php if($message): ?>

            <div class="alert alert-info mt-3">

                <?php echo $message; ?>

            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>