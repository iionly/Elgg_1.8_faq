<?php
/**
 * A Frequently Asked Question Plugin
 *
 * @module faq
 * @author ColdTrick
 * @copyright ColdTrick 2009-2013
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @link http://www.coldtrick.com
 *
 * Updated for Elgg 1.8 by iionly
 * iionly@gmx.de
 */

// Initialise FAQ
elgg_register_event_handler('init', 'system', 'faq_init');

function faq_init() {
    if(elgg_get_plugin_setting("publicAvailable", "faq") == "yes" || elgg_is_admin_logged_in()) {
        // Register a page handler, so we can have nice URLs
        elgg_register_page_handler('faq', 'faq_page_handler');

        // Extend CSS
        elgg_extend_view("css/elgg", "faq/css");

        if(elgg_get_plugin_setting("publicAvailable_sitemenu", "faq") == "yes" || elgg_is_logged_in()) {
            // Add menu item
            elgg_register_menu_item('site', array('name' => elgg_echo("faq:shorttitle"), 'text' => elgg_echo("faq:shorttitle"), 'href' => elgg_get_site_url() . "faq/"));
        }
        if(elgg_get_plugin_setting("publicAvailable_footerlink", "faq") == "yes" || elgg_is_logged_in()) {
            // Add footer link
            faq_setup_footer_menu();
        }

        // Register faq pages as public pages for walled-garden
        elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'faq_public');

        // Register Actions
        $base_dir = elgg_get_plugins_path() . 'faq/actions/faq/';
        elgg_register_action("faq/add", $base_dir . "add.php", "admin");
        elgg_register_action("faq/delete", $base_dir . "delete.php", "admin");
        elgg_register_action("faq/edit", $base_dir . "edit.php", "admin");
        elgg_register_action("faq/search", $base_dir . "search.php", "public");
        elgg_register_action("faq/changeCategory", $base_dir . "changeCategory.php", "admin");

        if(elgg_get_plugin_setting("userQuestions", "faq") == "yes") {
            elgg_register_action("faq/ask", $base_dir . "ask.php", "logged_in");
            elgg_register_action("faq/answer", $base_dir . "answer.php", "admin");
        }

        // Register FAQs for site search
        elgg_register_entity_type("object", "faq");
        elgg_register_plugin_hook_handler('search', 'object:faq', 'faq_search_hook');
    }
}

function faq_search_hook($hook, $handler, $return, $params) {
    $minimum_tag_length = elgg_get_plugin_setting("minimumSearchTagSize","faq");
    if(!$minimum_tag_length) {
        $minimum_tag_length = 3;
    }
    $minimum_hit_count = elgg_get_plugin_setting("minimumHitCount","faq");
    if(!$minimum_hit_count) {
        $minimum_hit_count = 1;
    }

    $tags = strtolower($params['query']);

    $rankedArray = array();

    if($tags) {

        $tagArray = explode(" ",$tags);

        $count = elgg_get_entities(array('type' => "object", 'subtype' => "faq", 'limit' => false, 'offset' => 0, 'count' => true));

        if ($count > 0) {
            $faqs = elgg_get_entities(array('type' => "object", 'subtype' =>  "faq", 'limit' => $count));

            foreach($faqs as $faq_id => $faq) {
                if(!$faq->userQuestion) {
                    $count = 0;

                    foreach($tagArray as $tag) {

                        if(strlen($tag) >= $minimum_tag_length) {
                            $count += substr_count(strtolower($faq->question), $tag);
                            $count += substr_count(strtolower($faq->answer), $tag);
                            $count += substr_count(strtolower($faq->category), $tag);
                        }
                    }
                    if($count >= $minimum_hit_count) {
                        $rankedArray[$faq_id] = $count;
                    }
                }
            }

            if(count($rankedArray) > 0) {
                arsort($rankedArray);

                $found_entities = array();
                foreach($rankedArray as $faq_id=>$count) {
                    $faqs[$faq_id]->setVolatileData('search_matched_title', $faqs[$faq_id]->question);
                    $faqs[$faq_id]->setVolatileData('search_matched_description', $faqs[$faq_id]->answer);
                    $found_entities[] = $faqs[$faq_id];
                }
                return array('count' => count($found_entities), 'entities' => $found_entities);
            }
        }
    }

    return false;
}


function faq_public($hook, $handler, $return, $params) {
    $pages = array('faq', 'faq/list', 'action/faq/search');
    return array_merge($pages, $return);
}

function faq_page_handler($page) {
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
        $result[] = notify_user($admin->guid, $admin->site_guid, elgg_echo("faq:ask:notify:admin:subject"), elgg_echo("faq:ask:notify:admin:message", array($admin->name, elgg_get_site_url() . "faq/asked")));
    }

    if(in_array(true, $result)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}
