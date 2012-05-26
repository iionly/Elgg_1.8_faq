<?php

if(elgg_get_plugin_setting("userQuestions", "faq") == "yes") {
    $allow = true;
} else {
    $allow = false;
}

if($allow) {
    $count = elgg_get_entities_from_metadata(array('metadata_name' => "userQuestion",
                                                   'metadata_value' => true,
                                                   'type' => "object",
                                                   'subtype' => "faq",
                                                   'limit' => 0,
                                                   'count' => true));

    if($count > 0) {
        $open = elgg_get_entities_from_metadata(array('metadata_name' => "userQuestion",
                                                      'metadata_value' => true,
                                                      'type' => "object",
                                                      'subtype' => "faq",
                                                      'limit' => $count));

        // Category selector
        $categories = getCategories();

        foreach($open as $faq) {
            $content .= "<div class='askedQuestion' id='question" . $faq->guid . "'><table><tr><td class='askedLink''><a href='javascript:void(0);' onClick='show(" . $faq->guid . ");'>" . $faq->question . "</a></td><td class='askedSince'>" . elgg_echo("faq:asked:added") . " " . elgg_view_friendly_time($faq->time_created) . "</td></tr></table></div>\n";
            $content .= "<div class='clearfloat'></div>";

            // Category selector
            $select = "<select name='oldCat' id='oldCat' onChange='checkCat(" . $faq->guid . ");'>";
            $select .= "<option value=''>" . elgg_echo("faq:add:oldcat:please") . "</option>";
            foreach($categories as $cat) {
                $select .= "<option>" . $cat . "</option>";
            }
            $select .= "<option value='newCat'>" . elgg_echo("faq:add:oldcat:new") . "</option>";
            $select .= "</select>";

            // Access selector
            $accessSelector = "<select name='access' id='access'>";
            $accessSelector .= "<option value='" . ACCESS_PUBLIC . "' selected>" . elgg_echo("PUBLIC") . "</option>";
            $accessSelector .= "<option value='" . ACCESS_LOGGED_IN . "'>" . elgg_echo("LOGGED_IN") . "</option>";
            $accessSelector .= "</select>";

            // User who asked the question
            $user = get_user($faq->owner_guid);

            // Create elements
            $formElements = "<label>" . elgg_echo("faq:add:question") . "</label>" . " (" . elgg_echo("faq:asked:by") . "<a href=\"{$user->getURL()}\">{$user->name}</a>" . ")" . "<br>";
            $formElements .= elgg_view("input/hidden", array("name" => "guid", "value" => $faq->guid));
            $formElements .= elgg_view("input/hidden", array("name" => "originalQuestion", "value" => $faq->question));
            $formElements .= elgg_view("input/text", array("name" => "question", "value" => $faq->question));
            $formElements .= "<br><br>";
            $formElements .= "<label>" . elgg_echo("faq:asked:add") . "</label><br>";
            $formElements .= "<input type='radio' name='add' value='yes' onChange='addQuestion(" . $faq->guid . ");'>" . elgg_echo("option:yes");
            $formElements .= "<input type='radio' name='add' value='no' onChange='addQuestion(" . $faq->guid . ");'>" . elgg_echo("option:no");
            $formElements .= "<br><br>";
            $formElements .= "<label>" . elgg_echo("faq:add:category") . "<br>";
            $formElements .= $select . "<br>";
            $formElements .= elgg_view("input/text", array("name" => "newCat", "disabled" => true)) . "<br><br>";
            $formElements .= "<label>" . elgg_echo("faq:add:answer") . "</label>";
            $formElements .= elgg_view("input/longtext", array("name" => "textanswer".$faq->guid)) . "<br>";
            $formElements .= "<label>" . elgg_echo("access") . "</label><br>";
            $formElements .= $accessSelector . "<br><br>";
            $formElements .= elgg_view("input/submit", array("name" => "save", "value" => elgg_echo("save"))) . "&nbsp;";
            $formElements .= elgg_view("input/reset", array("name" => "cancel", "value" => elgg_echo("cancel"), "type" => "reset", "js" => "onClick='cancelForm(" . $faq->guid . ");'"));

            $form = elgg_view("input/form", array("name" => "answer",
                              "id" => "answer" . $faq->guid,
                              "body" => $formElements,
                              "action" => $CONFIG->wwwroot . "action/faq/answer"));

            $content .= "<div class='askedAnswer' id='formDiv" . $faq->guid . "'>\n";
            $content .= $form;
            $content .= "</div>\n";
            $content .= '<script type="text/javascript">';
            $content .= "$(document).ready(function(){";
            $content .= "	$('#answer".$faq->guid."').each(function(){";
            $content .= "		$('#' + this.id).submit(function(){";
            $content .= "			return validateForm(this);";
            $content .= "		});";
            $content .= "	});";
            $content .= "});";
            $content .= '</script>';
        }
    } else {
        $content = elgg_echo("faq:asked:no_questions");
    }
} else {
    $content = elgg_echo("faq:asked:not_allowed");
}

