<html>
<title>购物车</title>
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

// 向购物车临时表中插入内容
$sql1 = "
	INSERT INTO tempOrder(customerID, ISBN, amount)
	VALUES($_userid, " . $_POST["ISBN"] . ", " . $_POST["quantity"].")";
if (mysqli_query($conn, $sql1)) {
    echo "添加购物车成功";
} else {
    echo "Error creating database: " . mysqli_error($conn);
};

echo '<p><a href="viewshoppingcart.php">查看购物车</p>';
echo '<p><a href="displayAllBook.php">继续购物</p>';

// 关闭连接
mysqli_close($conn);
?>

</body>
</html>

