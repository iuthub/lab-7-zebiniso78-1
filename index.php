<?php
include('connection.php');
session_start();
$db = new PDO('mysql:host=localhost;dbname=blog','admin','1234');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$logged=0;

$check_user_stmt= $db->prepare('SELECT * FROM users WHERE username=? AND password=? ');
$add_post_stmt=$db->prepare('INSERT INTO posts(title,body,publishDate,userId) VALUES(?,?,?,?)');
$get_posts_stmt=$db->prepare('SELECT * FROM posts');


$username="";
$password="";

$title="";
$body="";




if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_REQUEST['username']) && $_REQUEST['pwd'] && $_REQUEST['remember'])
    {
        $username=$_REQUEST['username'];
        $password=$_REQUEST['pwd'];
        $remember=isset($_REQUEST['remember'])? "on": "off";
        $check_user_stmt->execute(array($username,$password));
        $rows=$check_user_stmt->fetchAll();
        if(count($rows)!=0 ) {
            $_SESSION['user']=$rows[0];
        }
    }

    if(isset($_REQUEST['title']) && isset($_REQUEST['body']) && isset($_SESSION)){
        $title=$_REQUEST['title'];
        $body=$_REQUEST['body'];
        $author=$_SESSION['user']['fullname'];
        $userId=$_SESSION['user']['id'];

        $add_post_stmt->execute(array($title,$body,$author.", ".date("Y-m-d"),$userId));
        print $author."  ".$userId;
    }
}

if(isset($_REQUEST['logout']) && $_REQUEST['logout']==1){
    session_destroy();
}
else {
    $logged = 1;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>My Personal Page</title>
		<link href="style.css" type="text/css" rel="stylesheet" />
	</head>
	
	<body>
		<?php include('header.php');

        if($logged==0)
        {
            ?>
            <div class="twocols">
                <form action="index.php" method="post" class="twocols_col">
                    <ul class="form">
                        <li>
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" />
                        </li>
                        <li>
                            <label for="pwd">Password</label>
                            <input type="password" name="pwd" id="pwd" />
                        </li>
                        <li>
                            <label for="remember">Remember Me</label>
                            <input type="checkbox" name="remember" id="remember" checked />
                        </li>
                        <li>
                            <input type="submit" value="Submit" /> &nbsp; Not registered? <a href="register.php">Register</a>
                        </li>
                    </ul>
                </form>
                <div class="twocols_col">
                    <h2>About Us</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur libero nostrum consequatur dolor. Nesciunt eos dolorem enim accusantium libero impedit ipsa perspiciatis vel dolore reiciendis ratione quam, non sequi sit! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio nobis vero ullam quae. Repellendus dolores quis tenetur enim distinctio, optio vero, cupiditate commodi eligendi similique laboriosam maxime corporis quasi labore!</p>
                </div>
            </div>
        <?php
        }
        else{
            ?>
            <div class="logout_panel"><a href="register.php">My Profile</a>&nbsp;|&nbsp;<a href="index.php?logout=1">Log Out</a></div>
            <h2>New Post</h2>
            <form action="index.php" method="post">
                <ul class="form">
                    <li>
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" />
                    </li>
                    <li>
                        <label for="body">Body</label>
                        <textarea name="body" id="body" cols="30" rows="10"></textarea>
                    </li>
                    <li>
                        <input type="submit" value="Post" />
                    </li>
                </ul>
            </form>
            <div class="onecol">
                <?php   $get_posts_stmt->execute();
                        $rows=$get_posts_stmt->fetchAll();
                        foreach ($rows as $row){
                ?>
                <div class="card">
                    <h2><?= $row['title'] ?></h2>
                    <h5><?= $row['publishDate'] ?></h5>
                    <p><?= $row['body'] ?></p
                </div>
            </div>
        <?php
                        }
        }
		?>
	</body>
</html>