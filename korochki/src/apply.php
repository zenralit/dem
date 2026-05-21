<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'conn_db.php';
$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $desired_date = $_POST['desired_date'];
    $payment_method = $_POST['payment_method'];
    $comments = $_POST['comments'] ?? '';
    
    if (!DateTime::createFromFormat('d.m.Y', $desired_date)) {
        $message = "Неверный формат даты. Используйте ДД.ММ.ГГГГ";
    } else {
        $sql = "INSERT INTO APPLICATION (COURSE_ID, USER_ID, Status, Application_date, Desired_start_date, Payment_method, Comments) 
                VALUES (?, ?, 'Новая', NOW(), STR_TO_DATE(?, '%d.%m.%Y'), ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisss", $course_id, $user_id, $desired_date, $payment_method, $comments);
        
        if ($stmt->execute()) {
            $message = "Заявка успешно отправлена на рассмотрение!";
        } else {
            $message = "Ошибка при отправке заявки: " . $conn->error;
        }
    }
}

$sql_courses = "SELECT ID, Name, Description, Duration, Price FROM COURSE";
$result_courses = $conn->query($sql_courses);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подача заявки</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Корочки.есть</a>
            <div class="navbar-nav">
                <a class="nav-link" href="my_cabinet.php">Мои заявки</a>
                <a class="nav-link active" href="apply.php">Подать заявку</a>
                <a class="nav-link" href="admin.php">вход для админа</a>
                <a class="nav-link" href="logout.php">Выйти</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Подача заявки на курс</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($message): ?>
                            <div class="alert alert-info"><?php echo $message; ?></div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="course_id" class="form-label">Наименование курса</label>
                                <select class="form-select" id="course_id" name="course_id" required>
                                    <option value="">Выберите курс</option>
                                    <?php while($course = $result_courses->fetch_assoc()): ?>
                                        <option value="<?php echo $course['ID']; ?>" 
                                                data-duration="<?php echo $course['Duration']; ?>"
                                                data-price="<?php echo $course['Price']; ?>">
                                            <?php echo htmlspecialchars($course['Name']); ?> 
                                            (<?php echo $course['Duration']; ?>, <?php echo $course['Price']; ?> руб.)
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="desired_date" class="form-label">Желаемая дата начала обучения</label>
                                <input type="text" class="form-control" id="desired_date" name="desired_date" 
                                       placeholder="ДД.ММ.ГГГГ" required pattern="\d{2}\.\d{2}\.\d{4}">
                                <div class="form-text">Формат: ДД.ММ.ГГГГ</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Способ оплаты</label>
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cash" value="наличными" required>
                                        <label class="form-check-label" for="cash">Наличными</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="transfer" value="перевод на счет" required>
                                        <label class="form-check-label" for="transfer">карта</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="comments" class="form-label">Дополнительные комментарии</label>
                                <textarea class="form-control" id="comments" name="comments" rows="3" 
                                          placeholder="Ваши пожелания или дополнительные сведения..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Отправить заявку</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>