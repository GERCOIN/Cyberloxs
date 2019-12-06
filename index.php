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
$sql = new mysqli("127.0.0.1", "root", "", "grade");
if ($sql->connect_error) {
    die("Connection failed: " . $sql->connect_error);
} 
$query = $sql->query('SELECT * FROM user');
if ($query->num_rows > 0) {
    while($row = $query->fetch_assoc()) {
        echo $row["id"]. " - " . $row["username"]. " - " . $row["permission"]. " - ". $row["rating"]. "<br>";
    }
} else {
    echo "0 results";
}

?>
        
</body>
</html>