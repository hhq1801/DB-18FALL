<?php
    
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "book";

    $_userid = $_COOKIE['u_id'];
	$Tel=$_POST["Tel"];
	$Address1=$_POST["Address1"];
	$Address2=$_POST["Address2"];
	$Address3=$_POST["Address3"];
    // 创建连接
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    // 设定字符集
    mysqli_set_charset($conn, 'utf8');
    
    // 检测连接
    if (!$conn)
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    
    //修改用户信息
    if($Tel!=NULL){
        $sql = "UPDATE userinfo SET Tel='$Tel' WHERE UserNo=$_userid";
        if (mysqli_query($conn, $sql))
        {
            echo "电话修改成功！";
            echo "<br>";
        } else {
            echo "修改失败！". "<br>";
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    if($Address1!=NULL){
        $sql1 = "UPDATE userinfo SET Address1='$Address1' WHERE UserNo=$_userid";
        if (mysqli_query($conn, $sql)&&mysqli_query($conn, $sql1))
        {
            echo "地址1修改成功！";
            echo "<br>";
        } else {
            echo "修改失败！". "<br>";
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }}
    if($Address2!=NULL){
        $sql2 = "UPDATE userinfo SET Address2='$Address2' WHERE UserNo=$_userid";
        if (mysqli_query($conn, $sql)&&mysqli_query($conn, $sql2))
        {
            echo "地址2修改成功！";
            echo "<br>";
        } else {
            echo "修改失败！". "<br>";
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }}
    if($Address3!=NULL){
        $sql3 = "UPDATE userinfo SET Address3='$Address3' WHERE UserNo=$_userid";
        if (mysqli_query($conn, $sql)&&mysqli_query($conn, $sql3))
        {
            echo "地址3修改成功！";
            echo "<br>";
        } else {
            echo "修改失败！". "<br>";
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }}
    
    //显示修改过的
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
    }
    mysqli_close($conn);
    ?>
