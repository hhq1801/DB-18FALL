
<html>
<title>年度书单</title>
<body>
<?php
	//1.0 12.18 wrk
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "book";
    global $_userid;
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
    $Year=2018;
    
    //top10
    $sql1 = "SELECT bookinfo.BookName,ANY_VALUE(bookinfo.type),SUM(orderdetail.quantity),(SUM(orderdetail.quantity)*ANY_VALUE(bookinfo.Price)) AS total FROM bookinfo,orderdetail,orderall WHERE bookinfo.ISBN=orderdetail.ISBN AND orderdetail.OrderNo=orderall.OrderNo AND orderall.UserNo=$_userid GROUP BY bookinfo.BookName ORDER BY total DESC LIMIT 0,10";
    if (mysqli_query($conn, $sql1) )
    {
        echo "<font size=5><b>2018 这些是你最喜欢的书</b></font>";
        echo "<br>";
        // size:40pt;
    } else {
        echo "失败！". "<br>";
        echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
    }
    
    $result = mysqli_query($conn,$sql1);
    $h=1;
    while($row = mysqli_fetch_array($result))
    {
        echo $h.') '.$row['BookName'];
        echo "<br>";
        $h++;
    }
    echo "<br>";
    //总花费
    $sql1 = "SELECT SUM(orderdetail.quantity),SUM(orderdetail.totalPrice) FROM orderdetail,orderall WHERE orderdetail.OrderNo=orderall.OrderNo AND orderall.UserNo=$_userid AND  orderall.Year=$Year  ";
    if (mysqli_query($conn, $sql1) )
    {
        echo "<font size=5><b>2018</b></font>";
        echo "<br>";
    } else {
        echo "失败！". "<br>";
        echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
    }
    $result = mysqli_query($conn,$sql1);
    while($row = mysqli_fetch_array($result))
    {
        $a=$row['SUM(orderdetail.quantity)'];
        $b=$row['SUM(orderdetail.totalPrice)'];
        
    }
    echo '这一年你总共在书店购买了 '."<font size=5><b>$a</b></font>".' 本书<br>';
    echo '这一年你总共花费了'."<font size=5><b>$b</b></font>".'元<br>';
    echo "<br>";
    
    
    //花费最多的
    $sql2 = "SELECT bookinfo.BookName,ANY_VALUE(bookinfo.type),SUM(orderdetail.quantity) FROM bookinfo,orderdetail,orderall WHERE bookinfo.ISBN=orderdetail.ISBN AND orderdetail.OrderNo=orderall.OrderNo AND orderall.UserNo=$_userid GROUP BY bookinfo.BookName ORDER BY SUM(orderdetail.quantity) DESC";
    $result = mysqli_query($conn,$sql2);
    $row = mysqli_fetch_array($result);
    $name=$row['BookName'];
    echo '买的最多的一本书是：';
    echo "<font size=5><b>《 $name 》</b></font><br>";
    $sql2 = "SELECT bookinfo.BookName,MAX(bookinfo.price) FROM bookinfo,orderdetail,orderall WHERE bookinfo.ISBN=orderdetail.ISBN AND orderdetail.OrderNo=orderall.OrderNo AND orderall.UserNo=$_userid GROUP BY bookinfo.BookName";
    $result = mysqli_query($conn,$sql2);
    $row = mysqli_fetch_array($result);
    $name=$row['BookName'];
    echo '最贵的的一本书是：';
    echo "<font size=5><b>《 $name 》</b></font><br>";

    //类型
    echo '<br>';
    echo '你最常买的类型是： <br>';
    
    $sql5 = "SELECT * FROM customer_interest WHERE customer_interest.UserNo=$_userid";
    $result5 = mysqli_query($conn,$sql5);
    $row = mysqli_fetch_row($result5);
    $max=0;
    for ($x=1; $x<=13; $x++)
    {
        if($max<$row[$x]){
            $max=$row[$x];
            $c=$x;
        }
    }
    if($c==1){echo "<font size=5><b>诗歌</b></font><br>";
        echo"你的年度关键词是：<font size=5><b>性情<br>诗者，志之所之也。<br>在心为志，发言为诗</b></font><br>";
    }
    if($c==2){echo "<font size=5><b>文学</b></font><br>";
        echo"你的年度关键词是：<font size=5><b>文艺<br>文学即人学<br>文字亦是力量</b></font><br>";
    }
    if($c==3){echo "<font size=5><b>散文</b></font><br>";
        echo"你的年度关键词是：<font size=5><b>慵懒<br>偷得浮生半日闲</b></font><br>";
    }
    if($c==4||$c==7){echo "<font size=5><b>小说</b></font><br>";
        echo"你的年度关键词是：<font size=5><b>奇幻<br>一个是镜中月，一个是水中花</b></font><br>";
    }
    if($c==5){echo "<font size=5><b>教材</b></font><br>";
        echo"你的年度关键词是：<font size=5><b>学习<br>不学习的人生还有什么意义？</b></font><br>";
    }
    if($c==6){echo "<font size=5><b>艺术</b></font><br>";
        echo"你的年度关键词是：<font size=5><b>品味<br>我的心略大于整个宇宙</b></font><br>";
    }
    if($c==8){echo "<font size=5><b>设计</b></font><br>";
        echo"你的年度关键词是：<font size=5><b>奇思<br>我的心略大于整个宇宙</b></font><br>";}
    if($c==9){echo "<font size=5><b>科技</b></font><br>";
        echo"你的年度关键词是：<font size=5><b>理性<br>思维与逻辑<br>理性与智慧</b></font><br>";
    }
    if($c==10){echo "<font size=5><b>哲学</b></font><br>";
        echo"你的年度关键词是：<font size=5><b>思辨<br>严谨缜密理性<br>是最极致的性感</b></font><br>";
    }
    if($c==11){echo "<font size=5><b>历史</b></font><br>";
        echo"你的年度关键词是：<font size=5><b>性情<br>微斯人，吾谁与归？</b></font><br>";
    }
    if($c==12){echo "<font size=5><b>人物传记</b></font><br>";
        echo"你的年度关键词是：<font size=5><b>性情<br>微斯人，吾谁与归？</b></font><br>";
    }
    if($c==13){echo "<font size=5><b>其他</b></font><br>";
        echo"你的年度关键词是：<font size=5><b>无常<br>人生无常，心安即是归处</b></font><br>";
    }
    
    //日期
    $sql33 = "SELECT SUM(orderdetail.Quantity) AS sum,SUM(orderdetail.totalPrice) AS total,Month,Day FROM orderdetail,orderall WHERE orderdetail.OrderNo=orderall.OrderNo AND orderall.UserNo=$_userid AND  orderall.Year=$Year GROUP BY orderall.Month,orderall.Day ORDER BY SUM(orderdetail.Quantity) DESC";
    $result33 = mysqli_query($conn,$sql33);
    $row = mysqli_fetch_array($result33);
    $sum=$row['sum'];
    $month=$row['Month'];
    $day=$row['Day'];
    echo '<br>';
    echo "<font size=5><b>$Year 年 $month 月 $day 日</b></font>".' 大概是很特别的一天<br>这一天<br>你买了<br>';
    $sql44 = "SELECT bookinfo.BookName FROM bookinfo,orderdetail,orderall WHERE bookinfo.ISBN=orderdetail.ISBN AND orderdetail.OrderNo=orderall.OrderNo AND orderall.UserNo=$_userid AND orderall.Year=$Year AND orderall.Month=$month AND orderall.Day=$day";
    $result44 = mysqli_query($conn,$sql44);
    while($row = mysqli_fetch_array($result44))
    {
        echo $row['BookName'].'<br>';
    }
    echo '总共 '."<font size=5><b>$sum</b></font>".' 本书<br><br>';

    $sql3 = "SELECT SUM(orderdetail.Quantity) AS sum,SUM(orderdetail.totalPrice) AS total,Month,Day FROM orderdetail,orderall WHERE orderdetail.OrderNo=orderall.OrderNo AND orderall.UserNo=$_userid AND  orderall.Year=$Year GROUP BY orderall.Month,orderall.Day ORDER BY SUM(orderdetail.totalPrice) DESC";
    $result3 = mysqli_query($conn,$sql3);
    $row = mysqli_fetch_array($result3);
    $total=$row['total'];
    $month=$row['Month'];
    $day=$row['Day'];
    echo "<font size=5><b>$Year 年 $month 月 $day 日</b></font>".' 你大概突然变得很有钱<br>这一天<br>你买了<br>';
    $sql4 = "SELECT bookinfo.BookName FROM bookinfo,orderdetail,orderall WHERE bookinfo.ISBN=orderdetail.ISBN AND orderdetail.OrderNo=orderall.OrderNo AND orderall.UserNo=$_userid AND orderall.Year=$Year AND orderall.Month=$month AND orderall.Day=$day";
    $result4 = mysqli_query($conn,$sql4);
    while($row = mysqli_fetch_array($result4))
    {
        echo $row['BookName'].'<br>';
    }
    echo '总共花了 '."<font size=5><b>$total</b></font>".' 元<br><br>';
    
	mysqli_close($conn);
?>
</body>
</html>
