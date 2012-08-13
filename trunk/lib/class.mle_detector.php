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

        if (!is_object($this->_mod))
            return;

        $mod = $this->_mod;

        //$alias = $mod->ProcessTemplateFromData($mod->GetPreference('mle_id'));
        $alias = mle_tools::get_root_alias();
        
        $gCms = cmsms();
        $contentops = $gCms->GetContentOperations();


        $smarty = $gCms->GetSmarty();

        if ($alias == '')
            $alias = cmsms()->get_variable('page_alias');

        if (!$alias)
            return;


        $db = cmsms()->GetDb();
        $smarty = cmsms()->GetSmarty();

        $query = 'SELECT * FROM ' . cms_db_prefix() . 'module_mlecms_config  WHERE alias = ?';
        $lang = $db->GetRow($query, array($alias));
        if (!$lang)
            return;
        
        $smarty->assign('lang_parent', $lang["alias"]);
        $smarty->assign('lang_locale', $lang["locale"]);
        $smarty->assign('lang_extra', $lang["extra"]);
        $smarty->assign('lang_direction', $lang["direction"]);

        if (cms_cookies::get($mod->GetName()) != $lang["locale"]) {
            cms_cookies::set($mod->GetName(), $lang["locale"], time() + (3600 * 24 * 31));
        }
        
        return $lang["locale"];

    }

}

?>
