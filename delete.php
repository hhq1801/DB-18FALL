<!doctype html>
<html>
	<head> 
		<meta charset="utf-8">
		<title>购物车</title>
	</head> 
	<body>
	
<?php
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "book";
	// 创建连接
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// 设定字符集
	mysqli_set_charset($conn, 'utf8');
	// 检测连接
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());}
/*———————————————————————————————————————————————————————————————————*/
	$sql1 = "DELETE FROM tempOrder 
	WHERE orderID=".$_POST["orderid"]."
	";
	
	if (mysqli_query($conn, $sql1)) {
    	echo "删除成功";
	} 
	else {
    	echo "Error creating database: " . mysqli_error($conn);
	};
	
	echo '<p><a href="viewshoppingcart.php">查看购物车</a>&nbsp&nbsp<a href="displayAllBook.php">返回图书列表</a></p>';
/*———————————————————————————————————————————————————————————————————*/	
	// 关闭连接
	mysqli_close($conn); 
?>

	</body>
</html>

