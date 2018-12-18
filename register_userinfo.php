<!doctype html>
<html>
	<head>
	<meta charset="utf-8">
		<meta http-equiv="refresh" content="3;url=register_userinfo.html"> 
	<title>填写用户信息</title>
	</head>

	<body>
<?php	
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "book";
	
	$name = $_POST["Name"];
	$tel = $_POST["Tel"];
	$address1 = $_POST["Address1"];
	$address2 = $_POST["Address2"];
	$address3 = $_POST["Address3"];

	$conn = mysqli_connect($servername, $username, $password, $dbname);
	mysqli_set_charset($conn, 'utf8');
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());}
/*———————————————————————————————————————————————————————————————————*/
	if($name == ""||$tel == ""||$address1 == ""){
				echo "请填写所有项目!3秒后返回上一页";
	}
	else{
		$sql1 = mysqli_query($conn,
			"SELECT UserNo 
			FROM account 
			ORDER BY UserNo DESC LIMIT 1
			");
		while($row = mysqli_fetch_array($sql1))
		{
			$userno=$row['UserNo'];	// echo $userno;
		}
    	$sql2 = "INSERT INTO userinfo (UserNo, UserName, Tel, Address1, Address2, Address3) 
			VALUES ('$userno','$name','$tel','$address1','$address2','$address3')";
		$sql3 = "INSERT INTO customer_interest(UserNo,诗歌,文学,散文,小说,教材,艺术,外国小说,设计,科技,哲学,历史,人物传记,其他)
			VALUES ('$userno','0','0','0','0','0','0','0','0','0','0','0','0','0')";
		// 显示结果
		if (mysqli_query($conn, $sql2)&&mysqli_query($conn, $sql3)){
			header("Location: welcome.html");
		} 
		else{
			echo "填写失败！3秒后返回上一页". "<br>";
			echo mysqli_error($conn);
		}
	}
?>
		
	</body>
</html>