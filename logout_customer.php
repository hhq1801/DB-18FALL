<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>退出系统</title>
	</head>
		
	<body>
		
<?php
    session_start();
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
	echo "<script>location.href='index.html';</script>";
?>
		
	</body>
</html>