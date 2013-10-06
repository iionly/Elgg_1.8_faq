<?php

$user = elgg_get_logged_in_user_entity();

$formBody = elgg_view("input/text", array("name" => "question"));
$formBody .= elgg_view("input/hidden", array("name" => "userGuid", "value" => $user->guid));
$formBody .= elgg_echo("faq:ask:description") . "<br><br>";
$formBody .= elgg_view("input/submit", array("name" => "submit", "value" => elgg_echo("faq:ask:button")));

$form = elgg_view("input/form", array("action" => elgg_get_site_url(). "action/faq/ask", "body" => $formBody));

?>

<div>
    <h3><?php echo elgg_echo("faq:ask:title"); ?></h3><br>
</div>

<div>
    <label><?php echo elgg_echo("faq:ask:label"); ?></label><br>
    <?php echo $form; ?>
</div>
