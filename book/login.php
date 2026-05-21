<?php
include "db.php";

$message = "";

if(isset($_POST['login_btn'])) {

    $login = $_POST['login'];
    $password = md5($_POST['password']);

    if($login == "admin" && $_POST['password'] == "bookworm") {

        $_SESSION['admin'] = true;

        header("Location: admin.php");
    }

    $query = mysqli_query($conn,
    "SELECT * FROM users WHERE login='$login' AND password='$password'");

    if(mysqli_num_rows($query) > 0) {

        $_SESSION['user'] = mysqli_fetch_assoc($query);

        header("Location: cards.php");

    } else {

        $message = "Неверный логин или пароль";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Авторизация</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>
<body>

<div class="container d-flex justify-content-center align-items-center"
style="min-height: 100vh;">

    <div class="card main-card p-4 w-100" style="max-width: 450px;">

        <h2 class="text-center fw-bold mb-4">
            Вход
        </h2>

        <form method="POST">

            <input type="text"
            name="login"
            class="form-control mb-3"
            placeholder="Логин"
            required>

            <input type="password"
            name="password"
            class="form-control mb-3"
            placeholder="Пароль"
            required>

            <button class="btn btn-dark btn-custom w-100"
            name="login_btn">

                Войти

            </button>

        </form>

        <?php if($message): ?>

            <div class="alert alert-danger mt-3">

                <?php echo $message; ?>

            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>