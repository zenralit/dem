<?php include "db.php"; ?>

<!DOCTYPE html>
<html>
<head>

    <title>Буквоежка</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>
<body>

<nav class="navbar navbar-expand-lg bg-white">
    <div class="container">

        <a class="navbar-brand fw-bold" href="#">
            Буквоежка
        </a>

        <div>

            <?php if(isset($_SESSION['user'])): ?>

                <a href="cards.php" class="btn btn-outline-dark me-2">
                    Карточки
                </a>

                <a href="add_card.php" class="btn btn-dark me-2">
                    Добавить
                </a>

                <a href="logout.php" class="btn btn-danger">
                    Выход
                </a>

            <?php else: ?>

                <a href="login.php" class="btn btn-outline-dark me-2">
                    Войти
                </a>

                <a href="register.php" class="btn btn-dark">
                    Регистрация
                </a>

            <?php endif; ?>

        </div>

    </div>
</nav>

<div class="container d-flex align-items-center justify-content-center"
style="min-height: 80vh;">

    <div class="card main-card p-5 text-center w-100" style="max-width: 700px;">

        <h1 class="fw-bold mb-3">
            Портал обмена книгами
        </h1>

        <p class="text-muted mb-4">
            Делитесь книгами с другими пользователями
            или находите книги для своей библиотеки
        </p>

        <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794"
        class="img-fluid rounded-4">

    </div>

</div>

</body>
</html>