<?php

?>
<!-- Publicly available? -->
<?php echo elgg_echo("faq:settings:public");?>
<select name="params[publicAvailable]">
    <option value="yes" <?php if ($vars['entity']->publicAvailable == 'yes') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
    <option value="no" <?php if ($vars['entity']->publicAvailable == 'no' || empty($vars['entity']->publicAvailable)) echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
</select>
<br><br>

<!-- Site Menu entry visible when not logged in? -->
<?php echo elgg_echo("faq:settings:publicAvailable_sitemenu");?>
<select name="params[publicAvailable_sitemenu]">
    <option value="yes" <?php if ($vars['entity']->publicAvailable_sitemenu == 'yes') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
    <option value="no" <?php if ($vars['entity']->publicAvailable_sitemenu == 'no' || empty($vars['entity']->publicAvailable)) echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
</select>
<br><br>

<!-- Footer link visible when not logged in? -->
<?php echo elgg_echo("faq:settings:publicAvailable_footerlink");?>
<select name="params[publicAvailable_footerlink]">
    <option value="yes" <?php if ($vars['entity']->publicAvailable_footerlink == 'yes') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
    <option value="no" <?php if ($vars['entity']->publicAvailable_footerlink == 'no' || empty($vars['entity']->publicAvailable)) echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
</select>
<br><br>

<!-- Allow user questions? -->
<?php echo elgg_echo("faq:settings:ask");?>
<select name="params[userQuestions]">
    <option value="yes" <?php if ($vars['entity']->userQuestions == 'yes') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
    <option value="no" <?php if ($vars['entity']->userQuestions == 'no' || empty($vars['entity']->publicAvailable)) echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
</select>
<br><br>

<!-- Minimum search word length -->
<?php echo elgg_echo("faq:settings:minimum_search_tag_size") . "<br>"; ?>
<?php if(!$vars['entity']->minimumSearchTagSize) $vars['entity']->minimumSearchTagSize = "3";?>
<input type="text" name="params[minimumSearchTagSize]" value="<?php echo $vars['entity']->minimumSearchTagSize;?>"/>
<br><br>

<!-- Minimum search hit count -->
<?php echo elgg_echo("faq:settings:minimum_hit_count") . "<br>"; ?>
<?php if(!$vars['entity']->minimumHitCount) $vars['entity']->minimumHitCount = "1";?>
<input type="text" name="params[minimumHitCount]" value="<?php echo $vars['entity']->minimumHitCount;?>"/>
<br><br>
