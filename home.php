<?php
require_once('./inc/config.php');
require_once 'functions.php';
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
    <link rel="stylesheet" href="./css/bootstrap.min.css" type="text/css">
</head>
<body>
<div class="container-fluid ">
    <div style="padding: 0px; ">
        <img src="img/header-logo.jpg" alt=""/>
    </div>
    <div id="container">
        <div class="left" style="">
            <div style="margin-top: 20px; padding: 25px 25px; font-size: 16px; color: #555">
                <div id="search">
                    <img id="displayimage" src="" style="width: 850px;height: 480px;margin: -35px 0px 0px -10px;">
                    <!--<img id="" src="http://localhost:8080/ipfs/QmZGqh7ctekogq8iN5dPEMN7xoBXmzzsFuqBp9FgsunzrM" >-->
                </div>
            </div>
            <div class="btn-group text-center" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add</button>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modifyModal">Modify
                </button>
                <button type="button" class="btn btn-danger">Deactivate</button>
            </div>
        </div>
        <div class="right">
            <div id="advertisements">
                <div class="title">Block Explorer</div>
                <div class="content explorer">

                    <?php
                    $funs = new Functions();
                    $assets = $funs->listAssets();
                    if (!empty($assets)) {
                        $assets = array_reverse($assets);
                        ?>
                        <input type="hidden" id="defaultimage" name="defaultimage"
                               value="<?php echo $assets[0]['details']['file']; ?>"/>
                        <?php
                        foreach ($assets as $item) {

                            ?>
                            <div class="item">
                                <strong><a href="#"
                                           onclick="setImage('<?php echo $item['details']['file']; ?>')"><?php echo $item['details']['file']; ?></a></strong><br/>
                            </div>
                            <?php
                        }
                    }
                    //    print $funs->getErrors();
                    ?>

                </div>
                <div id="" class="" style="width: 100%">
                    <div class="wrap">
                        <input type="text" id="q" placeholder="Search for titles" class="container-fluid"/>
                    </div>
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
                                    <label for="owner">Owner:</label>
                                    <input type="text" class="form-control" name="owner">
                                </div>
                                <div class="form-group">
                                    <label for="file">Scanned copy</label>
                                    <input type="file" class="form-control" name="file" id="file">
                                </div>
                                <button type="submit" class="btn btn alert-info btn-default">Save</button>
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
                                <div class="form-group text-hide">
                                    <!--                                    <label for="">Land title name:</label>-->
                                    <input type="hidden" class="form-control" name="" id="titlename">
                                </div>
                                <div class="form-group text-hide">
                                    <!--                                    <label for="owner">Owner:</label>-->
                                    <input type="hidden" class="form-control" name="owner">
                                </div>
                                <div class="form-group">
                                    <label for="file">Scanned copy</label>
                                    <input type="file" class="form-control" name="file" id="file">
                                </div>
                                <button type="submit" class="btn btn alert-info">Save</button>
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
    <script type="text/javascript" src="./js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/cufon-yui.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var def = $("#defaultimage").val();
            setImage(def);
        });

        function setImage(source) {
            console.log(source);
            $('#displayimage').attr('src', 'http://localhost:8080/ipfs/' + source);
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
                    $('#uploadimage')[0].reset();
                    if(result === "saved"){
                        location.reload();
                    }
                    alert(result);
                    // console.log(result);
                }
            });
        }));
    </script>
</body>
</html>