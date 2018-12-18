<html>
<title>评分</title>
<body>

<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "book";
global $_userid;
$_userid = $_COOKIE['u_id'];
// 创建连接
$conn = mysqli_connect($servername, $username, $password, $dbname);

// 设定字符集
mysqli_set_charset($conn, 'utf8');

// 检测连接
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
};


$sql1 = "
	INSERT INTO grade(customerID, ISBN, grade)
	VALUES($_userid, " . $_POST["ISBN"] . ", " . $_POST["grade"] .")
	";
if (mysqli_query($conn, $sql1)) {
    echo "评分成功";
} else {
    echo "Error creating database: " . mysqli_error($conn);
};


echo '<p><a href="grade.php">继续评分</p>';

// 关闭连接
mysqli_close($conn);
?>

</body>
</html>

