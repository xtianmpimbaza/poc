<div class="title">Block Explorer</div>
<div class="content explorer">

    <?php
    $funs = new Functions();
    $assets = $funs->listAssets();
    if(!empty($assets)){
        ?>
        <input type="hidden" id="defaultimage" name="defaultimage" value="<?php echo $assets[0]['details']['file'];?>"/>
        <?php
        foreach ($assets as $item) {

            ?>
            <div class="item">
                <strong><a href="#" onclick="setImage('<?php echo $item['details']['file'];?>')" ><?php echo $item['issuetxid']; ?></a></strong><br/>
            </div>
            <?php
        }
    }
    ?>

</div>
<div id="" class="" style="width: 100%">
    <div class="wrap">
        <input type="text" id="q" placeholder="Search for titles"/>
    </div>
</div>

<script type="text/javascript" src="./js/cufon-yui.js"></script>
<script type="text/javascript" src="./fonts/Vegur.font.js"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        var def = $("#defaultimage").val();
        setImage(def);
    });
    function setImage(source) {
        console.log(source);
        $('#displayimage').attr('src', 'uploads/'+source);
    }
</script>