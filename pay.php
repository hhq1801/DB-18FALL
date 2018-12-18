<html>
<title>结账</title>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "book";

$_userid = $_COOKIE['u_id'];
/* 更新customer_interest-------------------------------------------------------------------------------------------*/	
// 用来确定图书类型计数
$type = array("UserNo", "诗歌","文学","散文","小说","教材","艺术","外国小说","设计","科技","哲学","历史","人物传记","其他") ;
// 记录用户购买的图书的类型
$typeResult = array("0","0","0","0","0","0","0","0","0","0","0","0","0","0") ;
// 图书类型计数结果
$count = array("0","0","0","0","0","0","0","0","0","0","0","0","0","0") ;
/* ---------------------------------------------------------------------------------------------------------------*/	
// 创建连接	
$conn = mysqli_connect($servername, $username, $password, $dbname);
// 设定字符集
mysqli_set_charset($conn, 'utf8');
// 检测连接
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
};



/* ---------------------------------------------------------------------------------------------------------------*/	
date_default_timezone_set('PRC');
$date=date('Y.m.d'); 
$year=date('Y');
$month=date('m');
$day=date('d');
$hour=date('H');
$minute=date('i');
$second=date('s');
$sq2 = "INSERT INTO orderALL(UserNo, year, month,day,hour,minute,second) 
	VALUES ($_userid, '$year', '$month','$day','$hour','$minute','$second')";  #ok #这里变量要加引号，不然会进行计算
$sq3 = "CREATE table temp(OrderNO INT)"; #ok
$sq41 = "SELECT max(OrderNo) AS num from orderALL";

if (mysqli_query($conn, $sq2)) {
    echo "";
} else {
    echo "Error creating database sq2: " . mysqli_error($conn);
    echo "<br>";
};
if (mysqli_query($conn, $sq3)) {
    echo "";
} else {
    echo "Error creating database sq3: " . mysqli_error($conn);
};
if (mysqli_query($conn, $sq41)) {
    echo "";
} else {
    echo "Error creating database sq41: " . mysqli_error($conn);
};
/* ---------------------------------------------------------------------------------------------------------------*/
$result = mysqli_query($conn, $sq41);
$r = mysqli_fetch_array($result);
$num= $r['num'];
// echo gettype($num);
// echo $num;
$sq4 = "INSERT INTO temp(OrderNO) 
	VALUES('$num')";
$sq5 = "INSERT INTO orderdetail(OrderNo,ISBN,Quantity,totalprice)
	SELECT OrderNO, tempOrder.ISBN, tempOrder.amount,price*discount*amount
	FROM(tempOrder ,temp,bookinfo)
	WHERE(tempOrder.ISBN = bookinfo.ISBN) and (tempOrder.customerID = $_userid)";
$sq6 = "DROP table temp"; #ok
$sq7 = "DELETE FROM tempOrder #ok
	WHERE  tempOrder.customerID = $_userid";
	
if (mysqli_query($conn, $sq4)) {
    echo "";
} else {
    echo "Error creating database sq4: " . mysqli_error($conn);
};
if (mysqli_query($conn, $sq5)) {
    echo "";
} else {
    echo "Error creating database sq5: " . mysqli_error($conn);
};
if (mysqli_query($conn, $sq6)) {
    echo "";
} else {
    echo "Error creating database sq6: " . mysqli_error($conn);
};
if (mysqli_query($conn, $sq7)) {
    echo "付款成功!";
} else {
    echo "Error creating database sq7: " . mysqli_error($conn);
};
echo "<br>";
echo '<p><a href="displayAllBook.php">继续购物</p>';





/* 更新customer_interest-------------------------------------------------------------------------------------------*/		
	// 查找最新数据：订单号 & 用户编号
	$newNo = mysqli_query($conn,"
		SELECT 
			*
		FROM
    		orderall
		ORDER BY 
			OrderNo DESC LIMIT 1");
	// 记录订单号 & 用户编号
	while($row = mysqli_fetch_array($newNo))
    {
		$orderno[0] = $row['OrderNo'];
		$userno[0] = $row['UserNo'];
		//echo "OrderNo: ".$orderno[0]. '<br>'. "Userno: ".$userno[0]. '<br>';
    }	

	// 查找最新数据：图书类型
	$newType = mysqli_query($conn,"
		SELECT 
			bookinfo.type
		FROM 
			bookinfo, orderdetail
		WHERE
			orderdetail.orderno = $orderno[0] AND orderdetail.ISBN = bookinfo.ISBN");
	// 记录用户购买的图书的类型
	$j=0;
	while($row = mysqli_fetch_array($newType))
    {
		$typeResult[$j]=$row['type'];
		//echo "图书类型： ".$typeResult[$j]. "——j编号: ". $j.'<br>';
		$j++;
    }	

	// 查找最新数据：用户购买的图书的数量
	$qty = mysqli_query($conn,"
		SELECT
			orderdetail.quantity
		FROM
			orderdetail
		WHERE
			orderdetail.orderno = $orderno[0]");
	$j=0;
	// 记录用户购买的图书的数量
	while($row = mysqli_fetch_array($qty))
    {
		$quantity[$j]=$row['quantity']-1;
		//echo "图书数量： ".$quantity[$j]."——k编号： ".$j.'<br>';
		$j++;
    }	
		
	// 图书类型计数
	for($i=0;$i<=13;$i++){
		for($j=0;$j<=13;$j++){
			if($typeResult[$j] == $type[$i]){
				$count[$i] = $count[$i]+1+$quantity[$j];	
			}
		}
		//echo $result[$i];
	}
	// 更新customer_interest
	for($i=0;$i<=13;$i++){
		if($count[$i] != 0){
			$sql2 = mysqli_query($conn,
				"UPDATE 
					customer_interest set $type[$i] = $type[$i]+$count[$i]
				WHERE 
					UserNo=$userno[0]
				");
		}
	}
/* ---------------------------------------------------------------------------------------------------------------*/	
// 关闭连接
mysqli_close($conn);
?>

</body>
</html>

