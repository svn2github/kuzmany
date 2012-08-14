<?php

/**
 * MleCMS detector
 *
 * @author @kuzmany
 */
class mle_detector extends CmsLanguageDetector {

    private $_mod = null;

    public function __construct($mod) {
        $this->_mod = $mod;
    }

    public function find_language() {
        
        if($this->_mod == null)
            return;

        $gCms = cmsms();
        $smarty = $gCms->GetSmarty();
        $db = cmsms()->GetDb();
        $contentops = $gCms->GetContentOperations();
        //$alias = $mod->ProcessTemplateFromData($mod->GetPreference('mle_id'));
        $alias = mle_tools::get_root_alias();
        if ($alias == '')
            $alias = cms_utils::get_current_alias();

        if (!$alias)
            return;

        $query = 'SELECT * FROM ' . cms_db_prefix() . 'module_mlecms_config  WHERE alias = ?';
        $lang = $db->GetRow($query, array($alias));
        if (!$lang)
            return;

        if (cms_cookies::get($this->_mod->GetName()) != $lang["locale"]) {
            cms_cookies::set($this->_mod->GetName(), $lang["locale"], time() + (3600 * 24 * 31));
        }

        $smarty->assign('lang_parent', $lang["alias"]);
        $smarty->assign('lang_locale', $lang["locale"]);
        $smarty->assign('lang_extra', $lang["extra"]);
        
        $lang_dir = CmsNlsOperations::get_language_info($lang["locale"])->direction();
        $smarty->assign('lang_dir', $lang_dir);

        return $lang["locale"];
    }

}

?>
