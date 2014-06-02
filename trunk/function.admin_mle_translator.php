<?php

if (!isset($gCms))
    exit;

if (!$this->CheckAccess('manage translator_mle'))
{
    echo $this->ShowErrors($this->Lang('accessdenied')); return;
}

$admintheme = cms_utils::get_theme_object();
$config = cmsms()->getConfig();

$this->smarty->assign('keysArray', Translation::get_translations());
$this->smarty->assign('langsArray', mle_tools::get_langs());
$this->smarty->assign('ajaxLink', htmlspecialchars_decode($this->CreateLink($id, 'admin_ajax_translator_service', $returnid, '', array(), '', true)));
$this->smarty->assign('deleteIcon', $admintheme->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'));
$this->smarty->assign('cms_secure_param_name', CMS_SECURE_PARAM_NAME);
echo $this->ProcessTemplate('edittranslations.tpl');

?>