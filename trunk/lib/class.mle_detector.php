<?php

/**
 * MleCMS detector
 *
 * @author @kuzmany
 */
class mle_detector /*extends CmsLanguageDetector*/ {

    public function find_language(&$smarty) {

        $db = cmsms()->GetDb();
        $contentops = cmsms()->GetContentOperations();
        $alias = mle_tools::get_root_alias();
        if ($alias == '')
            $alias = cms_utils::get_current_alias();
        if (!$alias)
            return;
        $lang = mle_tools::get_lang_from_alias($alias);
        if (!$lang)
            return '';
        else {
            mle_tools::set_smarty_options($smarty, $lang['locale'], $lang['alias']);
            //canonical
            if ($lang["canonical"])
                if ($_SERVER['HTTP_HOST'] != $lang["canonical"]) {
                    $current_url = cge_url::current_url();
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: " . str_replace($_SERVER['HTTP_HOST'], $lang["canonical"], cge_url::current_url()));
                }
            return $lang["locale"];
        }
    }

}

?>
