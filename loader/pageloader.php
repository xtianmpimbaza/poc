<?php
require_once '../functions.php';
$funs = new Functions();

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
    } elseif ($token == "load_explorer") {

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
                               onclick="setImage('<?php echo $item['details']['file']; ?>', '<?php echo $item['issuetxid']; ?>')"><?php echo $item['details']['file']; ?></a></strong><br/>
                </div>
                <?php
            }
        }
    } elseif ($token == "load_stream_items") {
        $stream = $_POST['stream'];
        $res = $funs->listStreamItems($stream);
        ?>
        <div class="item">
            <table class="col-lg-12">
                <th class="bg bg-warning container">
                Items
                </th>
                <tr>
                    <?php
                    if (!empty($res)) {
                        $res = array_reverse($res);

                        foreach ($res as $item) {
                            echo "<td> stream item </td>";
                        }

                    }
                    ?>
                </tr>
            </table>
        </div>
        <?php
    }


}

//    print $funs->getErrors();
?>