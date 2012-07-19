<?php

/**
 * Basic translation environment
 *
 * @author malware
 * @package Translator
 */
class Translation {

    protected static $_lang = null;
    protected static $_langs = null;
    protected static $_translations = null;
    protected static $_mod = null;

    /** static class */
    private function __construct() {
        
    }

    private function _init() {
        if (self::$_mod == null)
            self::$_mod = cms_utils::get_module('MleCMS');

        if (self::$_lang == null)
            self::$_lang = CmsNlsOperations::get_current_language();

        if (self::$_langs == null)
            self::$_langs = mle_tools::get_langs();

        if (self::$_translations == null)
            self::$_translations = unserialize(self::$_mod->GetPreference('translations'));
    }

    private static function _save() {
        self::$_mod->SetPreference('translations', serialize(self::$_translations));
    }

    public static function get_translations() {
        self::_init();
        return self::$_translations;
    }

    public static function remove($key) {
        self::_init();
        unset(self::$_translations[$key]);
        self::_save();
    }

    public static function update($post) {
        self::_init();
        $editLang = $post['editLang'];
        $key = $post['editKey'];
        $value = $post['editValue'];
        self::$_translations[$key][$editLang] = $value;
        self::_save();
    }

    public static function translate($params) {

        self::_init();

        $smarty = cmsms()->GetSmarty();

        // do nothing
        if (!isset($params['text']))
            return;

        $lang_value = self::$_translations[$params['text']][self::$_lang];
        if (!$lang_value) {
            $lang_value = self::$_translations[$params['text']][self::$_lang] = $params['text'];
            self::_save();
        }


        if (isset($params["assign"]))
            $smarty->assign($params["assign"], $lang_value);
        else
            echo $lang_value;
    }

}

?>
