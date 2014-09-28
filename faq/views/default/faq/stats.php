<?php

$cats = getCategories();
$faq_count = getFaqCount();
$cats_count = count($cats);

$display = elgg_echo("faq:stats:categories", array($cats_count));
$display .= elgg_echo("faq:stats:questions", array($faq_count));

if(elgg_is_admin_logged_in()) {
	$user_questions = getUserQuestionsCount();
	$display .= "<br />" . elgg_echo("faq:stats:user", array($user_questions));
}

echo $display;
