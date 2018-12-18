<html>
<title>个人资料</title>
<body>
<?php
		
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "book";
	
    $_userid = $_COOKIE['u_id'];
	// 创建连接
	$conn = mysqli_connect($servername, $username, $password, $dbname);

	// 设定字符集
	mysqli_set_charset($conn, 'utf8');

	// 检测连接
	if (!$conn) 
	{
	die("Connection failed: " . mysqli_connect_error());
	}
    
    
    //显示用户信息
    $sql1 = "SELECT * FROM account WHERE UserNo=$_userid";
    $result = mysqli_query($conn,$sql1);
    while($row = mysqli_fetch_array($result))
    {
        echo "用户编号： " . $row['UserNo'];
        echo "<br>";
        echo "用户昵称： " . $row['UserName'];
        echo "<br>";
    }
    $sql = "SELECT * FROM userinfo WHERE UserNo=$_userid";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($result))
    {
        echo "用户姓名： " . $row['UserName'];
        echo "<br>";
        echo "用户电话： " . $row['Tel'];
        echo "<br>";
        echo "用户地址1：" . $row['Address1'];
        echo "<br>";
        echo "用户地址2：" . $row['Address2'];
        echo "<br>";
        echo "用户地址3：" . $row['Address3'];
        echo "<br>";
        echo '<p><a href="welcome.html">返回</a></p>';
        echo '<p><a href="customer_info2.php">修改</a></p>';
    }
    
	mysqli_close($conn);
?>
</body>
</html>
