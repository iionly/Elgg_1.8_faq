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
admin_gatekeeper();

$guid = get_input("guid");
$question = get_input("question");
$orgQuestion = get_input("originalQuestion");
$addFAQ = get_input("add");
$answer = get_input("textanswer".$guid);
$oldCat = get_input("oldCat");
$newCat = get_input("newCat");
$access = (int) get_input("access");

if(!empty($guid) && !empty($question) && !empty($orgQuestion) && !empty($addFAQ) && !empty($answer)) {
    $faq = get_entity($guid);

    if($faq->getSubtype() == "faq") {

        if($addFAQ == "yes") {
            // Add to FAQ and answer to User
            if($oldCat == "newCat" && !empty($newCat)) {
                $cat = ucfirst(strtolower($newCat));
            } else {
                $cat = ucfirst(strtolower($oldCat));
            }
            if(!empty($cat)) {
                // valid category, lets continue
                $user = get_user($faq->owner_guid);

                // Was the question adjusted?
                if($question == $orgQuestion) {
                    $same = true;
                } else {
                    $same = false;
                }

                if(!$same) {
                    $faq->question = $question;
                }

                $faq->answer = $answer;
                $faq->category = $cat;
                $faq->access_id = $access;

                $faq->container_guid = $CONFIG->site_guid;
                $faq->owner_guid = $CONFIG->site_guid;

                if(elgg_delete_metadata(array('guid' => $faq->guid, 'metadata_name' => "userQuestion", 'metadata_value' => true, 'limit' => 0))) {
                    if($faq->save()) {
                        $url = $CONFIG->wwwroot . "faq/list?categoryId=" . get_metastring_id($faq->category) . "#qID" . $faq->guid;
                        if($same) {
                            // notify user, question added and not adjusted
                            $result = notify_user($user->guid, $user->site_guid, elgg_echo("faq:answer:notify:subject"), sprintf(elgg_echo("faq:answer:notify:message:added:same"), $question, $url));
                        } else {
                            // notify user, question added and adjusted
                            $result = notify_user($user->guid, $user->site_guid, elgg_echo("faq:answer:notify:subject"), sprintf(elgg_echo("faq:answer:notify:message:added:adjusted"), $orgQuestion, $question, $url));
                        }

                        if(in_array(true, $result)) {
                            system_message(elgg_echo("faq:answer:success:added:send"));
                        } else {
                            register_error(elgg_echo("faq:answer:error:added:not_send"));
                        }
                    } else {
                        register_error(elgg_echo("faq:answer:error:save"));
                    }
                } else {
                    register_error(elgg_echo("faq:answer:error:remove"));
                }
            } else {
                register_error(elgg_echo("faq:answer:error:no_cat"));
            }
        } else {
            // Do not add to FAQ, just answer to the User
            $user = get_user($faq->owner_guid);

            if($question == $orgQuestion) {
                $result = notify_user($user->guid, $user->site_guid, elgg_echo("faq:answer:notify:subject"), sprintf(elgg_echo("faq:answer:notify:not_added:same"), $question, $answer));
            } else {
                $result = notify_user($user->guid, $user->site_guid, elgg_echo("faq:answer:notify:subject"), sprintf(elgg_echo("faq:answer:notify:not_added:adjusted"), $orgQuestion, $question, $answer));
            }

            $faq->delete();

            if(in_array(true, $result)) {
                system_message(elgg_echo("faq:answer:success:not_added:send"));
            } else {
                register_error(elgg_echo("faq:answer:error:not_added:not_send"));
            }
        }
    } else {
        register_error(elgg_echo("faq:answer:error:no_faq"));
    }
} else {
    register_error(elgg_echo("faq:answer:error:input"));
}

forward($_SERVER["HTTP_REFERER"]);
