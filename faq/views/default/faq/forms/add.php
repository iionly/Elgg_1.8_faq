<?php

$id = get_input("id");

if(!empty($id)) {
    $edit = true;
    $faq = get_entity($id);
}

$count = elgg_get_entities(array('type' => "object", 'subtype' => "faq", 'limit' => false, 'offset' => 0, 'count' => true));
$metadatas = elgg_get_metadata(array('annotation_name' => "category", 'type' => "object", 'subtype' => "faq", 'limit' => $count));

$cats = array();
foreach($metadatas as $metadata) {
    $cat = $metadata['value'];
    if(!in_array($cat, $cats)) {
        $cats[] = $cat;
    }
}

$select = "<select name='oldCat' id='oldCat' onChange='checkCat();'>";
if(!$edit) {
    $select .= "<option value=''>" . elgg_echo("faq:add:oldcat:please") . "</option>";
}

foreach($cats as $cat) {
    if($edit && $faq->category == $cat) {
        $select .= "<option SELECTED>" . $cat . "</option>";
    } else {
        $select .= "<option>" . $cat . "</option>";
    }
}

$select .= "<option value='newCat'>" . elgg_echo("faq:add:oldcat:new") . "</option>";
$select .= "</select>";

// Access Selector
$accessSelector = "<select name='access'>";
if($edit) {
    if($faq->access_id == ACCESS_PUBLIC) {
        $accessSelector .= "<option value='" . ACCESS_PUBLIC . "' selected>" . elgg_echo("PUBLIC") . "</option>";
    } else {
        $accessSelector .= "<option value='" . ACCESS_PUBLIC . "'>" . elgg_echo("PUBLIC") . "</option>";
    }

    if($faq->access_id == ACCESS_LOGGED_IN) {
        $accessSelector .= "<option value='" . ACCESS_LOGGED_IN . "' selected>" . elgg_echo("LOGGED_IN") . "</option>";
    } else {
        $accessSelector .= "<option value='" . ACCESS_LOGGED_IN . "'>" . elgg_echo("LOGGED_IN") . "</option>";
    }
} else {
    $accessSelector .= "<option value='" . ACCESS_PUBLIC . "' selected>" . elgg_echo("PUBLIC") . "</option>";
    $accessSelector .= "<option value='" . ACCESS_LOGGED_IN . "'>" . elgg_echo("LOGGED_IN") . "</option>";
}
$accessSelector .= "</select>";

// Make form
$addBody = "<label>" . elgg_echo("faq:add:question") . "</label><br>";
if($edit) {
    $addBody .= elgg_view("input/text", array("name" => "question", "value" => $faq->question)) . "<br><br>";
} else {
    $addBody .= elgg_view("input/text", array("name" => "question")) . "<br><br>";
}
$addBody .= "<label>" . elgg_echo("faq:add:category") . "</label><br>";
$addBody .= $select . "<br>";
$addBody .= elgg_view("input/text", array("name" => "newCat", "disabled" => "disabled")) . "<br><br>";
$addBody .= "<label>" . elgg_echo("faq:add:answer") . "</label>";
if($edit) {
    $addBody .= elgg_view("input/longtext", array("name" => "answer", "value" => $faq->answer)) . "<br>";
} else {
    $addBody .= elgg_view("input/longtext", array("name" => "answer")) . "<br>";
}
$addBody .= "<label>" . elgg_echo("access") . "</label><br>";
$addBody .= $accessSelector . "<br><br>";
$addBody .= elgg_view("input/submit", array("name" => "save", "value" => elgg_echo("save")));

if($edit) {
    $addBody .= elgg_view("input/hidden", array("name" => "guid", "value" => $faq->guid));

    $addForm = elgg_view("input/form", array("name" => "editForm",
                         "id" => "questionForm",
                         "body" => $addBody,
                         "action" => elgg_get_site_url() . "action/faq/edit"));
} else {
    $addForm = elgg_view("input/form", array("name" => "addForm",
                         "id" => "questionForm",
                         "body" => $addBody,
                         "action" => elgg_get_site_url() . "action/faq/add"));
}

?>

<script type="text/javascript">
    function checkCat(){
        var cat = $('#oldCat').val();

        if(cat == "newCat"){
            $('input[name="newCat"]').removeAttr("disabled");
            $('input[name="newCat"]').removeAttr("readonly");
            $('input[name="newCat"]').focus();
        } else {
            $('input[name="newCat"]').attr("disabled", "disabled");
        }
    }

    function validateForm(){
        var title = $('input[name="question"]').val();
        var oldCat = $('#oldCat').val();
        if (tinyMCE)
            tinyMCE.triggerSave();

        var text = $('textarea[name="answer"]').val();

        var result = true;
        var focus = false;
        var msg = "";

        if(title == ""){
            result = false;
            msg = msg + "<?php echo elgg_echo("faq:add:check:question"); ?>\n";
            $('input[name="question"]').focus();
            focus = true;
        }
        if(oldCat == ""){
            result = false;
            msg = msg + "<?php echo elgg_echo("faq:add:check:category"); ?>\n";
        }
        if(oldCat == "newCat"){
            var newCat = $('input[name="newCat"]').val();
            if(newCat == ""){
                result = false;
                msg = msg + "<?php echo elgg_echo("faq:add:check:category"); ?>\n";
                if(!focus){
                    $('input[name="newCat"]').focus();
                    focus = true;
                }
            }
        }
        if(text == ""){
            result = false;
            msg = msg + "<?php echo elgg_echo("faq:add:check:answer"); ?>\n";
            if(!focus){
                $('textarea[name="answer"]').focus();
                focus = true;
            }
        }

        if(!result){
            alert(msg);
        }

        return result;
    }

    $(document).ready(function(){
        $('#questionForm').submit(function(){
            return validateForm();
        });
    });
</script>

<div>
    <h3><?php if ($edit) {echo elgg_echo("faq:edit:title");} else {echo elgg_echo("faq:add:title");} ?></h3><br>
</div>

<div>
    <?php echo $addForm; ?>
</div>
