<?php

$faq = $vars["entity"];

if(elgg_is_admin_logged_in()) {
    $delBody = elgg_view("input/hidden", array("name" => "guid", "value" => $faq->guid));
    $delForm = elgg_view("input/form", array("id" => "delForm" . $faq->guid, "action" => elgg_get_site_url() . "action/faq/delete", "body" => $delBody));
}

?>

<div>
    <table>
        <tr>
            <?php if(elgg_is_admin_logged_in()) { ?>
                <td><div id="faqSelect<?php echo $faq->guid; ?>" class="faqSelect"><input type="checkbox" name="selectQuestion" id="selectQuestion<?php echo $faq->guid; ?>" value="<?php echo $faq->guid; ?>" /></div></td>
            <?php } ?>
            <td width="100%">
                <a href="javascript:void(0);" id="qID<?php echo $faq->guid; ?>" onClick="$('#aID<?php echo $faq->guid; ?>').toggle();"><?php echo $faq->question; ?></a>
            </td>
            <?php if(elgg_is_admin_logged_in()) { ?>
                <!-- ADMIN options -->
                <td>
                    <div class="faqedit" onClick="document.location.href='<?php echo elgg_get_config('wwwroot'); ?>faq/edit?id=<?php echo $faq->guid; ?>'"></div>
                </td>
                <td>
                    <div class="elgg-icon elgg-icon-delete" onClick="$('#delForm<?php echo $faq->guid; ?>').submit();">
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $('#delForm<?php echo $faq->guid; ?>').submit(function(){
                                    return confirm("<?php echo elgg_echo("faq:delete:confirm"); ?>");
                                });
                            });
                        </script>
                        <?php echo $delForm; ?>
                    </div>
                </td>
            <?php } ?>
        </tr>
    </table>
    <div id="aID<?php echo $faq->guid; ?>" class="answer">
        <?php echo elgg_view('output/longtext', array('value' => $faq->answer)); ?>
    </div>
</div>
