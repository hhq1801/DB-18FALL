<!-- 2018.12.18/zdq/ -->
<!doctype html>
<html>
	<title>购买图书</title>
	<head>
		<!-- 页码跳转 -->
		<script lang="javascript">
			 function chk(jumpToPage){
			 if(form.page.value<=0||form.page.value>form.pages.value){
			 alert("请输入有效页码");
			 form.page.focus();
			 return(false);
			 }
			 return(true);
			 }
		</script>
	</head>
	
	<body>
		<div id="top" style="height:20px">
			<div style="float:left; text-align:left"><a href="welcome.html">返回个人页</a></div>
			<div style="float:right; text-align:right"><a href="viewshoppingcart.php">查看购物车</a></div>
		</div>
		
<?php
	/* 连接到数据库 */
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "book";
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	mysqli_set_charset($conn, 'utf8');
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	/* 分页需要 */
    $page = 1;	//$page默认为1
    $page = empty($_GET['page'])?1 : $_GET['page'];	// 修改$page的值
    $sql=mysqli_query($conn,"SELECT * FROM bookinfo ");	// 查询bookinfo中的记录数
	$count=mysqli_num_rows($sql);
    $num = 10;	// 每页显示10条记录
    $pageCount = ceil($count / $num);	// 求总页数
    $offset = ($page - 1) * $num;  // 求偏移量

	/* 显示图书记录 */
	$sql =  "SELECT * FROM bookinfo limit " . $offset . ',' . $num;	// 查询book
	$result = mysqli_query($conn,$sql);
	echo '<table border="1" width="900" align="center" cellpadding="10">';	// 表格样式
	echo '<caption><h1>图书列表</h1></caption>';	// 表格标题
	while ($row = mysqli_fetch_array($result)) {
		echo '<tr>';
			echo '<form action="shoppingcart.php" method="post">';
				echo '<td>' . $row['ISBN'] . '</td>';
				echo '<td name="bookname">' . $row['BookName'] . '</td>';
				echo '<td name="discountprice">' . $row['Price']*  $row['discount']. "¥" .'</td>';
				echo '<input name="ISBN" value=' . $row['ISBN'] . '   type="hidden">';
				echo '<td>' . "选择数量" . '<input name="quantity" type="number" min="0">' . '</td>';
				echo '<td>' . '<input name="submit" type="submit" value="加入购物车">'. '</td>';
			echo '</form>';
			//	该书详情
			echo '<form name=form1 action="displayOneBook.php" method="post">';
				echo '<input name="ISBN" value=' . $row['ISBN'] . '   type="hidden">';
				echo  '<td>' . '<input name="submit" type="submit" value="该书详情">';
			echo '</form>';
		echo '</tr>';
	};
	echo "</table>";
	
	/* 分页需要 */
    $prev = $page - 1;
    $next = $page + 1;
    if($prev<1){	    // 页数限制
        $prev = 1;
    }
    if($next>$pageCount){
        $next = $pageCount;
    }
	
	/* 断开数据库连接 */
	mysqli_close($conn);
?>
	
	<!-- 显示分页 -->
	<center><p>
	<form name="jumpToPage" method="get" action="displayAllBook.php" onSubmit="return chk(this)">
		当前<input name="page" type="text" size="1" value="<?php echo $page; ?>">/<?php echo $pageCount ?>页&nbsp;&nbsp;&nbsp;
 		<input type="hidden" name="pages" value="<?php echo $pageCount;?>">
		<a href="displayAllBook.php?page=1">首页</a>&nbsp;&nbsp;&nbsp;  
    	<a href="displayAllBook.php?page=<?php echo $prev;?>">上一页</a>&nbsp;&nbsp;&nbsp;
    	<a href="displayAllBook.php?page=<?=$next;?>">下一页</a>&nbsp;&nbsp;&nbsp;
    	<a href="displayAllBook.php?page=<?=$pageCount;?>">尾页</a>
	</form>
	</p></center>
    
	</body>
</html>

