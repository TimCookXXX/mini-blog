<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "mini_blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
}

$sql = "SELECT id, title, created_at FROM posts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Блог</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Все посты</h1>
        <a href="add_post.html"><button>Добавить новый пост</button></a><br><br>
        <ul>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<li><a href='post.php?id=" . $row["id"] . "'>" . $row["title"] . "</a> (" . $row["created_at"] . ")</li>";
                }
            } else {
                echo "Нет постов";
            }
            ?>
        </ul>
    </div>
</body>
</html>

<?php
$conn->close();
?>
