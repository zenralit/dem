<?php
session_start();
require 'conn_db.php';

$sql_courses = "SELECT ID, Name, Description, Duration, Price FROM COURSE LIMIT 6";
$result_courses = $conn->query($sql_courses);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корочки.есть - Онлайн курсы дополнительного образования</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
        }
        .course-card {
            transition: transform 0.3s ease;
            margin-bottom: 30px;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }
        .carousel-item img {
            height: 500px;
            object-fit: cover;
        }
        .stats-section {
            background-color: #f8f9fa;
            padding: 60px 0;
            margin: 50px 0;
        }
        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: #667eea;
        }
        .btn-custom-red {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
        .btn-custom-red:hover {
            background-color: #c82333;
            border-color: #bd2130;
            color: white;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 10px 0;
        }
        .logo-text {
            font-weight: bold;
            font-size: 1.5rem;
            color: #333;
            margin-left: 10px;
        }
        .nav-link {
            font-weight: 500;
            color: #333 !important;
            margin: 0 10px;
        }
        .nav-link:hover {
            color: #dc3545 !important;
        }
        .nav-link.active {
            color: #dc3545 !important;
            font-weight: 600;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-white bg-white">
    <div class="container">

        <a class="navbar-brand d-lg-none d-flex align-items-center" href="index.php">
            <img src="img/logo.jpg" alt="Корочки.есть" height="60" class="d-inline-block align-text-top">
            <span class="logo-text">КОРОЧКИ ЕСТЬ</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Главная</a>
                </li>
            </ul>
            

            <a class="navbar-brand d-none d-lg-flex align-items-center position-absolute start-50 translate-middle-x" href="index.php">
                <img src="img/logo.jpg" alt="Корочки.есть" height="70" class="d-inline-block align-text-top">
                <span class="logo-text">КОРОЧКИ ЕСТЬ</span>
            </a>
          
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="my_cabinet.php">Профиль</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Выйти</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="auto.php">Вход</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-custom-red ms-2" href="register.php">Регистрация</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

    <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/photo1.jpg" class="d-block w-100" alt="Обучение программированию">
                <div class="carousel-caption d-none d-md-block">
                    <h3>удобные кабинеты</h3>
                    <p>компьютеры иногда включаются</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/photo2.jpg" class="d-block w-100" alt="Веб-разработка">
                <div class="carousel-caption d-none d-md-block">
                     <h3>почти нет тараканов</h3>
                    <p>только в еде</p> 
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/photo3.jpg" class="d-block w-100" alt="Анализ данных">
                <div class="carousel-caption d-none d-md-block">
                     <h3>перспективные направления</h3>
                    <p>скрэтч и роблокс студи</p> 
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/photo4.jpg" class="d-block w-100" alt="Дипломы и сертификаты">
                <div class="carousel-caption d-none d-md-block">
                     <h3>высокие зарплаты выпускников</h3>
                    <p>им платят тараканами</p> 
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>


    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h1 class="display-4 mb-4">Добро пожаловать на портал "Корочки.есть"</h1>
                <p class="lead">Мы предлагаем качественные онлайн-курсы дополнительного профессионального образования.</p>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="register.php" class="btn btn-custom-red btn-lg mt-3">Начать обучение</a>
                <?php else: ?>
                    <a href="apply.php" class="btn btn-custom-red btn-lg mt-3">Подать заявку на курс</a>
                <?php endif; ?>
            </div>
        </div>


        <div class="row mb-5">
            <div class="col-12">
                <h2 class="text-center mb-4">Популярные курсы</h2>
            </div>
            
            <?php if ($result_courses->num_rows > 0): ?>
                <?php while($course = $result_courses->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card course-card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($course['Name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($course['Description']); ?></p>
                                <ul class="list-unstyled">
                                    <li><strong>Продолжительность:</strong> <?php echo htmlspecialchars($course['Duration']); ?></li>
                                    <li><strong>Стоимость:</strong> <?php echo htmlspecialchars($course['Price']); ?> руб.</li>
                                </ul>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="apply.php" class="btn btn-custom-red w-100">Подать заявку</a>
                                <?php else: ?>
                                    <a href="index.php" class="btn btn-custom-red w-100">Зарегистрироваться</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Курсы временно недоступны. Пожалуйста, зайдите позже.
                    </div>
                </div>
            <?php endif; ?>
        </div>



    <footer class="bg-white text-black py-4 mt-5 border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Корочки.есть</h5>
                    <p>Портал дополнительного профессионального образования</p>
                </div>
                <div class="col-md-6 text-end">
                    <p>Контакты: mikro@zaimy.ru<br>+7 (800) 555-35-35</p>
                </div>
            </div>
            <div class="text-center mt-3">
                <p>&copy; 2025 Корочки.есть. Все права защищены.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
