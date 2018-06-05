<?php
session_start();
require_once('./inc/config.php');
//print_r($_SESSION['user_id']);
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}
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

    <link rel="stylesheet" href="./css/example.css"/>
    <link rel="stylesheet" href="./css/easyzoom.css"/>

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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUsersModal"> <i
                            class="fa fa-user"></i> Add users</button>

                <!--                <button type="button" class="btn btn-danger">Deactivate</button>-->
            </span>
            <span> <button type="button" class="btn btn-secondary" id="logout"> <i
                            class="fa fa-sign-out"></i>Logout </button></span>
            <span> <a href="users.php">View Users</a></span>
        </span>
        <span class="pull-right bg bg-warning"
              style="margin-right: 10%; font-weight: bold; margin-top: 20px; padding: 5px"><?php echo "User: " . $_SESSION['user']; ?></span>
    </div>

    <div id="container">
        <div class="left" style="">
            <div style="margin-top: 0px;margin-bottom: 15px; padding: 5px 5px; font-size: 16px; color: #555">
                <div id="search" style="width: 850px;height: 480px;">
                    <!--                    <img id="displayimage" class="" src="" style="height: 480px; margin: auto; width: auto;">-->
                    <div class="easyzoom easyzoom--overlay">
                        <a id="zoom_img" href="">
                            <img src="" id="displayimage" alt=""
                                 style="height: 480px; margin: auto; width: auto;" class=""/>
                        </a>
                    </div>
                </div>
            </div>
            <div class="btn-group text-center" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i
                            class="fa fa-plus"></i> Add Title
                </button>

                <button type="button" class="btn btn-success" id="viewdetails"><i
                            class="fa fa-edit"></i> Modify
                </button>
                <span style="margin-left: 12px; font-weight: bold; color: #002752;" id="feedback"> </span>

                <!--                <button type="button" class="btn btn-danger">Deactivate</button>-->
            </div>
        </div>
        <div class="right">
            <div id="advertisements">
                <div class="title">Block Explorer</div>
                <div class="content explorer" id="pagexplorer">

                </div>
            </div>

        </div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add a land title</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div>
                        <div>
                            <form action="" id="uploadimage">
                                <div class="form-group">
                                    <label for="titlename">Land title name:</label>
                                    <input type="text" class="form-control" name="titlename" id="titlename">
                                </div>
                                <div class="form-group">
                                    <label for="owner">Land owner:</label>
                                    <input type="text" class="form-control" name="owner" id="owner">
                                </div>
                                <div class="form-group">
                                    <label for="titlename">Block number:</label>
                                    <input type="text" class="form-control" name="block" id="block">
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-cancel"></i> Close
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!-- The Modal -->
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
                            <form action="" id="">
                                <div class="form-group text-hide">
                                    <!--                                    <label for="">Land title name:</label>-->
                                    <input type="hidden" class="form-control" name="" id="titlename">
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
            <input type="hidden" id="assetissueid" name="assetissueid" value=""/>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/easyzoom.js"></script>
    <script>
        // Instantiate EasyZoom instances
        // var $easyzoom = $('.easyzoom').easyZoom();

    </script>

    <script type="text/javascript">

        var easyzoom = $('.easyzoom').easyZoom ();
        var api      = easyzoom.data ('easyZoom');

        $(document).ready(function () {
            loadImage();
            loadExplorer();
            // var def = $("#defaultimage").val();
            // setImage(def);
            loadissueid();
        });

        function loadExplorer() {
            $.ajax({
                type: "POST",
                url: "loader/pageloader.php",
                data: {
                    token: "load_explorer"
                },
                success: function (data) {
                    $('#pagexplorer').html(data);
                }

            })
        }

        function loadImage() {
            $.ajax({
                type: "POST",
                url: "loader/pageloader.php",
                data: {
                    token: "load_image"
                },
                success: function (data) {

                    $('#displayimage').attr('src', 'http://localhost:8080/ipfs/' + data);
                    $('a#zoom_img').attr('href', 'http://localhost:8080/ipfs/' + data);
                    // var std_src = 'http://localhost:8080/ipfs/' + source;
                    // var zoom_src = 'http://localhost:8080/ipfs/' + source;
                    // api.swap (std_src, zoom_src);
                }

            })
        }

        function switch_image (std_src, zoom_src) {
            //std_src   = the source to your standard-image (small verison)
            //zoom_src  = the source to your zoom-image (big version)
            api.swap (std_src, zoom_src);
        }

        function setImage(source, identifier) {
            var img = 'http://localhost:8080/ipfs/' + source;

            $('a#zoom_img').attr('href', 'http://localhost:8080/ipfs/' + source);
            $('#displayimage').attr('src', 'http://localhost:8080/ipfs/' + source);

            switch_image(img,img);
            document.getElementById('assetissueid').value = identifier;


        }

        function loadissueid() {
            $.ajax({
                type: "POST",
                url: "loader/pageloader.php",
                data: {
                    token: "load_issueid"
                },
                success: function (data) {
                    document.getElementById('assetissueid').value = data;
                }

            })
        }

        $("form#uploadimage").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: 'uploadfile.php',
                enctype: 'multipart/form-data',
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    $('#myModal').modal('toggle');
                    $('#feedback').text(result);
                    loadExplorer();
                    loadImage();
                    loadissueid();
                }
            });
        }));

        $("form#adduser").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: 'saveuser.php',
                enctype: 'multipart/form-data',
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    $('#addUsersModal').modal('toggle');
                    $('#feedback').text(result);
                    loadExplorer();
                    loadImage();
                    loadissueid();
                }
            });
        }));


        $("#logout").on('click', (function (e) {
            window.location = "http://localhost/unra/logout.php";
        }));
        $("#viewdetails").on('click', (function (e) {
            var isid = document.getElementById('assetissueid').value;
            window.location = "http://localhost/unra/assetdetails.php?id=" + isid;
        }));

    </script>
</body>
</html>