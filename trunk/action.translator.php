<?php

if (!isset($gCms))
    exit;
$smarty = cmsms()->GetSmarty();
$vars['editKey'] = $params['text'];

Translation::$defFile = 'keys';
$lang_value = Translation::getValue($vars);

// set lang key
if ($smarty->get_template_vars('lang_locale'))
    Translation::$defFile = $smarty->get_template_vars('lang_locale');

$lang_value = Translation::getValue($vars);

if(isSet($params["assign"]))
$smarty->assign($params["assign"], $lang_value);
else 
    echo $lang_value;

return;

// discontinued cache
Translation::$defFile = 'keys';
$cache_id =  Translation::$defFile . $vars['editKey'];
$key = cache_cms::getKey($cache_id,'',array('files'=>  array(Translation::getFileLocation())),$this->GetName());
// set key
if(!$key) {
    $lang_value = Translation::getValue($vars);
    cache_cms::getKey($cache_id,$lang_value,array('files'=>  array(Translation::getFileLocation())),$this->GetName());
}
// set lang key
if ($smarty->get_template_vars('lang_locale'))
    Translation::$defFile = $smarty->get_template_vars('lang_locale');

$cache_id =  Translation::$defFile . $vars['editKey'];
$value = cache_cms::getKey($cache_id,'',array('files'=>  array(Translation::getFileLocation())),$this->GetName());
// set value
if(!$value) {
    $lang_value = Translation::getValue($vars);
    $value = cache_cms::getKey($cache_id, $lang_value, array('files'=>  array(Translation::getFileLocation())),$this->GetName());
}
if(isSet($params["assign"]))
$smarty->assign($params["assign"], $value);
else 
    echo $value;

?>