?>

<script type="text/javascript">
    function show(id){
        $("div[id^='question']").each(function(){
            $('#' + this.id).show();
        });

        $("div[id^='formDiv']").each(function(){
            $('#' + this.id).hide();
        });

        $("#question" + id).hide();
        $("#formDiv" + id).show();
    }

    function cancelForm(id){
        $("#question" + id).show();
        $("#formDiv" + id).hide();
    }

    function addQuestion(id){
        var addVal = $("#answer" + id + " input[name='add']:checked").val();

        if(addVal == "yes"){
            $("#answer" + id + " #oldCat").removeAttr("disabled");
            $("#answer" + id + " #access").removeAttr("disabled");
            $("#answer" + id + " #oldCat").removeAttr("readonly");
            $("#answer" + id + " #access").removeAttr("readonly");
            checkCat(id);
        } else {
            $("#answer" + id + " #oldCat").attr("disabled", true);
            $("#answer" + id + " #access").attr("disabled", true);
            $("#answer" + id + " input[name='newCat']").attr("disabled", true);
        }
    }

    function checkCat(id){
        var cat = $("#answer" + id + " #oldCat").val();

        if(cat == "newCat"){
            $("#answer" + id + " input[name='newCat']").removeAttr("disabled").removeAttr("readonly");
        } else {
            $("#answer" + id + " input[name='newCat']").attr("disabled", true);
        }
    }

    function validateForm(form){
        var formID = '#' + form.id;
        if (tinyMCE)
            tinyMCE.triggerSave();
        var title = $(formID + ' input[name="question"]').val();
        var addVal = $(formID + " input[name='add']:checked").val();
        var oldCat = $(formID + ' #oldCat').val();
        var text = $(formID + ' textarea[name="text'+form.id+'"]').val();

        var result = true;
        var focus = false;
        var msg = "";

        // Is there a question
        if(title == ""){
            result = false;
            msg = msg + "<?php echo elgg_echo("faq:add:check:question"); ?>\n";
            $(formID + ' input[name="question"]').focus();
            focus = true;
        }

        // Add to FAQ?
        if(addVal == undefined){
            result = false;
            msg = msg + "<?php echo elgg_echo("faq:asked:check:add"); ?>\n";
        } else if (addVal == "yes"){
            // Yes!!
            // Check category
            if(oldCat == ""){
                result = false;
                msg = msg + "<?php echo elgg_echo("faq:add:check:category"); ?>\n";
            }
            // Check new category
            if(oldCat == "newCat"){
                var newCat = $('input[name="newCat"]').val();
                if(newCat == ""){
                    result = false;
                    msg = msg + "<?php echo elgg_echo("faq:add:check:category"); ?>\n";
                    if(!focus){
                        $(formID + ' input[name="newCat"]').focus();
                        focus = true;
                    }
                }
            }
        }

        // Check answer
        if(text == ""){
            result = false;
            msg = msg + "<?php echo elgg_echo("faq:add:check:answer"); ?>\n";
            if(!focus){
                $(formID + ' textarea[name="text'+form.id+'"]').focus();
                focus = true;
            }
        }

        if(!result){
            alert(msg);
        }

        return result;
    }
</script>

<div>
    <h3><?php echo elgg_echo("faq:asked:title"); ?></h3><br>
</div>

<div>
    <?php echo $content; ?>
</div>
