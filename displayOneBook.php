<html>
<title>详细信息</title>
<body>
<?php
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

//检测连接
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$isbn = $_POST["ISBN"];

$sql1 = "SELECT bookinfo.BookName, bookinfo.ISBN, bookinfo.SummaryCN, bookinfo.SummaryEN, bookinfo.Price,bookinfo.discount, bookinfo.type, bookinfo.Price 
FROM bookinfo WHERE bookinfo.ISBN=$isbn";

$result1 = mysqli_query($conn, $sql1);
while ($row = mysqli_fetch_array($result1)) {
    echo $row['BookName'];
    echo "<br>";
    echo "ISBN: " . $row['ISBN'];
    echo "<br>";
    if ($row['discount'] == 1) {
        echo "价格: " . $row['Price'] . "¥";
        echo "<br>";
    } else {
        echo "今日有折扣！";
        echo "原价: " . $row['Price'] . "¥";
        echo "<br>";
        echo "折扣价: " . $row['Price'] * $row['discount'] . "¥";
        echo "<br>";
    }
    echo "类型: " . $row['type'];
    echo "<br>";
    echo "中文简介: ";
    echo "<br>";
    echo $row['SummaryCN'];
    echo "<br>";
    echo "英文简介: ";
    echo "<br>";
    echo $row['SummaryEN'];
    echo "<br>";
}
// 加入购物车
echo '<form action="shoppingcart.php" method="post">';
echo '<input name="ISBN" value=' . $isbn . '   type="hidden">';

echo "选择数量" . '<input name="quantity" type="number">';
echo '<input name="submit" type="submit" value="加入购物车">';
echo '</form>';

// 推荐该类型中销量最高的五本书

$sql2 = "SELECT bookinfo.BookName, bookinfo.ISBN, SUM(Quantity) as TotalQuantity
FROM bookinfo, orderdetail
WHERE bookinfo.ISBN = orderdetail.ISBN and  bookinfo.type = 
  (SELECT bookinfo.type 
  FROM bookinfo 
  WHERE bookinfo.ISBN=" . $isbn . " )
GROUP BY bookinfo.ISBN 
ORDER BY SUM(orderdetail.Quantity) DESC";



/*
if (mysqli_query($conn, $sql2)) {
    echo "";
} else {
    echo "Error sq2: " . mysqli_error($conn);
};
*/
$result2 = mysqli_query($conn, $sql2);
$i = 1;
echo '<table border="1" width="400" align="left" cellpadding="1">';	// 表格样式
echo '<caption><h2>本类型销量排行榜：</h2></caption>';	// 表格标题
while ($row = mysqli_fetch_row($result2)) {
    echo '<form action="displayOneBook.php" method="post">';

    echo '<tr>';
    echo '<td bgcolor="#f0f8ff">'.$i . ":" .'</td>';
    echo '<td bgcolor="#add8e6">'.$row['0'] .'</td>';
    echo '<td bgcolor="#5f9ea0">'.$row['2'] .'</td>';
    echo '<input name="ISBN" value=' . $row['1'] . '   type="hidden">';
    echo '<td>' . '<input name="submit" type="submit" value="查看该书详情">'. '</td>';

    $i++;
    echo "<br>";
    echo '</tr>';
    echo '</form>';

}
$row = mysqli_fetch_row($result2);


// 推荐该类型中销量最高的，且用户没买过的，非该页面显示书的三本书
// 留待下次


// 超链接
echo '<p><a href="displayAllBook.php">查看所有书</p>';

// 关闭连接
mysqli_close($conn);


/* 每个需要链接到这个页面的把底下的改改粘过去
echo '<form name=form1 action="displayOneBook.php" method="post">';
echo '<input name="ISBN" value=' . $row['ISBN'] . '   type="hidden">'; // 制作提交内容
echo  '<input name="submit" type="submit" value="该书详情">';
echo '</form>';

<a href="displayOneBook.php" onclick="form1.submit();">该书详情 </a>
*/

?>

</body>

</html>
