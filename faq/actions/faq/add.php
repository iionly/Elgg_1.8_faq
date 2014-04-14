<?php
/**
 * A Frequently Asked Question Plugin
 *
 * @module faq
 * @author ColdTrick
 * @copyright ColdTrick 2009-2014
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @link http://www.coldtrick.com
 *
 * Updated for Elgg 1.8 by iionly
 * iionly@gmx.de
 */

$question = get_input("question");
$answer = get_input("answer");
$oldCat = get_input("oldCat");
$newCat = get_input("newCat");
$access = (int)get_input("access");

if(!empty($question) && !empty($answer) && !empty($access) && (!empty($oldCat) || !empty($newCat))) {
    $cat = "";
    if($oldCat == "newCat" && !empty($newCat)) {
        $cat = ucfirst(strtolower($newCat));
    } else {
        $cat = ucfirst(strtolower($oldCat));
    }

    if(!empty($cat)) {
        $faq = new FAQObject();

        $faq->container_guid = elgg_get_config('site_guid');
        $faq->owner_guid = elgg_get_config('site_guid');

        $faq->category = $cat;
        $faq->question = $question;
        $faq->answer = $answer;
        $faq->access_id = $access;

        if($faq->save()) {
            system_message(elgg_echo("faq:add:success"));
        } else {
            register_error(elgg_echo("faq:add:error:save"));
        }
    } else {
        register_error(elgg_echo("faq:add:error:invalid_input"));
    }
} else {
    register_error(elgg_echo("faq:add:error:invalid_input"));
}

forward(elgg_get_site_url() . "faq/list?categoryId=" . get_metastring_id($faq->category));
