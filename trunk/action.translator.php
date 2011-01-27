<?php

if (!isset($gCms))
    exit;

$smarty = & cmsms()->GetSmarty();
$vars['editKey'] = $params['text'];

$cache_id = MLE_CACHE_PREFIX . Translation::$defFile . $vars['editKey'];
$key = cache_cms::getKey($cache_id,'',array('files'=>  array(Translation::getFileLocation())));
// set key
if(!$key) {
    $lang_value = Translation::getValue($vars);
    cache_cms::getKey($cache_id,$lang_value,array('files'=>  array(Translation::getFileLocation())));
}
// set lang key
if ($smarty->get_template_vars('lang_locale'))
    Translation::$defFile = $smarty->get_template_vars('lang_locale');

$cache_id = MLE_CACHE_PREFIX . Translation::$defFile . $vars['editKey'];
$value = cache_cms::getKey($cache_id,'',array('files'=>  array(Translation::getFileLocation())));
// set value
if(!$value) {
    $lang_value = Translation::getValue($vars);
    $value = cache_cms::getKey($cache_id, $lang_value, array('files'=>  array(Translation::getFileLocation())));
}

if(isSet($params["assign"]))
$smarty->assign($params["assign"], $value);
else 
    echo $value;

?>