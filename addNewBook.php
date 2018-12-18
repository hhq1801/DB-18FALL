<!doctype html>
<html>
	<head> 
		<meta charset="utf-8">
		<title>图书数据库管理系统</title>
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
	//	添加图书记录
	$sql1 = "INSERT INTO bookinfo (ISBN, BookName, type, Press, Price, SummaryCN, SummaryEN)
	VALUES('$_POST[ISBN]','$_POST[BookName]','$_POST[Type]','$_POST[Press]','$_POST[Price]','$_POST[SummaryCN]','$_POST[SummaryEN]')
	";
	//	添加作者记录	
	$sql2 = "INSERT INTO author (Author, ISBN)
	VALUES ('$_POST[Author]', '$_POST[ISBN]')
	";
	// 显示结果
	if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
		echo "添加成功！";
	} 
	else {
		echo "添加失败！". "<br>";
		echo "Error: ". mysqli_error($conn);
	}
/*———————————————————————————————————————————————————————————————————*/
	// 关闭连接
	mysqli_close($conn);
?>

	</body> 
</html>