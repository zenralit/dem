<?php
session_start();


if (!isset($_SESSION['admin_logged_in'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['login'] ?? '') == 'admin' && ($_POST['password'] ?? '') == 'education') {
        $_SESSION['admin_logged_in'] = true; 
        header("Location: admin.php");
        exit();
    } else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $error = "Неверные учетные данные";
        }
        ?>
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Вход для администратора</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-center">Вход для администратора</h4>
                            </div>
                            <div class="card-body">
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endif; ?>
                                <form method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">Логин</label>
                                        <input type="text" class="form-control" name="login" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Пароль</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Войти</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit();
    }
}

require 'conn_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $application_id = $_POST['application_id'];
    $new_status = $_POST['status'];
    
    $sql = "UPDATE APPLICATION SET Status = ? WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_status, $application_id);
    $stmt->execute();
    
    $_SESSION['message'] = "Статус заявки обновлен";
    header("Location: admin.php");
    exit();
}

$status_filter = $_GET['status'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$where_clause = "";
if ($status_filter) {
    $where_clause = "WHERE a.Status = '$status_filter'";
}

$sql_count = "SELECT COUNT(*) as total FROM APPLICATION a $where_clause";
$result_count = $conn->query($sql_count);
$total_applications = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_applications / $limit);

$sql_applications = "SELECT a.ID, a.Status, a.Application_date, a.Desired_start_date, a.Payment_method, a.Comments,
                     u.FIO as User_FIO, u.Phone, u.Email,
                     c.Name as Course_name
                     FROM APPLICATION a 
                     JOIN USER u ON a.USER_ID = u.ID 
                     JOIN COURSE c ON a.COURSE_ID = c.ID 
                     $where_clause 
                     ORDER BY a.Application_date DESC 
                     LIMIT $limit OFFSET $offset";
$result_applications = $conn->query($sql_applications);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .mobile-card {
            display: none;
        }
        .status-badge {
            font-size: 0.75rem;
        }
        @media (max-width: 768px) {
            .desktop-table {
                display: none;
            }
            .mobile-card {
                display: block;
            }
            .card-body {
                padding: 0.75rem;
            }
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand">админ-панель</span>
            <a href="admin_logout.php" class="btn btn-outline-light btn-sm">Выйти</a>
        </div>
    </nav>

    <div class="container mt-3">
        <h2 class="h4">Управление заявками</h2>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card mb-3">
            <div class="card-body py-2">
                <form method="GET" class="row g-2">
                    <div class="col-12">
                        <label class="form-label mb-1">Фильтр по статусу</label>
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Все статусы</option>
                            <option value="Новая" <?php echo $status_filter == 'Новая' ? 'selected' : ''; ?>>Новая</option>
                            <option value="Идет обучение" <?php echo $status_filter == 'Идет обучение' ? 'selected' : ''; ?>>Идет обучение</option>
                            <option value="Обучение завершено" <?php echo $status_filter == 'Обучение завершено' ? 'selected' : ''; ?>>Обучение завершено</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-2">
                <h5 class="h6 mb-0">Заявки: <?php echo $total_applications; ?></h5>
            </div>
            <div class="card-body p-0">
                <?php if ($result_applications->num_rows > 0): ?>
                    
                    <div class="desktop-table">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Пользователь</th>
                                        <th>Курс</th>
                                        <th>Статус</th>
                                        <th>Дата подачи</th>
                                        <th>Начало</th>
                                        <th>Оплата</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = $result_applications->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['ID']; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($row['User_FIO']); ?></strong><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($row['Phone']); ?></small><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($row['Email']); ?></small>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['Course_name']); ?></td>
                                        <td>
                                            <span class="badge status-badge
                                                <?php 
                                                if ($row['Status'] == 'Новая') echo 'bg-primary';
                                                elseif ($row['Status'] == 'Идет обучение') echo 'bg-warning';
                                                else echo 'bg-success';
                                                ?>">
                                                <?php echo $row['Status']; ?>
                                            </span>
                                        </td>
                                        <td><small><?php echo date('d.m.Y', strtotime($row['Application_date'])); ?></small></td>
                                        <td><small><?php echo $row['Desired_start_date']; ?></small></td>
                                        <td><small><?php echo $row['Payment_method']; ?></small></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary mb-1" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editModal<?php echo $row['ID']; ?>">
                                                Статус
                                            </button>
                                            
                                            <?php if ($row['Comments']): ?>
                                                <button type="button" class="btn btn-sm btn-outline-info mb-1" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#commentsModal<?php echo $row['ID']; ?>">
                                                    комментарий
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mobile-card">
                        <?php 
                        $result_applications->data_seek(0);
                        while($row = $result_applications->fetch_assoc()): 
                        ?>
                        <div class="card m-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">#<?php echo $row['ID']; ?></h6>
                                    <span class="badge status-badge
                                        <?php 
                                        if ($row['Status'] == 'Новая') echo 'bg-primary';
                                        elseif ($row['Status'] == 'Идет обучение') echo 'bg-warning';
                                        else echo 'bg-success';
                                        ?>">
                                        <?php echo $row['Status']; ?>
                                    </span>
                                </div>
                                
                                <p class="mb-1"><strong><?php echo htmlspecialchars($row['User_FIO']); ?></strong></p>
                                <p class="mb-1 small text-muted"><?php echo htmlspecialchars($row['Phone']); ?></p>
                                <p class="mb-2 small text-muted"><?php echo htmlspecialchars($row['Email']); ?></p>
                                
                                <p class="mb-1"><strong>Курс:</strong> <?php echo htmlspecialchars($row['Course_name']); ?></p>
                                <p class="mb-1 small"><strong>Подана:</strong> <?php echo date('d.m.Y', strtotime($row['Application_date'])); ?></p>
                                <p class="mb-1 small"><strong>Начало:</strong> <?php echo $row['Desired_start_date']; ?></p>
                                <p class="mb-2 small"><strong>Оплата:</strong> <?php echo $row['Payment_method']; ?></p>
                                
                                <div class="d-grid gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal<?php echo $row['ID']; ?>">
                                        Изменить статус
                                    </button>
                                    
                                    <?php if ($row['Comments']): ?>
                                        <button type="button" class="btn btn-sm btn-outline-info" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#commentsModal<?php echo $row['ID']; ?>">
                                            Показать комментарии
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>

                    <?php if ($total_pages > 1): ?>
                    <div class="card-footer">
                        <nav>
                            <ul class="pagination pagination-sm justify-content-center mb-0">
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>&status=<?php echo $status_filter; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    </div>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="alert alert-info m-2">Заявки не найдены</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php 
    $result_applications->data_seek(0);
    while($row = $result_applications->fetch_assoc()): 
    ?>
    <div class="modal fade" id="editModal<?php echo $row['ID']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Статус заявки #<?php echo $row['ID']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="application_id" value="<?php echo $row['ID']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Новый статус</label>
                            <select name="status" class="form-select" required>
                                <option value="Новая" <?php echo $row['Status'] == 'Новая' ? 'selected' : ''; ?>>Новая</option>
                                <option value="Идет обучение" <?php echo $row['Status'] == 'Идет обучение' ? 'selected' : ''; ?>>Идет обучение</option>
                                <option value="Обучение завершено" <?php echo $row['Status'] == 'Обучение завершено' ? 'selected' : ''; ?>>Обучение завершено</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" name="update_status" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if ($row['Comments']): ?>
    <div class="modal fade" id="commentsModal<?php echo $row['ID']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Комментарии #<?php echo $row['ID']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo htmlspecialchars($row['Comments']); ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php endwhile; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>