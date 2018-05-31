<?php
require_once('./inc/config.php');
//require_once 'functions.php';
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
<!--    <link href="./css/font-awesome.min.css" rel="stylesheet">-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" type="text/css">-->
    <link rel="stylesheet" href="./css/bootstrap.min.css" type="text/css">
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
            <span> <button type="button" class="btn btn-secondary" id="signout"> <i
                            class="fa fa-sign-out"></i>Logut </button></span>
        </span>
    </div>

    <div id="container">
        <div class="left" style="">
            <div style="margin-top: 0px;margin-bottom: 15px; padding: 5px 5px; font-size: 16px; color: #555">
                <div id="search" style="width: 850px;height: 480px;">
                    <img id="displayimage" class="" src="" style="height: 480px; margin: auto; width: auto;">
                    <!--                    <img id="" src="http://localhost:8080/ipfs/QmZGqh7ctekogq8iN5dPEMN7xoBXmzzsFuqBp9FgsunzrM" style="height: 480px; margin: fill; width: auto;">-->
                </div>
            </div>
            <div class="btn-group text-center" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i
                            class="fa fa-plus"></i> Add Title
                </button>

                <button type="button" class="btn btn-success" id="viewdetails"><i
                            class="fa fa-edit"></i> Modify
                </button>

                <!--                <button type="button" class="btn btn-danger">Deactivate</button>-->
            </div>
        </div>
        <div class="right">
            <div id="advertisements">
                <div class="title">Block Explorer</div>
                <div class="content explorer" id="pagexplorer">


                </div>
<!--                <div id="" class="" style="width: 100%">-->
<!--                    <div class="wrap">-->
<!--                        <input type="text" id="q" placeholder="Search for titles" class="container-fluid"/>-->
<!--                    </div>-->
<!--                </div>-->
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

                                <div class="form-group">
                                    <label for="userights">User rights: </label>
                                    <label class="checkbox-inline"><input type="checkbox" value="" name="admin">
                                        Admin</label>
                                    <label class="checkbox-inline"><input type="checkbox" value="" name="issue">
                                        Issue</label>
                                    <!--                                    <label class="checkbox-inline"><input type="checkbox" value=""> Receive</label>-->
                                    <label class="checkbox-inline"><input type="checkbox" value="" name="connect">
                                        Connect</label>
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
    <script type="text/javascript" src="./js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/cufon-yui.js"></script>
    <script type="text/javascript">
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
                }

            })
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

        function setImage(source, identifier) {
            console.log(source);
            $('#displayimage').attr('src', 'http://localhost:8080/ipfs/' + source);
            document.getElementById('assetissueid').value = identifier;

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
                    if (result === "saved") {
                        location.reload();
                    }
                    alert(result);
                }
            });
        }));

        $("#signout").on('click', (function (e) {
            window.location = "http://localhost/unra/";
        }));
        $("#viewdetails").on('click', (function (e) {
            var isid = document.getElementById('assetissueid').value;
            window.location = "http://localhost/unra/assetdetails.php?id=" + isid;
        }));

    </script>
</body>
</html>