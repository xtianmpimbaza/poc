<?php
session_start();
error_reporting(0);
require_once '../functions.php';
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
                               onclick="setImage('<?php echo $item['details']['file']; ?>', '<?php echo $item['issuetxid']; ?>', '<?php echo $lat; ?>', '<?php echo $long; ?>')"><?php echo $item['details']['file']; ?></a></strong><br/>
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
        $str = $funs->listAssetsById($issid)[0]['details']['stream'];
        $no_strm = str_replace("_stream", "", $str);
        $key = str_replace("_", " ", $no_strm);
//        $res = $funs->listStreamItemsByKey($str, "creamhill lands");
        $res = $funs->listStreamItemsByKey($str, $key);
//        print_r($key);
//        $res = $funs->listStreamItems($str);
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
                                       onclick="setImage('<?php echo $dec['file']; ?>//')"><?php echo $dec['file']; ?></a></strong>
                            <br>
                            <span style="padding-left: 4px;">Land owner : <?php echo $dec['owner']; ?></span><br>
                            <span style="padding-left: 4px;">Reason: <?php echo $dec['reason']; ?></span><br>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-info btn-sm"><i class="fa fa-edit"></i></button>
                        </div>
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
