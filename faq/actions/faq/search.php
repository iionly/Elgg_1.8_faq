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

$minimum_tag_length = elgg_get_plugin_setting("minimumSearchTagSize","faq");
if(!$minimum_tag_length) {
    $minimum_tag_length = 3;
}
$minimum_hit_count = elgg_get_plugin_setting("minimumHitCount","faq");
if(!$minimum_hit_count) {
    $minimum_hit_count = 1;
}

$tags = strtolower(get_input("search"));

$rankedArray = array();

if($tags) {

    $tagArray = explode(" ",$tags);

    $count = elgg_get_entities(array('type' => "object", 'subtype' => "faq", 'limit' => 0, 'offset' => 0, 'count' => true));
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
        foreach($rankedArray as $faq_id=>$count) {
            echo elgg_view("object/faq",array("entity"=>$faqs[$faq_id], "hitcount"=>$count));
        }
        echo "<br>";
    } else {
        echo "<b>" . elgg_echo("faq:search:noresult") . "</b><br><br>";
    }

}

exit();
?>
