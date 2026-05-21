<?php
include "db.php";

if(!isset($_SESSION['user'])) {
    header("Location: login.php");
}

if(isset($_POST['send'])) {

    $user_id = $_SESSION['user']['id'];

    $author = $_POST['author'];
    $book_name = $_POST['book_name'];
    $card_type = $_POST['card_type'];

    $publisher = $_POST['publisher'];
    $publish_year = $_POST['publish_year'];
    $cover_type = $_POST['cover_type'];
    $book_state = $_POST['book_state'];

    mysqli_query($conn, "INSERT INTO cards(
        user_id,
        author,
        book_name,
        card_type,
        publisher,
        publish_year,
        cover_type,
        book_state
    )

    VALUES(
        '$user_id',
        '$author',
        '$book_name',
        '$card_type',
        '$publisher',
        '$publish_year',
        '$cover_type',
        '$book_state'
    )");

    header("Location: cards.php");
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Добавление карточки</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>
<body>

<div class="container py-5">

    <div class="card main-card p-4 mx-auto"
    style="max-width: 700px;">

        <h2 class="fw-bold mb-4">
            Новая карточка
        </h2>

        <form method="POST">

            <input type="text"
            name="author"
            class="form-control mb-3"
            placeholder="Автор"
            required>

            <input type="text"
            name="book_name"
            class="form-control mb-3"
            placeholder="Название книги"
            required>

            <div class="mb-3">

                <div class="form-check">

                    <input class="form-check-input"
                    type="radio"
                    name="card_type"
                    value="Готов поделиться"
                    required>

                    <label class="form-check-label">
                        Готов поделиться
                    </label>

                </div>

                <div class="form-check">

                    <input class="form-check-input"
                    type="radio"
                    name="card_type"
                    value="Хочу в библиотеку">

                    <label class="form-check-label">
                        Хочу в свою библиотеку
                    </label>

                </div>

            </div>

            <input type="text"
            name="publisher"
            class="form-control mb-3"
            placeholder="Издательство">

            <input type="text"
            name="publish_year"
            class="form-control mb-3"
            placeholder="Год издания">

            <input type="text"
            name="cover_type"
            class="form-control mb-3"
            placeholder="Переплет">

            <input type="text"
            name="book_state"
            class="form-control mb-3"
            placeholder="Состояние книги">

            <button class="btn btn-dark btn-custom w-100"
            name="send">

                Отправить

            </button>

        </form>

    </div>

</div>

</body>
</html>