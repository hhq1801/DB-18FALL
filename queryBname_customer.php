<!DOCTYPE html> 
<html>
	<head>
		<meta charset="utf-8">
		<title>图书数据库管理系统</title>
	</head> 

	<body>
		<h1>查询结果</h1>

<?php
	// 全局作用域变量
	global $a;
	$a = $_POST["bookname"];
/*———————————————————————————————————————————————————————————————————*/
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
	// 根据书名模糊查询图书信息
	$result = mysqli_query($conn,"
		SELECT ISBN,bookInfo.BookName FROM bookinfo 
		WHERE bookinfo.BookName Like '%$a%'
	");
	
	// 显示结果
	while($row = mysqli_fetch_array($result)){
		echo $row['ISBN'] . " " . $row['BookName'];
		echo "<br>";
	}
/*———————————————————————————————————————————————————————————————————*/
	// 关闭连接
	mysqli_close($conn); 
?>

	</body> 
</html>