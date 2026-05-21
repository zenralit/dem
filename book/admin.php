<?php
include "db.php";

if(!isset($_SESSION['admin'])) {
    header("Location: login.php");
}

if(isset($_POST['approve'])) {

    $id = $_POST['id'];

    mysqli_query($conn,
    "UPDATE cards SET status='approved' WHERE id='$id'");
}

if(isset($_POST['reject'])) {

    $id = $_POST['id'];

    $reason = $_POST['reason'];

    mysqli_query($conn,
    "UPDATE cards
    SET status='rejected',
    reject_reason='$reason'
    WHERE id='$id'");
}

$cards = mysqli_query($conn,
"SELECT cards.*, users.fullname
FROM cards
JOIN users ON cards.user_id = users.id");
?>

<!DOCTYPE html>
<html>
<head>

    <title>Админ панель</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>
<body>

<div class="container py-5">

    <h1 class="fw-bold mb-4">
        Админ панель
    </h1>

    <?php while($card = mysqli_fetch_assoc($cards)): ?>

        <div class="card main-card p-4 mb-4">

            <h4 class="fw-bold">

                <?php echo $card['book_name']; ?>

            </h4>

            <p class="text-muted">

                <?php echo $card['author']; ?>

            </p>

            <p>

                Пользователь:
                <b><?php echo $card['fullname']; ?></b>

            </p>

            <p>

                Тип:
                <?php echo $card['card_type']; ?>

            </p>

            <form method="POST">

                <input type="hidden"
                name="id"
                value="<?php echo $card['id']; ?>">

                <textarea
                name="reason"
                class="form-control mb-3"
                placeholder="Причина отклонения"></textarea>

                <div class="d-flex gap-2">

                    <button class="btn btn-success w-100"
                    name="approve">

                        Опубликовать

                    </button>

                    <button class="btn btn-danger w-100"
                    name="reject">

                        Отклонить

                    </button>

                </div>

            </form>

        </div>

    <?php endwhile; ?>

</div>

</body>
</html>