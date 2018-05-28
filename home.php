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
<div id="header"><?php include('./inc/header.inc.php'); ?></div>

<div id="container" style="width: 100%">

    <div class="left">
        <div style="margin-top: 20px; padding: 25px 25px; font-size: 16px; color: #555">
            <div id="search">
                <img id="displayimage" src="" style="width: 850px;height: 480px;margin: -35px 0px 0px -10px;">
            </div>
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
                    ?>
                    <input type="hidden" id="defaultimage" name="defaultimage"
                           value="<?php echo $assets[0]['details']['file']; ?>"/>
                    <?php
                    foreach ($assets as $item) {

                        ?>
                        <div class="item">
                            <strong><a href="#"
                                       onclick="setImage('<?php echo $item['details']['file']; ?>')"><?php echo $item['issuetxid']; ?></a></strong><br/>
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

    <div id=""><?php include('./inc/modify.php'); ?></div>
    <div>
        <div style="font-size: 16px; color: #555">
            <div style="font: 11px Tahoma, Verdana, Geneva, sans-serif; text-align: center;">
                <div>
                    <div>
                        <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
                            <input type="file" name="file" id="file" required placeholder="select image"
                                   class=""/>
                            <input type='text' name='titlename' id='titlename' required placeholder="Title name"
                                   style="height: 30px" class=""/>
                            <input type="submit" value="Upload" class="btn btn-success btn-sm"/>
                        </form>
                    </div>
                    <div>Supported file types: PDF, JPG, JPEG, PNG</div>
                </div>

            </div>

        </div>

    </div>
    <script type="text/javascript" src="./js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <!--<script type="text/javascript" src="./js/global.js"></script>-->
    <script type="text/javascript" src="./js/cufon-yui.js"></script>
    <!--<script type="text/javascript" src="./fonts/Vegur.font.js"></script>-->
    <script type="text/javascript">
        $(document).ready(function () {
            var def = $("#defaultimage").val();
            setImage(def);
        });

        function setImage(source) {
            console.log(source);
            $('#displayimage').attr('src', 'uploads/' + source);
        }

        $("form#uploadimage").on('submit', (function (e) {
            e.preventDefault();

            // var filePath=$('#file').val();
            // var filePath = document.getElementById("file").value;
            // console.log(filePath);
            $.ajax({
                type: "POST",
                url: 'uploadfile.php',
                enctype: 'multipart/form-data',
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    // location.reload();
                    alert(result);
                    $('#uploadimage')[0].reset();
                }
            });
        }));
    </script>
</body>
</html>