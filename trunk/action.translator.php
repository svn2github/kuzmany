<?php

if (!isset($gCms))
    exit;

$smarty =& cmsms()->GetSmarty();
$vars['editKey']   = $params['text'];
// set key
Translation::getValue($vars);
// set lang key
if($smarty->get_template_vars('lang_locale')) Translation::$defFile =  $smarty->get_template_vars('lang_locale');
echo Translation::getValue($vars);




?>