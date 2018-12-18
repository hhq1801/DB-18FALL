<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="refresh" content="3;url=login_admin.html"> 
		<title>管理员登录</title>
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
    // 检查用户名是否注册
    $result1 = mysqli_query($conn,"
		SELECT * FROM adminaccount 
		WHERE AdminName='$_POST[UserName]'
	");
	if(mysqli_num_rows($result1)==0){
        echo "该用户未注册3秒后返回登录页";
    }
    // 检查密码是否正确
    else {
    	$result = mysqli_query($conn,"
			SELECT * FROM adminaccount 
			WHERE AdminName='$_POST[UserName]'and AdminPassword='$_POST[Passport]'");
		if(mysqli_num_rows($result)>0){
			//	跳转至用户欢迎页
			header("Location: manage_book.html"); 
		} 
		else {
			echo "密码错误！3秒后返回登录页". "<br>";
			echo '<p><a href="login_admin.html">返回</a></p>'; 
    	}
	}
/*———————————————————————————————————————————————————————————————————*/
	// 关闭连接
	mysqli_close($conn);
?>
		
	</body>
</html>
