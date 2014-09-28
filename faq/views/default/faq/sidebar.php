<?php

elgg_register_menu_item('page', array(
	'name' => elgg_echo("faq:search:title"),
	'text' => elgg_echo("faq:search:title"),
	'href' => elgg_get_site_url() . "faq/",
	'section' => 'a',
	'context' => 'faq'
));

if(elgg_is_logged_in() && elgg_get_plugin_setting("userQuestions", "faq") == "yes") {
	elgg_register_menu_item('page', array(
		'name' => elgg_echo("faq:ask"),
		'text' => elgg_echo("faq:ask"),
		'href' => elgg_get_site_url() . "faq/ask",
		'section' => 'b',
		'context' => 'faq'
	));
}

if(elgg_is_admin_logged_in()) {
	elgg_register_menu_item('page', array(
		'name' => elgg_echo("faq:add"),
		'text' => elgg_echo("faq:add"),
		'href' => elgg_get_site_url() . "faq/add",
		'section' => 'c',
		'context' => 'faq'
	));
	elgg_register_menu_item('page', array(
		'name' => elgg_echo("faq:asked", array(getUserQuestionsCount())),
		'text' => elgg_echo("faq:asked", array(getUserQuestionsCount())),
		'href' => elgg_get_site_url() . "faq/asked",
		'section' => 'c',
		'context' => 'faq'
	));
}

?>

<div class="elgg-module elgg-module-aside">
	<div class="elgg-head">
		<h3><?php echo elgg_echo('faq:sidebar:categories'); ?></h3>
	</div>
	<div>
		<?php
			$cats = getCategories();
			$category_links = '';
			foreach($cats as $id => $cat){
				$url = "faq/list?categoryId=" . $id;
				$item = new ElggMenuItem($cat, $cat, $url);
				$item->setContext('faq');
				$item->setSection('d');
				$category_links .= elgg_view('navigation/menu/elements/item', array('item' => $item, 'item_class' => 'faqCategorySidebar'));
			}
			echo $category_links;
		?>
	</div>
</div>
