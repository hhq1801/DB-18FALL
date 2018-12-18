<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="refresh" content="3;url=login_customer.html"> 
		<title>用户登录</title>
	</head>
	<body>
	
<?php	
	$_userid;
	$name = $_POST["UserName"];
	$pwd = $_POST["Passport"];
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
    // 检查是否填写全部项目
	if($name == ""||$pwd == ""){
				echo "请填写所有项目!3秒后返回登录页";
	}
	else{
		// 检查用户名是否存在
		$result1 = mysqli_query($conn,"
			SELECT * FROM account 
			WHERE UserName='$_POST[UserName]'
			");
		if(mysqli_num_rows($result1)==0){
        echo "该用户不存在!3秒后返回登录页";
    	}	
		else{
			// 检查用户名和密码
			$result = mysqli_query($conn,"
				SELECT * FROM account 
				WHERE UserName='$_POST[UserName]'and Password='$_POST[Passport]'");
			if(mysqli_num_rows($result)>0)   {	// 用户名和密码都正确
				// 记住登录状态
				$sql = mysqli_query($conn,"
					SELECT UserNo FROM account 
					WHERE UserName='$_POST[UserName]'and Password='$_POST[Passport]'");
				setcookie('login_status',true);
				while($row = mysqli_fetch_assoc($sql)){
					$_userid=$row["UserNo"];
					setcookie('u_id',$_userid);
				}
				header("Location: welcome.html");	// 登录成功，跳转至用户个人页
			} 
			else {	// 密码错误，登录失败
				echo "密码错误！3秒后返回登录页". "<br>";
				echo '<p><a href="login_customer.html">返回</a></p>'; 
			}
		}
	}
/*———————————————————————————————————————————————————————————————————*/
	// 关闭连接
	mysqli_close($conn);
?>
	
	</body>
</html>
