<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete SQL</title>
</head>
<body>

<h1>Содержимое бд</h1>

<?php
$link = new mysqli("127.0.0.1", "root", "", "grade");
$result = $link->query('SELECT * FROM user');
while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - Name: " . $row["username"]. " - Permission: " . $row["permission"]. " - Rating: ". $row["rating"]. "<br>";
}
?>

<h1>Удаление из бд</h1>
<form action="" method="POST">
    <input type="text">
    <input type="submit">
</form>
        
</body>
</html>