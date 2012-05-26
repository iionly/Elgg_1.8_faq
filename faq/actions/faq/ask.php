<?php
/**
 * A Frequently Asked Question Plugin
 *
 * @module faq
 * @author ColdTrick
 * @copyright ColdTrick 2009
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @link http://www.coldtrick.com
 *
 * Updated for Elgg 1.8 by iionly
 * iionly@gmx.de
 */

global $CONFIG;

action_gatekeeper();
gatekeeper();

$question = get_input("question");
$guid = get_input("userGuid");

if(!empty($question) && !empty($guid)) {
    $user = get_user($guid);

    if(!empty($user)) {
        $faq = new ElggObject();
        $faq->subtype = "faq";

        $faq->container_guid = $user->guid;
        $faq->owner_guid = $user->guid;

        $faq->question = $question;
        $faq->userQuestion = true;

        if($faq->save()) {
            $notify = notify_user($user->guid, $user->site_guid, elgg_echo("faq:ask:new_question:subject"), sprintf(elgg_echo("faq:ask:new_question:message"), $question));
            $admins = notifyAdminNewQuestion();

            if(in_array(true, $notify)) {
                system_message(elgg_echo("faq:ask:new_question:send"));
            } else {
                register_error(elgg_echo("faq:ask:error:not_send"));
            }
        } else {
            register_error("faq:ask:error:save");
        }
    } else {
        register_error("faq:ask:error:no_user");
    }
} else {
    register_error("faq:ask:error:input");
}

forward($CONFIG->wwwroot . "faq");
