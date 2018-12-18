<!doctype html>
<html>
	<head> 
		<meta charset="utf-8">
		<meta http-equiv="refresh" content="3;url=register_admin.html"> 
		<title>管理员用户注册</title>
	</head> 
	<body>
		
<?php
	$name = $_POST["UserName"];
	$pwd = $_POST["Passport"];
	$inv = $_POST["invitation"];
/*———————————————————————————————————————————————————————————————————*/
	// 连接数据库
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "book";
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	mysqli_set_charset($conn, 'utf8');
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());}
/*———————————————————————————————————————————————————————————————————*/
	// 检查是否填写全部项目
	if($name == ""||$pwd == ""|| $inv == ""){
				echo "请填写所有项目";
	}
	// 检查邀请码
	else if($inv != "16"){
		echo "邀请码不正确！3秒后返回注册页"; 
	}
	else{
		$sql = "INSERT INTO adminaccount (AdminName,AdminPassword) VALUES('$name', '$pwd')";
		if (mysqli_query($conn, $sql)){
			header("Location: manage_book.html");
		} 
		else{
			echo "注册失败！3秒后返回注册页". "<br>";
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
/*———————————————————————————————————————————————————————————————————*/
	// 关闭连接
	mysqli_close($conn);
?>
		
	</body> 
</html>
