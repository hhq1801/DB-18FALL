<!doctype html> 
<html> 
	<head> 
		<title>选择帐号类型</title> 
	</head> 
	<body> 
		<?php
           $character = isset($_POST['character'])? htmlspecialchars($_POST['character']) : '';
           if($character == "") {
                header('Location: index.html');
            }else if($character != ""){
                if($character =='admin') {
                    header('Location: register_admin.html');
                } else if($character =='user') {
                    header('Location: register_user.html');
                }
            }
    	?> 
	</body> 
</html>
