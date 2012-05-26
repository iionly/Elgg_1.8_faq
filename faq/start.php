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

function faq_init() {
    global $CONFIG;

    if(elgg_get_plugin_setting("publicAvailable", "faq") == "yes" || elgg_is_admin_logged_in()) {
        // Register a page handler, so we can have nice URLs
        elgg_register_page_handler('faq', 'faq_page_handler');

        // Extend CSS
        elgg_extend_view("css/elgg", "faq/css");

        if(elgg_get_plugin_setting("publicAvailable_sitemenu", "faq") == "yes" || elgg_is_logged_in()) {
            // Add menu item
            elgg_register_menu_item('site', array('name' => elgg_echo("faq:shorttitle"), 'text' => elgg_echo("faq:shorttitle"), 'href' => $CONFIG->wwwroot . "faq/"));
        }
        if(elgg_get_plugin_setting("publicAvailable_footerlink", "faq") == "yes" || elgg_is_logged_in()) {
            // Add footer link
            faq_setup_footer_menu();
        }

        // Register Actions
        elgg_register_action("faq/add", $CONFIG->pluginspath . "faq/actions/faq/add.php", "admin");
        elgg_register_action("faq/delete", $CONFIG->pluginspath . "faq/actions/faq/delete.php", "admin");
        elgg_register_action("faq/edit", $CONFIG->pluginspath . "faq/actions/faq/edit.php", "admin");
        elgg_register_action("faq/search", $CONFIG->pluginspath . "faq/actions/faq/search.php", "public");
        elgg_register_action("faq/changeCategory", $CONFIG->pluginspath . "faq/actions/faq/changeCategory.php", "admin");

        if(elgg_get_plugin_setting("userQuestions", "faq") == "yes") {
            elgg_register_action("faq/ask", $CONFIG->pluginspath . "faq/actions/faq/ask.php", "logged_in");
            elgg_register_action("faq/answer", $CONFIG->pluginspath . "faq/actions/faq/answer.php", "admin");
        }

        // Register subtype
        add_subtype("object", "faq");
    }
}

function faq_page_handler($page) {
    global $CONFIG;

    if (!isset($page[0])) {
        $page[0] = 'index';
    }

    $page_type = $page[0];
    switch ($page_type) {
        case 'index':
            $area = elgg_view_title(elgg_echo('faq:title'));
            // Add the form to this section
            $area .= elgg_view('faq/search');
            $area .= elgg_view('faq/stats');
            break;
        case 'list':
            $area = elgg_view_title(elgg_echo('faq:title'));
            // Add the form to this section
            $area .= elgg_view('faq/list');
            break;
        case 'ask':
            gatekeeper();
            $area = elgg_view_title(elgg_echo('faq:title'));
            // Add the form to this section
            $area .= elgg_view('faq/forms/ask');
            break;
        case 'asked':
            admin_gatekeeper();
            $area = elgg_view_title(elgg_echo('faq:title'));
            // Add the form to this section
            $area .= elgg_view('faq/asked');
            break;
        case 'add':
            admin_gatekeeper();
            $area = elgg_view_title(elgg_echo('faq:title'));
            // Add the form to this section
            $area .= elgg_view('faq/forms/add');
            break;
        case 'edit':
            admin_gatekeeper();
            $area = elgg_view_title(elgg_echo('faq:title'));
            // Add the form to this section
            $area .= elgg_view('faq/forms/add');
            break;
        default:
            return false;
    }

    $sidebar = elgg_view('faq/sidebar');

    // Format page
    $body = elgg_view('page/layouts/one_sidebar', array('content' => $area, 'sidebar' => $sidebar));
    // Draw it
    echo elgg_view_page(elgg_echo('faq:title'), $body);

    return true;
}

//Add a link to FAQs in the footer section
function faq_setup_footer_menu() {
    $wg_item = new ElggMenuItem('faq', elgg_echo('faq:shorttitle'), 'faq');
    elgg_register_menu_item('walled_garden', $wg_item);

    $footer_item = clone $wg_item;
    elgg_register_menu_item('footer', $footer_item);
}

//Helper functions
function getCategories() {
    $result = array();

    $metadatas = elgg_get_metadata(array('annotation_name' => "category", 'type' => "object", 'subtype' => "faq", 'limit' => getFaqCount()));

    foreach($metadatas as $metadata) {
        $cat = $metadata['value'];
        $id = get_metastring_id($cat);

        if(!in_array($id, $result)) {
            $result[$id] = $cat;
        }
    }

    natcasesort($result);

    return $result;
}

function getFaqs($category = NULL){
    return elgg_get_entities_from_metadata(array('metadata_name' => "category",
                                                 'metadata_value' => $category,
                                                 'type' => "object",
                                                 'subtype' => "faq",
                                                 'limit' => getFaqCount($category)));
}

function getFaqCount($category = NULL) {
    return elgg_get_entities_from_metadata(array('metadata_name' => "category",
                                                 'metadata_value' => $category,
                                                 'type' => "object",
                                                 'subtype' => "faq",
                                                 'count' => true));
}

function getUserQuestionsCount() {
    return elgg_get_entities_from_metadata(array('metadata_name' => "userQuestion",
                                                 'metadata_value' => true,
                                                 'type' => "object",
                                                 'subtype' => "faq",
                                                 'count' => true));
}

function notifyAdminNewQuestion(){

    global $CONFIG;

    $db_prefix = elgg_get_config('dbprefix');
    $admins1 = elgg_get_entities(array('type' => 'user',
                                       'wheres' => "{$db_prefix}users_entity.admin = 'true'",
                                       'joins' => "JOIN {$db_prefix}users_entity ON {$db_prefix}users_entity.guid = e.guid"));
    $admins2 = elgg_get_entities(array('type' => 'user',
                                       'wheres' => "{$db_prefix}users_entity.admin = 'yes'",
                                       'joins' => "JOIN {$db_prefix}users_entity ON {$db_prefix}users_entity.guid = e.guid"));

    if(is_array($admins1) && is_array($admins2)) {
        $admins = array_merge($admins1, $admins2);
    } elseif(is_array($admins1)) {
        $admins = $admins1;
    } elseif(is_array($admins2)) {
        $admins = $admins2;
    } else {
        $admins = array();
    }

    $result = array();
    foreach($admins as $admin) {
        $result[] = notify_user($admin->guid, $admin->site_guid, elgg_echo("faq:ask:notify:admin:subject"), sprintf(elgg_echo("faq:ask:notify:admin:message"), $admin->name, $CONFIG->wwwroot . "faq/asked"));
    }

    if(in_array(true, $result)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

// Initialise FAQ
elgg_register_event_handler('init', 'system', 'faq_init');
