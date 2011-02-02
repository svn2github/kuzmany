<?php

if (!isset($gCms))
    exit;

if (!$this->CheckAccess('manage translator_mle'))
{
    return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$config = cmsms()->getConfig();

Translation::setLanguages($this->getLangs());

$this->smarty->assign('keysArray', Translation::getKeysTable());
$this->smarty->assign('langsArray', Translation::getContentTable());
$this->smarty->assign('ajaxLink', $this->CreateLink($id, 'admin_ajax_translator_service', $returnid, '', array(), '', true));
$this->smarty->assign('deleteIcon', $gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'));

echo $this->ProcessTemplate('edittranslations.tpl');

?>