<?php

global $CONFIG;

$catId = (int)get_input("categoryId");
if(!empty($catId)) {
    $cats = getCategories();
    $cat = get_metastring($catId);

    if(in_array($cat, $cats)) {

        $faqs = getFaqs($cat);

        if(!empty($faqs)) {
            $display = "<h3>" . elgg_echo("faq:list:category_title") . $cat . "</h3><br>";

            foreach($faqs as $faq) {
                $display .= elgg_view("object/faq", array("entity" => $faq));
            }
        } else {
            forward($CONFIG->wwwroot . "faq/");
        }
    } else {
        register_error(elgg_echo("faq:list:no_category"));
        forward($CONFIG->wwwroot . "faq/");
    }
} else {
    register_error(elgg_echo("faq:list:no_category"));
    forward($CONFIG->wwwroot . "faq/");
}

?>

<div>
    <div id="result">
        <?php echo $display; ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var hash=location.hash;
        if (hash){
            var aID = '#aID'+hash.substring(4);
            $(aID).show();
        }
    });
</script>

<?php
if(elgg_is_admin_logged_in() && !empty($catId)) {
?>

<script type="text/javascript">
    function showEditOptions(){
        $('#beginEdit').hide();

        $('#editOptions').show();
        $('div[id^="faqSelect"]').each(function(){
            $('#' + this.id).show();
        });
    }

    function hideEditOptions(){
        $('#editOptions').hide();
        $('div[id^="faqSelect"]').each(function(){
            $('#' + this.id).hide();
        });

        $('#beginEdit').show();
    }

    function selectAll(){
        $('div[id^="faqSelect"] input[type="checkbox"]').each(function(){
            $('input[id="' + this.id + '"]').attr("checked",true);
        });
    }

    function selectNone(){
        $('div[id^="faqSelect"] input[type="checkbox"]').each(function(){
            $('input[id="' + this.id + '"]').attr("checked",false);
        });
    }

    function changeCategory(){
        var selVal = $('#newCategory').val();

        if(selVal != ""){
            var i = 0;
            var postData = "";

            $('div[id^="faqSelect"] input[type="checkbox"]:checked').each(function(){
                postData = postData + "<input type='hidden' value='" + this.value + "' name='faqGuid[" + i + "]' />";
                i++;
            });

            if(i > 0){
                if(selVal == "new"){
                    var retVal = prompt("<?php echo elgg_echo("faq:list:edit:new_category"); ?>", "");
                    if(retVal != "" && retVal != null){
                        selVal = retVal;
                    } else {
                        $('#newCategory').val('');
                        return null;
                    }
                }

                postData = postData + "<input type='hidden' value='" + selVal + "' name='category' />";

                if(confirm("<?php echo elgg_echo("faq:list:edit:confirm:question"); ?>" + i + "<?php echo elgg_echo("faq:list:edit:confirm:category")?>" + selVal)){
                    $('#changeCategoryForm').append(postData);
                    $('#changeCategoryForm').submit();
                } else {
                    $('#newCategory').val('');
                }
            } else {
                alert("<?php echo elgg_echo("faq:list:edit:category:please"); ?>");
                $('#newCategory').val('');
            }
        }
    }
</script>

<div>
    <div id="beginEdit" class="listEditBegin">
        <br>
        <input class="elgg-button elgg-button-submit" type="button" name="beginEdit" value="<?php echo elgg_echo("faq:list:edit:begin"); ?>" onClick="showEditOptions();" />
    </div>
    <div id="editOptions" class="listEditOptions">
        <br>
        <div>
            <input class="elgg-button elgg-button-action" type="button" name="all" value="<?php echo elgg_echo("faq:list:edit:all"); ?>" onClick="selectAll();" />
            <input class="elgg-button elgg-button-action" type="button" name="none" value="<?php echo elgg_echo("faq:list:edit:none"); ?>" onClick="selectNone();" />
        </div>
        <div>
            <br>
            <?php echo elgg_echo("faq:change_category:description"); ?>
            <br><br>
            <label><?php echo elgg_echo("faq:change_category:new_category"); ?></label>
            <br>
            <select id="newCategory" onChange="changeCategory();">
                <?php
                    $cats = getCategories();

                    $options = "<option value=''>" . elgg_echo("faq:list:edit:select:choice") . "</option>\n";
                    foreach($cats as $category) {
                        if($category != $cat) {
                            $options .= "<option value='" . $category . "'>" . $category . "</options>\n";
                        }
                    }
                    $options .= "<option value='new'>" . elgg_echo("faq:list:edit:select:new") . "</option>\n";

                    echo $options;
                ?>
            </select>
            <br><br>
            <input class="elgg-button elgg-button-cancel" type="button" name="cancel" value="<?php echo elgg_echo("cancel"); ?>" onClick="hideEditOptions();" />
                <?php echo elgg_view("input/form", array("id" => "changeCategoryForm", "action" => $CONFIG->wwwroot . "action/faq/changeCategory")); ?>
        </div>
        <div class="clearFloat"></div>
    </div>
</div>

<?php
}
