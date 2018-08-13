<?php
session_start();
error_reporting(0);
require_once '../functions.php';
require '../ipfs/IPFS.php';

use Cloutier\PhpIpfsApi\IPFS;

// connect to ipfs daemon API server
$ipfs = new IPFS("localhost", "8080", "5001");

$funs = new Functions();

//$usr = $_SESSION['user_id'];

if (isset($_POST['token'])) {
    $token = $_POST['token'];
    $assets = $funs->listAssets();

    if ($token == "load_image") {
        if (!empty($assets)) {
            $assets = array_reverse($assets);
            $feed_data = json_encode(array('file' => $assets[0]['details']['file'], 'lat' => $assets[0]['details']['lat'], 'long' => $assets[0]['details']['long']), JSON_FORCE_OBJECT);
            print_r($feed_data);
        }
    } elseif ($token == "load_issueid") {
        if (!empty($assets)) {
            $assets = array_reverse($assets);
            echo $assets[0]['issuetxid'];
        }
    } elseif ($token == "grant_admin_rights") {
        $funs->grantFrom($_POST['userid'], "admin,connect,issue,receive,create,send");
        $errors = $funs->getErrors();
        if ($errors != "" && $errors != null) {
            echo $funs->getErrors();
        } else {
            echo "Admin rights granted";
        }

    } elseif ($token == "add_detail_stream") {

        //------------------------------------------------------


        if (isset($_FILES["sp_file"]["type"])) {

            $filename = $_FILES["sp_file"]["name"];
            $file_basename = substr($filename, 0, strripos($filename, '.')); // get file name
            $file_ext = substr($filename, strripos($filename, '.')); // get file extention


            $stream = $_POST['sp_stream'];
            $parent_id = $_POST['sp_parent_id'];
            $reason = $_POST['sp_reason'];
            $owner = $_POST['sp_owner'];
            $identifier = "" . time();

            $validextensions = array("jpeg", "jpg", "png");
            $temporary = explode(".", $filename);
            $file_extension = end($temporary);

            if ((($_FILES["sp_file"]["type"] == "image/png") || ($_FILES["sp_file"]["type"] == "image/jpg") || ($_FILES["sp_file"]["type"] == "image/jpeg")
                ) && in_array($file_extension, $validextensions)) {
                if ($_FILES["sp_file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["sp_file"]["error"] . "<br/><br/>";
                } else {
                    $sourcePath = $_FILES['sp_file']['tmp_name']; // Storing source path of the file in a variable

                    $image = $_FILES['sp_file']['tmp_name'];
                    $fo = fopen($_FILES['sp_file']['tmp_name'], "r");
                    $imageContent = fread($fo, filesize($image));
                    $hash = $ipfs->add($imageContent);

                    if ($hash != '' && $hash != null) {

                        $custom_fields = array('reason' => $reason, 'owner' => $owner, 'file' => $hash, 'identifier' => $identifier, 'parent_id' => $parent_id);
                        $hex = $funs->strToHex(json_encode($custom_fields));

                        $fb = $funs->publishFrom($stream, $parent_id, $hex);

                        $errors = $funs->getErrors();

                        if ($errors != "" && $errors != null) {
                            echo $funs->getErrors();
                        } else {
                            echo "Update made successifully";
                        }

                    } else {
                        echo "error occured, file not saved";
                    }
                }
            } else {
                echo "Invalid file Type";
            }
        } else {
            echo 'no file';
        }
        //--------------------------------------------------------------

    } elseif ($token == "load_explorer") {

        if (!empty($assets)) {
            $assets = array_reverse($assets);
            ?>
            <input type="hidden" id="defaultimage" name="defaultimage"
                   value="<?php echo $assets[0]['details']['file']; ?>"/>


            <?php
            foreach ($assets as $item) {
//                $toarray =  "[".item."]";
                $feed_data = json_encode(array('file' => $assets[0]['details']['file'], 'lat' => $assets[0]['details']['lat'], 'long' => $assets[0]['details']['long']), JSON_FORCE_OBJECT);
                $lat = $item['details']['lat'] ? $item['details']['lat'] : "0";
                $long = $item['details']['long'] ? $item['details']['long'] : "0";
//                echo $lat;
                ?>
                <div class="item">
                    <strong><a href="#"
                               onclick="setImage('<?php echo $item['details']['file']; ?>//', '<?php echo $item['issuetxid']; ?>//', '<?php echo $lat; ?>//', '<?php echo $long; ?>//')"><?php echo $item['details']['file']; ?></a></strong><br/>
                    <!--                                        <br>-->
                    <span style="padding-left: 4px;">Name :
                        <?php echo $item['name']; ?></span><br>
                    <span style="padding-left: 4px;">Land owner:
                        <?php echo $item['details']['owner']; ?></span><br>
                    <span style="padding-left: 4px;">Block number:
                        <?php echo $item['details']['block']; ?></span>
                </div>

                <?php
            }

        }
    } elseif ($token == "load_stream_items") {

        $issid = $_POST['asset'];
        $status = $_POST['status'];
        $str = $funs->listAssetsById($issid)[0]['details']['stream'];
        $no_strm = str_replace("_stream", "", $str);
        $key = str_replace("_", " ", $no_strm);

        $res = $funs->listStreamItemsByKey($str, $key);
//if $status ==
//        return $status;

        ?>

        <div class="bg bg-warning container" style="padding: 4px; font-weight: bold;">
            Updates
        </div>

        <?php
        if (!empty($res)) {
            $res = array_reverse($res);

            foreach ($res as $item) {
                $it = $funs->hexToStr($item['data']);
                $toarray = "[" . $it . "]";
                $dec = json_decode($toarray, TRUE)[0];
                ?>
                <div class="item">
                    <div class="row">
                        <div class="col-md-10">
                            <strong><a href="#"
                                       onclick="setImage('<?php echo $dec['file']; ?>')"><?php echo $dec['file']; ?></a></strong>
                            <br>
                            <span style="padding-left: 4px;">Land owner : <?php echo $dec['owner']; ?></span><br>
                            <span style="padding-left: 4px;">Reason: <?php echo $dec['reason']; ?></span><br>
                        </div>
                        <div class="col-md-2">
                            <?php if ($status == 'show_edit') { ?>
                                <button class="btn btn-info btn-sm"
                                        onclick="return seperate('<?php echo($dec['identifier']); ?>//','<?php echo $str; ?>//');">
                                    <i class="fa fa-edit"></i></button>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row" style="">

                        <?php
                        $det = $funs->listStreamItemsByKey($str, $dec['identifier']);
                        if (!empty($det)) {
                            $det = array_reverse($det);

                            foreach ($det as $itm) {
                                $tm = $funs->hexToStr($itm['data']);
                                $toarray = "[" . $tm . "]";
                                $dec_itm = json_decode($toarray, TRUE)[0];
                                ?>
                                <div class="container" style="margin-left: 10%;"><a href="#"
                                                                                    onclick="setImage('<?php echo $dec_itm['file']; ?>')"><?php echo $dec_itm['file']; ?></a>
                                </div>
                                <?php
                            }

                        }
                        ?>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <?php
    } elseif ($token == "deactivate") {
        $custom_fields = array('status' => "deactivated");
        $hex = $funs->strToHex(json_encode($custom_fields));

        $str = $funs->listAssetsById($_POST['txid'])[0]['details']['stream'];
        $fb = $funs->publishFrom($str, $_POST['st_key'] . ' deactivated', $hex);

        $errors = $funs->getErrors();

        if ($errors != "" && $errors != null) {
            echo $funs->getErrors();
        } else {
            echo "Asset deactivated";
        }
    }


}
?>
