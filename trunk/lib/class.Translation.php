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

    private static function _init() {
        if (self::$_mod == null)
            self::$_mod = cms_utils::get_module('MleCMS');

        if (self::$_lang == null)
            self::$_lang = CmsNlsOperations::get_current_language();

        if (self::$_langs == null)
            self::$_langs = mle_tools::get_langs();

        if (self::$_translations == null)
            self::$_translations = unserialize(self::$_mod->GetPreference('translations'));
    }

    public static function save() {
        if(self::$_mod != null)
        self::$_mod->SetPreference('translations', serialize(self::$_translations));
    }

    public static function get_translations() {
        self::_init();
        return self::$_translations;
    }

    public static function remove($key) {
        self::_init();
        unset(self::$_translations[$key]);
        self::save();
    }

    public static function update($post) {
        self::_init();
        $editLang = $post['editLang'];
        $key = $post['editKey'];
        $value = $post['editValue'];
        self::$_translations[$key][$editLang] = $value;
        self::save();
    }
    public static function add_to_translations($key, $locale, $value) {
        self::_init();
        self::$_translations[$key][$locale] = $value;
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
            self::save();
        }


        if (isset($params["assign"]))
            $smarty->assign($params["assign"], $lang_value);
        else
            echo $lang_value;
    }

}

?>
