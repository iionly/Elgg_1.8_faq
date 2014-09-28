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

$id = (int)get_input("guid");

if(!empty($id)) {
	$faq = get_entity($id);

	if(!empty($faq) && $faq instanceof FAQObject) {
		if($faq->delete()) {
			system_message(elgg_echo("faq:delete:success"));
		} else {
			register_error(elgg_echo("faq:delete:error:delete"));
		}
	} else {
		register_error("faq:delete:error:invalid_object");
	}
} else {
	register_error(elgg_echo("faq:delete:error:invalid_input"));
}

forward(REFERER);
