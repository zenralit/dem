<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'conn_db.php';
$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['review'])) {
    $application_id = $_POST['application_id'];
    $review_text = $_POST['review_text'];
    $rating = $_POST['rating'];
    
    $check_sql = "SELECT a.ID FROM APPLICATION a 
                  WHERE a.ID = ? AND a.USER_ID = ? AND a.Status = 'Обучение завершено'";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $application_id, $user_id);
    $stmt->execute();
    $check_result = $stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $sql = "INSERT INTO REVIEWS (APPLICATION_ID, USER_ID, Review_text, Rating, Created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisi", $application_id, $user_id, $review_text, $rating);
        
        if ($stmt->execute()) {
            $message = "Отзыв успешно добавлен";
        } else {
            $message = "Ошибка при добавлении отзыва";
        }
    } else {
        $message = "Невозможно оставить отзыв для этой заявки";
    }
}

$sql_applications = "SELECT a.ID, a.Status, a.Application_date, a.Desired_start_date, a.Payment_method, a.Comments,
                     c.Name as Course_name, c.Description, c.Duration, c.Price,
                     r.Review_text, r.Rating, r.Created_at as Review_date
                     FROM APPLICATION a 
                     JOIN COURSE c ON a.COURSE_ID = c.ID 
                     LEFT JOIN REVIEWS r ON a.ID = r.APPLICATION_ID 
                     WHERE a.USER_ID = ? 
                     ORDER BY a.Application_date DESC";
$stmt = $conn->prepare($sql_applications);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заявки</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-new { background-color: #007bff; }
        .status-in-progress { background-color: #ffc107; color: black; }
        .status-completed { background-color: #28a745; }
        .status-rejected { background-color: #dc3545; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Корочки.есть</a>
            <div class="navbar-nav">
                <a class="nav-link active" href="my_cabinet.php">Мои заявки</a>
                <a class="nav-link" href="apply.php">Подать заявку</a>
                <a class="nav-link" href="admin.php">вход для админа</a>
                <a class="nav-link" href="logout.php">Выйти</a>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h2>Мои заявки на курсы</h2>
        
        <?php if ($message): ?>
            <div class="alert alert-info alert-dismissible fade show">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5><?php echo htmlspecialchars($row['Course_name']); ?></h5>
                        <span class="badge 
                            <?php 
                            if ($row['Status'] == 'Новая') echo 'status-new';
                            elseif ($row['Status'] == 'Идет обучение') echo 'status-in-progress';
                            elseif ($row['Status'] == 'Обучение завершено') echo 'status-completed';
                            else echo 'status-rejected';
                            ?>">
                            <?php echo htmlspecialchars($row['Status']); ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Дата подачи:</strong> <?php echo htmlspecialchars($row['Application_date']); ?></p>
                                <p><strong>Желаемая дата начала:</strong> <?php echo htmlspecialchars($row['Desired_start_date']); ?></p>
                                <p><strong>Способ оплаты:</strong> <?php echo htmlspecialchars($row['Payment_method']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Продолжительность:</strong> <?php echo htmlspecialchars($row['Duration']); ?></p>
                                <p><strong>Стоимость:</strong> <?php echo htmlspecialchars($row['Price']); ?> руб.</p>
                                <p><strong>Описание:</strong> <?php echo htmlspecialchars($row['Description']); ?></p>
                            </div>
                        </div>
                        
                        <?php if ($row['Comments']): ?>
                            <div class="mt-2">
                                <p><strong>Комментарий к заявке:</strong> <?php echo htmlspecialchars($row['Comments']); ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($row['Review_text']): ?>
                            <div class="mt-3 p-3 bg-light rounded">
                                <h6>Ваш отзыв о курсе:</h6>
                                <p><strong>Оценка:</strong> 
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <span class="<?php echo $i <= $row['Rating'] ? 'text-warning' : 'text-secondary'; ?>">★</span>
                                    <?php endfor; ?>
                                    (<?php echo $row['Rating']; ?>/5)
                                </p>
                                <p><?php echo htmlspecialchars($row['Review_text']); ?></p>
                                <small class="text-muted">Оставлен: <?php echo htmlspecialchars($row['Review_date']); ?></small>
                            </div>
                        <?php elseif ($row['Status'] == 'Обучение завершено'): ?>
                            <div class="mt-3">
                                <h6>Оставить отзыв о качестве образовательных услуг:</h6>
                                <form method="POST" action="">
                                    <input type="hidden" name="application_id" value="<?php echo $row['ID']; ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Оценка курса:</label>
                                        <div>
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="rating" id="rating<?php echo $row['ID'].$i; ?>" value="<?php echo $i; ?>" required>
                                                    <label class="form-check-label" for="rating<?php echo $row['ID'].$i; ?>">
                                                        <?php for($j = 1; $j <= $i; $j++): ?>★<?php endfor; ?>
                                                    </label>
                                                </div>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Ваш отзыв:</label>
                                        <textarea class="form-control" name="review_text" rows="3" 
                                                  placeholder="Поделитесь вашими впечатлениями о качестве образовательных услуг..." 
                                                  required></textarea>
                                    </div>
                                    <button type="submit" name="review" class="btn btn-success">Оставить отзыв</button>
                                </form>
                            </div>
                        <?php elseif ($row['Status'] == 'Идет обучение'): ?>
                            <div class="mt-3">
                                <div class="alert alert-info">
                                    Вы можете оставить отзыв после завершения обучения.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info">
                У вас пока нет заявок на курсы. <a href="apply.php" class="alert-link">Подать заявку на курс</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>