<?php
session_start();
require_once '../functions.php';
$funs = new Functions();
$usr = $_SESSION['user_id'];

if (isset($_POST['token'])) {
    $token = $_POST['token'];
    $assets = $funs->listAssets();

    if ($token == "load_image") {
        if (!empty($assets)) {
            $assets = array_reverse($assets);
            echo $assets[0]['details']['file'];
        }
    } elseif ($token == "load_issueid") {
        if (!empty($assets)) {
            $assets = array_reverse($assets);
            echo $assets[0]['issuetxid'];
        }
    } elseif ($token == "grant_admin_rights") {
        $funs->grantFrom($usr, $_POST['userid'], "admin,issue,receive,create,send");
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

                ?>
                <div class="item">
                    <strong><a href="#"
                               onclick="setImage('<?php echo $item['details']['file']; ?>', '<?php echo $item['issuetxid']; ?>')"><?php echo $item['details']['file']; ?></a></strong><br/>
                    <!--                    <br>-->
                    <!--                    <span style="padding-left: 4px;">Name : -->
                    <?php //echo $item['name'] ; ?><!--</span><br>-->
                    <!--                    <span style="padding-left: 4px;">Land owner:      -->
                    <?php //echo $item['details']['owner'] ; ?><!--</span><br>-->
                    <!--                    <span style="padding-left: 4px;">Block number:      -->
                    <?php //echo $item['details']['block'] ; ?><!--</span><br>-->
                    <!--                    <span style="padding-left: 4px;">Publisher:      -->
                    <?php //echo $item['details']['publisher'] ; ?><!--</span><br>-->
                </div>

                <?php
            }
        }
    } elseif ($token == "load_stream_items") {

        $issid = $_POST['asset'];
        $str = $funs->listAssetsById($issid)[0]['details']['stream'];
        $res = $funs->listStreamItems($str);
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
                    <strong><a href="#"
                               onclick="setImage('<?php echo $dec['file']; ?>')"><?php echo $dec['file']; ?></a></strong>
                    <br>
                    <span style="padding-left: 4px;">Land owner : <?php echo $dec['owner']; ?></span><br>
                    <span style="padding-left: 4px;">Reason: <?php echo $dec['reason']; ?></span><br>
                </div>
                <?php
            }
        }
        ?>


        <?php
    }


}

//    print $funs->getErrors();
?>
