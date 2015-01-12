<?php

/**
 * MleCMS tools
 *
 * @author @kuzmany
 */
class mle_tools {

    public static function is_ajax() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest")
            return true;

        return false;
    }

    public static function get_root_alias() {

        $hm = cmsms()->GetHierarchyManager();
        $smarty = cmsms()->GetSmarty();

        $alias = cms_utils::get_app_data('root_alias');
        if ($alias)
            return $alias;

        //get curretn alias
        $alias = get_pageid_or_alias_from_url();
        if (is_numeric($alias)) {
            $contentops = cmsms()->GetContentOperations();
            $alias = $contentops->GetPageAliasFromID($alias);
        }

        $stack = array();
        $node = $hm->find_by_tag('alias', $alias);
        while ($node && $node->get_tag('id') > 0) {
            $stack[] = $node;
            $node = $node->getParent();
        }
        if (count($stack) == 0)
            return;

        $alias = $stack[count($stack) - 1]->get_tag('alias');
        cms_utils::set_app_data('root_alias', $alias);
        return $alias;
    }

    public static function getLangsLocale() {

        $mod = cms_utils::get_module('MleCMS');
        $tmp = array();
        $langs = CmsNlsOperations::get_installed_languages();
        asort($langs);
        foreach ($langs as $key) {
            $obj = CmsNlsOperations::get_language_info($key);
            $value = $obj->display();
            if ($obj->fullname()) {
                $value .= ' (' . $obj->fullname() . ')';
            }
            $tmp[$value] = $key;
        }
        return $tmp;
    }

    public static function get_lang($lang_id) {
        $lang = cms_utils::get_app_data(__CLASS__ . __FUNCTION__ . $lang_id);
        if ($lang)
            return $lang;
        $db = cmsms()->GetDb();
        $query = 'SELECT * FROM ' . cms_db_prefix() . 'module_mlecms_config WHERE id = ?';
        $lang = $db->GetRow($query, array($lang_id));
        cms_utils::set_app_data(__CLASS__ . __FUNCTION__ . $lang_id, $lang);
        return $lang;
    }

    public static function get_lang_from_locale($locale) {
        $lang = cms_utils::get_app_data(__CLASS__ . __FUNCTION__ . $locale);
        if ($lang)
            return $lang;
        $db = cmsms()->GetDb();
        $query = 'SELECT * FROM ' . cms_db_prefix() . 'module_mlecms_config WHERE locale = ?';
        $lang = $db->GetRow($query, array($locale));
        cms_utils::set_app_data(__CLASS__ . __FUNCTION__ . $locale, $lang);
        return $lang;
    }

    public static function get_lang_from_alias($alias) {
        $lang = cms_utils::get_app_data(__CLASS__ . __FUNCTION__ . $alias);
        if ($lang)
            return $lang;
        $db = cmsms()->GetDb();
        $query = 'SELECT * FROM ' . cms_db_prefix() . 'module_mlecms_config WHERE alias = ?';
        $lang = $db->GetRow($query, array($alias));
        cms_utils::set_app_data(__CLASS__ . __FUNCTION__ . $alias, $lang);
        return $lang;
    }

    public static function get_langs() {
        $langs = cms_utils::get_app_data(__CLASS__ . __FUNCTION__);
        if ($langs)
            return $langs;
        $db = cmsms()->GetDb();
        $query = 'SELECT * FROM ' . cms_db_prefix() . 'module_mlecms_config';
        $langs = $db->GetAll($query, array());
        cms_utils::set_app_data(__CLASS__ . __FUNCTION__, $langs);
        return $langs;
    }

    public static function set_smarty_options($locale, $alias = null) {
        $obj = CmsNlsOperations::get_language_info($locale);
        if (!is_object($obj))
            return;
        $smarty = cmsms()->GetSmarty();
        $value = $obj->display();
        if ($alias != null)
            $lang = self::get_lang_from_alias($alias);
        else
            $lang = self::get_lang_from_locale($locale);
        if ($lang) {
            $smarty->assign('lang_extra', $lang["extra"]);
            $smarty->assign('lang_parent', $lang["alias"]);
        }
        $smarty->assign('lang_locale', $locale);
        $smarty->assign('lang_dir', $obj->direction());
    }

}

?>
