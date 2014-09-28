<?php
/**
 * Activate FAQ plugin
 *
 */

// register class
if (get_subtype_id('object', 'faq')) {
	update_subtype('object', 'faq', 'FAQObject');
} else {
	add_subtype('object', 'faq', 'FAQObject');
}
