<?php
require_once('./inc/config.php');
require_once('functions.php');
$fns = new Functions();

$id = $_GET['id'];
$asst = $fns->listAssetsById($id);
$name = $asst[0]['name'];
$owner = $asst[0]['details']['owner'];
$block = $asst[0]['details']['block'];
$stream = $asst[0]['details']['stream'];

//print_r($name." deactivated");

$status = $fns->listStreamKeyItems($stream,$name." deactivated");
//print_r($status);
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
        </span>
    </div>

    <div id="container">
        <div class="left" style="">
            <div style="margin-top: 0px;margin-bottom: 15px; padding: 5px 5px; font-size: 16px; color: #555">
                <div id="search" style="width: 850px;height: 480px;">
                    <img id="displayimage" class="" src="" style="height: 480px; margin: auto; width: auto;">
                </div>
            </div>
            <div class="btn-group text-center" role="group" aria-label="Basic example">

                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modifyModal"><i
                            class="fa fa-edit"></i> Add modified title
                </button>
                <?php if (empty($status)){?>
                <button type="button" id="deactivate" class="btn btn-danger"><i
                            class="fa fa-trash"></i> Deactivate
                </button>
                <?php }?>
                <span style="margin-left: 12px; font-weight: bold; color: #002752;" id="feedback">  </span>
            </div>
        </div>
        <div class="right">
            <div id="advertisements">
                <div class="title">Land Title Updates</div>
                <div class="content explorer" id="pagexplorer">

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
            <input type="hidden" id="assetissueid" name="assetissueid" value="<?php echo $_GET['id']; ?>"/>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            // loadImage();
            loadExplorer();
            // var def = $("#defaultimage").val();
            // setImage(def);
        });

        function loadExplorer() {
            $.ajax({
                type: "POST",
                url: "loader/pageloader.php",
                data: {
                    token: "load_stream_items",
                    asset: $('#assetissueid').val()
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
                    // console.log()
                    $('#displayimage').attr('src', 'http://localhost:8080/ipfs/' + data);
                }

            })
        }


        function setImage(source) {
            console.log(source);
            $('#displayimage').attr('src', 'http://localhost:8080/ipfs/' + source);
            // document.getElementById('assetissueid').value = identifier;

        }


        $("form#uploadimage").on('submit', (function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("asset", $('#assetissueid').val());
            $.ajax({
                type: "POST",
                url: 'savetostream.php',
                enctype: 'multipart/form-data',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    $('#modifyModal').modal('toggle');
                    $('#uploadimage')[0].reset();
                    $('#feedback').text(result);
                    loadExplorer();
                }
            });
        }));

        $("button#deactivate").on('click', (function (e) {
            var dt = $('#assetissueid').val();

            // console.log(dt);

            $.ajax({
                type: "POST",
                url: "loader/pageloader.php",
                data: {
                    token: "deactivate",
                    txid: dt,
                    st_key: $("input#titlename").val(),
                },
                success: function (data) {
                    if (data) {
                        location.reload();
                    }
                }

            });
        }));

        $("#logout").on('click', (function (e) {
            window.location = "http://localhost/unra/logout.php";
        }));
        $("#home").on('click', (function (e) {
            window.location = "http://localhost/unra/home.php";
        }));


    </script>
</body>
</html>