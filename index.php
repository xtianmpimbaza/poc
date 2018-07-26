<?php
session_start();

//error_reporting(1);
require_once 'functions.php';
$funs = new Functions();
$users = $funs->listStreamItems("users");
$toarray = [];

if (isset($_POST['login'])) {

    if (!empty($users)) {
        foreach ($users as $user) {
            $it = $funs->hexToStr($user['data']);

            $toarray = "[" . $it . "]";
            $dec = json_decode($toarray, TRUE)[0];

            $uname = $dec['username'];
            $pw = $dec['password'];

            if ($_POST['username'] == $uname && $_POST['password'] == $pw) {
//                echo "matched ".$dec['user_address'];  //login here
//                $_SESSION['user_id'] = $dec['user_address'];
                $_SESSION['user'] = $dec['username'];
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

    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/devicons/css/devicons.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
</head>
<body>
<div>
<?php
$error = '';
?>

<form id="login-form" class="login-form" name="form1" method="post" action="index.php">
    <input type="hidden" name="is_login" value="1">
    <div class="h1">POC -Login</div>
    <div id="form-content">
        <div class="group">
            <label for="username">Username</label>
            <div><input id="text" name="username" class="form-control required" type="username" placeholder="Username">
            </div>
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
            <div><input name="login" type="submit" value="Submit"/></div>
        </div>
    </div>
    <div id="form-loading" class="hide"><i class="fa fa-circle-o-notch fa-spin"></i></div>
</form>
<?php
if (empty($users)){
   ?>
    <div class="text-center col"><button type="button" class="btn btn-primary text-center" data-toggle="modal" data-target="#addUsersModal"><i
                class="fa fa-user"></i> Add first user
    </button></div>
<?php
}
?></div>

<div class="modal" id="addUsersModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add a new user</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div>
                    <div>
                        <form action="" id="adduser">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" name="username" id="username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>

                            <button type="submit" class="btn btn btn-success"><i class="fa fa-save"></i> Save
                            </button>
                        </form>
                    </div>
                    <!--                        <div>Supported file types: PDF, JPG, JPEG, PNG</div>-->
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-cancel"></i> Close
                </button>
            </div>

        </div>
    </div>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Plugin JavaScript -->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<script type="text/javascript">


    $("form#adduser").on('submit', (function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: 'initianuser.php',
            enctype: 'multipart/form-data',
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                $('#addUsersModal').modal('toggle');
                // $('#feedback').text(result);
                alert(result);

                // location.reload();

            }
        });
    }));

</script>
</body>
</html>
