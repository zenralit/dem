<?php
include "db.php";
 if(!isset($_SESSION['user'])){
    header("location: index.php");
 }
$user_id = $_SESSION['user']['id'];
$card = mysqli_query($conn, 
"SELECT * FROM cards WHERE user_id = '$user_id'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>кариточки</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">

            <div class="menu"> 
               <a href="add_card.php">добавить</a> 
               <a href="logout.php">выход</a> 
            </div>
            <h1>мои карточки</h1>
            <?php while($card = mysqli_fetch_assoc($card)): ?>
                <div class="cared">
                    <b>автор:</b> <?php echo $card['author']; ?> <br>
                     <b>книга:</b> <?php echo $card['book_name']; ?> <br>
                      <b>тип:</b> <?php echo $card['card_type']; ?> <br>
                       <b>статус:</b> <?php echo $card['status']; ?> <br>


                       <?php if($card['reject_reason']): ?>
                        <b>причина</b>
                        <?php echo $card['reject_reason']; ?>
                        <?php endif; ?>
                        <br><br>
                        <a href="delete_card.php?id=<?php echo $card['id']; ?>">удалить</a>
                </div>
                <?php endwhile; ?>
    </div>
</body>
</html>