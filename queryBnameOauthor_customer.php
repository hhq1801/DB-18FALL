<!DOCTYPE html> 
<html>
	<head>
		<meta charset="utf-8">
		<title>图书数据库管理系统</title>
	</head> 

	<body>
		<h1>查询结果</h1>

<?php
	global $a;
	global $b;
	$a=$_POST["bookname"];
	$b=$_POST["authorname"];
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
	$sql = "
		SELECT bookInfo.ISBN, bookInfo.BookName, author.Author, bookInfo.Press, bookInfo.Price, bookInfo.SummaryCN, bookInfo.SummaryEN
		FROM bookInfo INNER JOIN author ON bookInfo.ISBN = author.ISBN
		WHERE (((bookInfo.BookName is null) or (bookInfo.BookName Like '%$a%')) and ((author.Author is null) or(author.Author Like '%$b%')));
	";
	$result = mysqli_query($conn,$sql);	// mysqli_query，在数据库上执行查询。

	echo '<table border="1" width="900" align="center" bgcolor="grey" cellpadding="10">';	// 表格样式
		echo '<caption><h1>列表</h1></caption>';	// 表格标题
		echo '<tr bgcolor="#dddddd">';	// 列属性
			echo '<th>ISBN</th><th>书名</th><th>作者</th><th>出版社</th><th>价格</th><th>中文简介</th><th>英文简介</th>';
		echo '</tr>';
		
	$list=mysqli_fetch_all($result);	// mysqli_fetch_all，抓取所有的结果行并且以关联数据，数值索引数组，或者两者皆有的方式返回结果集。
	
	// 表格内容——查询结果
	for($row=0;$row<count($list);$row++){
		echo '<tr>';
		//使用内层循环遍历数组$list中子数组的每个元素,使用count()函数控制循环次数
		for($col=0;$col<count($list[$row]);$col++){ 
			if ($col==0 or $col==2 or $col==4 or $col==6){
				echo '<td bgcolor="lightblue">'.$list[$row][$col].'</td>';
			}
			else{
				echo '<td bgcolor="pink">'.$list[$row][$col].'</td>';
			}
					
		}
		echo '</tr>';
	}
	echo '</table>';
/*———————————————————————————————————————————————————————————————————*/			
	mysqli_close($conn); 
?>

	</body> 
</html>