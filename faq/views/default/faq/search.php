<?php

$minimum_tag_length = elgg_get_plugin_setting("minimumSearchTagSize","faq");
if(!$minimum_tag_length) {
    $minimum_tag_length = 3;
}
$minimum_hit_count = elgg_get_plugin_setting("minimumHitCount","faq");
if(!$minimum_hit_count) {
    $minimum_hit_count = 1;
}
$search_description = elgg_echo("faq:search:description", array($minimum_tag_length, $minimum_hit_count));

?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#searchForm').submit(function(){
            if($('#searchForm input[name="search"]').val() != ""){
                $('#result').hide();
                $('#waiting').show();
                $('#result').html('');

                $.post("<?php echo elgg_get_config('wwwroot') . 'action/faq/search'; ?>", $('#searchForm').serialize(), function(data){
                    $('#result').html(data);
                    $('#waiting').hide();
                    $('#result').show();
                });
            }

            return false;
        });
    });
</script>

<div>
    <h3><?php echo elgg_echo("faq:search:title"); ?></h3><br>
</div>

<div id="search">
    <label><?php echo elgg_echo("faq:search:label"); ?></label><br>
    <form id="searchForm" action="" method="POST">
        <input type="text" name="search"><br>
        <?php echo $search_description; ?><br><br>
        <input class="elgg-button elgg-button-submit" type="submit" value="<?php echo elgg_echo("search"); ?>">
        <?php echo elgg_view('input/securitytoken'); ?>
    </form>
</div>
<br>

<div id="result" style="display:none;"></div>
<div id="waiting" style="display:none;">
    <img src="<?php echo elgg_get_config('wwwroot'); ?>_graphics/ajax_loader.gif" />
</div>
