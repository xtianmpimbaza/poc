<?php
require_once('./inc/config.php');
require_once('functions.php');
$funs = new Functions();
$users = $funs->listStreamItems("users");

//$asst = $fns->listAssetsById($id);
//$name = $asst[0]['name'];
//$owner = $asst[0]['details']['owner'];
//$block = $asst[0]['details']['block'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>UNRA-POC</title>
    <link rel="shortcut icon" href="./img/favicon.png" type="image/x-icon"/>
    <link href="./css/global.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/devicons/css/devicons.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid ">
    <div style="padding: 0px; " class="">
        <img src="img/header-logo.jpg" alt=""/>
        <span style="" class="col ">
            <span class="btn-group " role="group" aria-label="Basic example">
            </span>
            <span> <button type="button" class="btn btn-secondary" id="home"> <i
                            class="fa fa-home"></i>Home </button></span>
            <span> <button type="button" class="btn btn-secondary" id="logout"> <i
                            class="fa fa-sign-out"></i>Logout </button></span>
<!--            background-color: rgba(10,253,94,0.28)-->
            <span style="margin-left: 12px; font-weight: bold; padding: 10px 5px; color: #002752; " id="feedback">  </span>
        </span>
    </div>

    <div id="container">

        <div>
            <br>
            <table class="table table-bordered">
                <thead>
                <th>Username</th>
                <th>Address</th>
<!--                <th>Action</th>-->
                </thead>
                <?php
                if (!empty($users)) {
                    foreach ($users as $user) {
                        $it = $funs->hexToStr($user['data']);

                        $toarray = "[" . $it . "]";
                        $dec = json_decode($toarray, TRUE)[0];

                        $uname = $dec['username'];
                        $ad = $dec['user_address'];

                        ?>
                        <tr>
                            <td><?php echo $uname; ?></td>
                            <td><?php echo $ad; ?></td>
<!--                            <td><a href="#" onclick="makeAdmin('<?php //echo $ad; ?>')"-->
<!--//                                    <button class="btn btn-primary btn-sm">Make admin</button>-->
<!--//                                </a></td>-->
                        </tr>
                        <?php
                    }
                } else {
                    echo "Error in connection";
                }
                ?>
            </table>
        </div>

    </div>

    <!-- The Modal -->
    <div class="modal" id="modifyModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Modify a land title</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div>
                        <div>
                            <form action="" id="uploadimage">
                                <input type="hidden" class="form-control" name="titlename" id="titlename"
                                       value="<?php echo $name; ?>">
                                <div class="form-group">
                                    <label for="reason">Modification Reason</label>
                                    <input type="text" class="form-control" name="reason" id="reason">
                                </div>
                                <div class="form-group">
                                    <label for="owner">Owner</label>
                                    <input type="text" class="form-control" name="owner" value="<?php echo $owner; ?>"
                                           id="owner">
                                </div>

                                <div class="form-group">
                                    <label for="file">Scanned copy</label>
                                    <input type="file" class="form-control" name="file" id="file">
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script type="text/javascript">
        // $(document).ready(function () {
            // loadImage();
            // loadExplorer();
            // var def = $("#defaultimage").val();
            // setImage(def);
        // });

        function makeAdmin(address) {
            // console.log(adress);
            $.ajax({
                type: "POST",
                url: "loader/pageloader.php",
                data: {
                    token: "grant_admin_rights",
                    userid: address
                },
                success: function (result) {
                    $('#feedback').text(result);
                }

            })
        }


        $("#logout").on('click', (function (e) {
            window.location = "http://localhost/unra/logout.php";
        }));
        $("#home").on('click', (function (e) {
            window.location = "http://localhost/unra/home.php";
        }));


    </script>
</body>
</html>