<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mini_blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
}

$post_id = $_GET["id"];

$sql = "SELECT title, content, created_at FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $post = $result->fetch_assoc();
} else {
    echo "Пост не найден";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post["title"]; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="post">
            <h2><?php echo $post["title"]; ?></h2>
            <p><?php echo $post["content"]; ?></p>
            <p class="meta">Опубликовано: <?php echo $post["created_at"]; ?></p>
            <a href="index.php" class="back-link"><button>Вернуться к списку постов</button></a>
        </div>
    </div>
</body>
</html>
