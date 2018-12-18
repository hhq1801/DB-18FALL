<?php
session_start();

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
    die("Connection failed: " . mysqli_connect_error());
}
$year=$_POST['year'];
//传入 年份选择，看哪年的图
$sql ="SELECT SUM(quantity), month 
          FROM orderAll ,orderdetail
          WHERE orderAll.year = '$year' and orderall.orderno= orderdetail.orderno
          GROUP BY month ";
// 查询图书信息
$result = mysqli_query($conn,$sql);
//数组
$arrayMonth = array();
$arrayAmount = array();

while ($row = mysqli_fetch_array($result)) {
    //echo var_dump($row);
	array_push($arrayMonth, $row['month']);
	array_push($arrayAmount, $row['SUM(quantity)']);
//echo '<br>';
};
//echo var_dump($arrayMonth);
//echo '<br>';
//echo var_dump($arrayAmount);
//echo "var arrayAmount="."'$arrayAmount';";
echo '<br>';
//echo "var arrayMonth="."'$arrayMonth';";

echo $arr1 = json_encode($arrayMonth);
echo $arr2 = json_encode($arrayAmount);
?>

<!DOCTYPE html>
<!--echarts图显示-->
<head>
	<meta charset="utf-8">
	<title>ECharts</title>
</head>
<body>

<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" style="height:400px"></div>
<!-- ECharts单文件引入 -->
<script src="http://echarts.baidu.com/build/dist/echarts.js">

</script>
<script type="text/javascript" >
	//arrayAmount=[1,2];
	//arrayMonth=[1,2];
	// 路径配置
	require.config({
		paths: {
			echarts: 'http://echarts.baidu.com/build/dist'
		}
	});

	// 使用
	require(
		[
			'echarts',
			'echarts/chart/bar' // 使用柱状图就加载bar模块，按需加载
		],
		function (ec) {
			// 基于准备好的dom，初始化echarts图表
			var myChart = ec.init(document.getElementById('main'));

			var option = {
				title : {
					text: '每月总销量表',
					subtext: 'test'
				},
				tooltip : {
					trigger: 'axis'
				},
				legend: {
					data:['销量（本）']
				},
				toolbox: {
					show : true,
					feature : {
						mark : {show: true},
						dataView : {show: true, readOnly: false},
						magicType : {show: true, type: ['line', 'bar']},
						restore : {show: true},
						saveAsImage : {show: true}
					}
				},
				calculable : true,
				xAxis : [
					{
						type : 'category',
						data : <?php echo $arr1; ?>
					}
				],
				yAxis : [
					{
						type : 'value'
					}
				],
				series : [
					{
						name:'销量',
						type:'bar',

						data:<?php echo $arr2; ?>,
						markPoint : {
							data : [
								{type : 'max', name: '最大值'},
								{type : 'min', name: '最小值'}
							]
						},
						markLine : {
							data : [
								{type : 'average', name: '平均值'}
							]
						}
					}

				]
			};

			// 为echarts对象加载数据
			myChart.setOption(option);
		}
	);
</script>
</body>
