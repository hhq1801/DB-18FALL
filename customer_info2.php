
            <?php
                
                $servername = "localhost";
                $username = "root";
                $password = "root";
                $dbname = "book";

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
            
            
            //显示用户信息
            $sql1 = "SELECT * FROM account WHERE UserNo=$_userid";
            $result = mysqli_query($conn,$sql1);
            while($row = mysqli_fetch_array($result))
            {
                echo "用户编号： " . $row['UserNo'];
                echo "<br>";
                echo "用户昵称： " . $row['UserName'];
                echo "<br>";
            }
            $sql = "SELECT * FROM userinfo WHERE UserNo=$_userid";
            $result = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_array($result))
            {
                echo "用户姓名： " . $row['UserName'];
                echo "<br>";}
            mysqli_close($conn);
                ?>
            <form action="customer_info3.php" method="post">
            <p>电话：
            <input name="Tel" type="text" size="20" maxlength="20"></p>
            <p>住址1：
            <input name="Address1" type="text" size="30" maxlength="100"></p>
            <p>住址2：
            <input name="Address2" type="text" size="30" maxlength="100"></p>
            <p>住址3：
            <input name="Address3" type="text" size="30" maxlength="100"></p>
            <input type="submit" value="修改">
            </form>

