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
        if ($this->_mod == null)
            return;

        $gCms = cmsms();
        $smarty = $gCms->GetSmarty();
        $db = cmsms()->GetDb();
        $contentops = $gCms->GetContentOperations();
        $alias = mle_tools::get_root_alias();
        if ($alias == '')
            $alias = cms_utils::get_current_alias();
        if (!$alias)
            return;
        $lang = mle_tools::get_lang_from_alias($alias);
        if (!$lang)
            return '';
        else {
            mle_tools::set_smarty_options($lang["locale"],$lang["alias"]);
            return $lang["locale"];
        }
    }

}

?>
