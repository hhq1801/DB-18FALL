<html>
<title>统计成功</title>
<body>
<?php
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "book";
	
	$_userid = $_COOKIE['u_id'];
	$xx;
	$yy;
	$max;
	$arr;
	
	// 创建连接
	$conn = mysqli_connect($servername, $username, $password, $dbname);

	// 设定字符集
	mysqli_set_charset($conn, 'utf8');

	//检测连接
	if (!$conn)
	{
	die("Connection failed: " . mysqli_connect_error());
	}
   
    //用户兴趣向量
    $No=$_userid;
    $sql = "SELECT * FROM customer_interest WHERE UserNo=$No";
    /*if (mysqli_query($conn, $sql))
    {
        echo "成功！";
    } else {
        echo "失败！". "<br>";
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }*/
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_row($result))
    {
        for($i=0;$i<=13;$i++){
            //echo $row[$i]." " ;
            $arr[$i]=$row[$i];
        }}
            //echo $arr[2]." ";}
	
    //公式
    function cos1($arr2,$arr)
    {
		global $xx;
		global $yy;
        $xy=0;
        for($i=1;$i<=13;$i++){
        $xy+=$arr2[$i] * $arr[$i];
        $xx+=$arr2[$i] * $arr2[$i];
        $yy+=$arr[$i] * $arr[$i];
        }
        $m=$xy/(sqrt($xx)+sqrt($yy));
        return $m." ";
    }
	
    //$arr1 = array(202,1,2,2,0,0,0,0,0,0,0,0,0,0);
    //echo cos1($arr1,$arr);
    //计算和其余每一个相似度
    $sql4 = "SELECT * FROM customer_interest";
    $result4 = mysqli_query($conn,$sql4);
    $row = mysqli_fetch_row($result4);
	global $max;
	global $arr;
    while($row = mysqli_fetch_row($result4))
    {
        if($row[0]!=$No){
            cos1($row,$arr);
            if(cos1($row,$arr)>$max){
                $max=cos1($row,$arr);
                $number=$row[0];
                echo "<br>";}
        }}
    echo $number." ";
    echo $max;
    echo "<br>";
   //推荐相似度最高的用户购买的书（不含用户已购买）
    $sql1 = "SELECT bookinfo.BookName,bookinfo.type FROM bookinfo,orderdetail,orderall WHERE bookinfo.ISBN=orderdetail.ISBN AND orderdetail.OrderNo=orderall.OrderNo AND orderall.UserNo=$number AND bookinfo.BookName NOT IN (SELECT bookinfo.BookName FROM bookinfo,orderdetail,orderall WHERE bookinfo.ISBN=orderdetail.ISBN AND orderdetail.OrderNo=orderall.OrderNo AND orderall.UserNo=$No) ";
    $result1 = mysqli_query($conn,$sql1);
    while($row = mysqli_fetch_array($result1))
    {
        echo $row['BookName']." ".$row['type'];
        echo "<br>";
    }
    


    
	// 关闭连接
	mysqli_close($conn);
?>

</body>
</html>
