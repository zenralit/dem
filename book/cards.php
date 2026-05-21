<?php
include "db.php";

if(!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$user_id = $_SESSION['user']['id'];

$cards = mysqli_query($conn,
"SELECT * FROM cards WHERE user_id='$user_id'");
?>

<!DOCTYPE html>
<html>
<head>

    <title>Карточки</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>
<body>

<nav class="navbar navbar-expand-lg bg-white">

    <div class="container">

        <a class="navbar-brand fw-bold">
            Буквоежка
        </a>

        <div>

            <a href="add_card.php"
            class="btn btn-dark me-2">

                Добавить

            </a>

            <a href="logout.php"
            class="btn btn-danger">

                Выход

            </a>

        </div>

    </div>

</nav>

<div class="container py-5">

    <h2 class="fw-bold mb-4">
        Мои карточки
    </h2>

    <div class="row">

        <?php while($card = mysqli_fetch_assoc($cards)): ?>

            <div class="col-md-6 mb-4">

                <div class="card book-card p-4 h-100">

                    <h5 class="fw-bold">

                        <?php echo $card['book_name']; ?>

                    </h5>

                    <p class="text-muted">

                        <?php echo $card['author']; ?>

                    </p>

                    <p>

                        <?php echo $card['card_type']; ?>

                    </p>

                    <p>

                        Статус:

                        <?php if($card['status'] == 'approved'): ?>

                            <span class="status-approved">
                                Одобрено
                            </span>

                        <?php elseif($card['status'] == 'pending'): ?>

                            <span class="status-pending">
                                На рассмотрении
                            </span>

                        <?php else: ?>

                            <span class="status-rejected">
                                Отклонено
                            </span>

                        <?php endif; ?>

                    </p>

                    <?php if($card['reject_reason']): ?>

                        <div class="alert alert-danger">

                            <?php echo $card['reject_reason']; ?>

                        </div>

                    <?php endif; ?>

                    <a href="delete_card.php?id=<?php echo $card['id']; ?>"
                    class="btn btn-outline-danger">

                        Удалить

                    </a>

                </div>

            </div>

        <?php endwhile; ?>

    </div>

</div>

</body>
</html>