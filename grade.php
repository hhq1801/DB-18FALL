<!doctype html>
<html>
	<title>图书评分</title>
	<body>	
		
<?php
	/* 连接到数据库 */
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "book";
    global $_userid;
    $_userid = $_COOKIE['u_id'];
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	mysqli_set_charset($conn, 'utf8');
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	/* 分页需要 */
    $page = 1;	//$page默认为1
    $page = empty($_GET['page'])?1 : $_GET['page'];	// 修改$page的值
    $sql=mysqli_query($conn,"SELECT bookinfo.ISBN,bookinfo.BookName FROM bookinfo,orderdetail,orderall WHERE bookinfo.ISBN=orderdetail.ISBN AND orderdetail.OrderNo=orderall.OrderNo AND orderall.UserNo=$_userid ");	// 查询总数
	$count=mysqli_num_rows($sql);
    $num = 10;	// 每页显示10条记录
    $pageCount = ceil($count / $num);	// 求总页数
    $offset = ($page - 1) * $num;  // 求偏移量

    $sql =  "SELECT DISTINCT(bookinfo.ISBN),bookinfo.BookName FROM bookinfo,orderdetail,orderall WHERE bookinfo.ISBN=orderdetail.ISBN AND orderdetail.OrderNo=orderall.OrderNo AND orderall.UserNo=$_userid limit " . $offset . ',' . $num;     // 查询book
	$result = mysqli_query($conn,$sql);
    echo '<div style="float:left; text-align:left"><a href="welcome.html">返回个人信息</div>';
    
	echo '<table border="1" width="900" align="center" cellpadding="10">';	// 表格样式
	echo '<caption><h1>已购买图书列表</h1></caption>';	// 表格标题
	while ($row = mysqli_fetch_array($result)) {
		echo '<tr>';
			echo '<form action="gradesucess.php" method="post">';
				echo '<td>' . $row['ISBN'] . '</td>';
				echo '<td name="bookname">' . $row['BookName'] . '</td>';
				echo '<input name="ISBN" value=' . $row['ISBN'] . '   type="hidden">';
       
        //检查有无评分
        $ISBN=$row['ISBN'];
        $sql2="SELECT grade FROM grade WHERE grade.ISBN=$ISBN AND grade.customerID=$_userid";
        $result2 = mysqli_query($conn,$sql2);
        $count2=mysqli_num_rows($result2);
        if($count2){
        while($row = mysqli_fetch_array($result2))
        {
            $grade=$row['grade'];
        }
            echo '<td>' ."已评分：". $grade .'分'. '</td>';
            echo '<td>' . ' ' . '</td>';
        }
        else{
        echo '<td>' . "未评分：" . '<select name="grade">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>' .'分'. '</td>';
        
            echo '<td>' . '<input name="submit" type="submit" value="确定">'. '</td>';}
			echo '</form>';
        echo '<form name=form1 action="displayOneBook.php" method="post">';
        echo '<input name="ISBN" value=' . $ISBN . '   type="hidden">';
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
	
	// 关闭连接
	mysqli_close($conn);
	?>
	
	<!-- 显示分页 -->
	<center><p>
    <a href="grade.php?page=1">首页</a>&nbsp;&nbsp;&nbsp;
    <a href="grade.php?page=<?php echo $prev;?>">上一页</a>&nbsp;&nbsp;&nbsp;
    <a href="grade.php?page=<?=$next;?>">下一页</a>&nbsp;&nbsp;&nbsp;
    <a href="grade.php?page=<?=$pageCount;?>">尾页</a>
	</center></p>
    
</body>
	<center>当前<?php echo $page. "/".$pageCount ?>页&nbsp;&nbsp;&nbsp;</center>
</html>

