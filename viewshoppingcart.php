<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>购物车</title>
	</head>

	<body>

<?php
	global $_userid;
	$_userid = $_COOKIE['u_id'];
	$totalPrice = 0;
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
		die("Connection failed: " . mysqli_connect_error());};
/*———————————————————————————————————————————————————————————————————*/	
	$sql2 = "
		SELECT tempOrder.orderID,tempOrder.ISBN, BookInfo.BookName,BookInfo.Price,BookInfo.discount, tempOrder.amount FROM (tempOrder INNER JOIN BookInfo ON tempOrder.ISBN=BookInfo.ISBN)
		WHERE tempOrder.customerID = $_userid
	";
	$result = mysqli_query($conn,$sql2);	
	
	// 购物车显示 并且操作购物车（可以删除内容，也可以提交购买）
	echo '<table border="1" width="900" align="center" cellpadding="10">';	// 表格样式
	echo '<caption><h1>购物车</h1></caption>';	// 表格标题
	echo '<tr>';
		echo'<td>ISBN</td>';
		echo'<td>书名</td>';
		echo'<td>数量</td>';
		echo'<td>单价</td>';
		echo'<td>总价</td>';
		echo'<td></td>';
	echo '</tr>';
	
	while($row = mysqli_fetch_array($result))
	{
		echo '<form action="delete.php" method="post">';
		echo '<tr>';
		echo'<td>'.$row['ISBN'].'</td>';
		echo'<td>'.$row['BookName'].'</td>';
		echo'<td>'.$row['amount'].'</td>';
		echo'<td>'.$row['Price']*$row['discount'].'</td>';
		echo'<td>'.$row['amount']*$row['Price']*$row['discount'].'¥</td>';
		
		$totalPrice = $totalPrice+$row['amount']*$row['Price']*$row['discount']; // 计算总价
		
		echo '<input name="ISBN" value='.$row['ISBN'].'   type="hidden">'; // 制作提交内容
	 	echo '<input name="orderid" value='.$row['orderID'].'   type="hidden">'; // 制作提交内容
		echo'<td>'.'<input name="submit" type="submit" value="从购物车中删除">';
		echo '</tr>';
		echo '</form>';
	}
		echo '<form action="pay.php" method="post">';
		echo '<tr>';
		echo'<td></td>';
		echo'<td></td>';
		echo'<td></td>';
		echo'<td></td>';
		echo'<td>'.$totalPrice.'¥</td>';
		echo'<td>'.'<input name="submit" type="submit" value="结账">';
		echo '</tr>';
		echo '</form>'; 
		echo '<p><a href="displayAllBook.php">返回图书列表</a></p>';
/*———————————————————————————————————————————————————————————————————*/	
	// 关闭连接
	mysqli_close($conn); 
?>
	
	</body>
</html>