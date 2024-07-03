<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mini_blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    if (empty($title) || empty($content)) {
        $error = "Заголовок и содержание не могут быть пустыми.";
    } else {
        $sql = "INSERT INTO posts (title, content) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $title, $content);

        if ($stmt->execute() === TRUE) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Ошибка: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить новый пост</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Добавить новый пост</h1>
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form action="add_post.php" method="post">
            <input type="text" name="title" placeholder="Заголовок" required>
            <textarea name="content" placeholder="Содержание" required></textarea>
            <input type="submit" value="Добавить">
        </form>
        <br>
        <a href="index.php" class="back-link"><button>Вернуться к списку постов</button></a>
    </div>
</body>
</html>
