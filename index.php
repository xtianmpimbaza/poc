<?php
session_start();

//error_reporting(1);
require_once 'functions.php';
$funs = new Functions();
$users = $funs->listStreamItems("users");
$toarray = [];

if (isset($_POST['submit'])) {


    if (!empty($users)) {
        foreach ($users as $user) {
            $it = $funs->hexToStr($user['data']);

            $toarray = "[" . $it . "]";
            $dec = json_decode($toarray, TRUE)[0];

            $uname = $dec['username'];
            $pw = $dec['password'];

            if ($_POST['username'] == $uname && $_POST['password'] == $pw) {
//                echo "matched ".$dec['user_address'];  //login here
                $_SESSION['user_id'] = $dec['user_address'];
                header('Location: home.php');
            }

        }
    } else {
        echo "Error in connection";
    }
}


?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>POC Login</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <link rel="stylesheet" href="login/css/main.css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500' rel='stylesheet' type='text/css'>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="login/js/jquery-1.8.2.min.js"></script>
    <script src="login/js/jquery.validate.min.js"></script>
    <script src="login/js/main.js"></script>
</head>
<body>
<?php
$error = '';

?>

<form id="login-form" class="login-form" name="form1" method="post" action="index.php">
    <input type="hidden" name="is_login" value="1">
    <div class="h1">POC -Login</div>
    <div id="form-content">
        <div class="group">
            <label for="username">Email</label>
            <div><input id="text" name="username" class="form-control required" type="username" placeholder="Username"></div>
        </div>
        <div class="group">
            <label for="name">Password</label>
            <div><input id="password" name="password" class="form-control required" type="password"
                        placeholder="Password"></div>
        </div>
        <?php if ($error) { ?>
            <em>
                <label class="err" for="password" generated="true" style="display: block;"><?php echo $error ?></label>
            </em>
        <?php } ?>
        <div class="group submit">
            <label class="empty"></label>
            <div><input name="submit" type="submit" value="Submit"/></div>
        </div>
    </div>
    <div id="form-loading" class="hide"><i class="fa fa-circle-o-notch fa-spin"></i></div>
</form>

</body>
</html>
