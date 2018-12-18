<!doctype html>
<html>
	<head> 
		<meta charset="utf-8">
		<meta http-equiv="refresh" content="3;url=register_user.html"> 
		<title>图书数据库管理系统</title>
	</head> 
	<body>
		
<?php
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "book";
		
	$name = $_POST["UserName"];
	$pwd = $_POST["Passport"];
	// 创建连接
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// 设定字符集
	mysqli_set_charset($conn, 'utf8');
	// 检测连接
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());}
/*———————————————————————————————————————————————————————————————————*/
	// 分别向两张表里添加用户信息
	$sql = "INSERT INTO account (UserName, Password) 
			VALUES ('$name','$pwd')";
	// 显示结果
	if (mysqli_query($conn, $sql)){
		header("Location: register_userinfo.html");
	} 
	else{
		echo "注册失败！3秒后返回注册页". "<br>";
		echo mysqli_error($conn);
	}
	
/*———————————————————————————————————————————————————————————————————*/
	// 关闭连接
	mysqli_close($conn);
?>
		
	</body> 
</html>