<?php

/**
 * MleCMS tools
 *
 * @author @kuzmany
 */
class mle_tools {

    public static function get_root_alias() {
        $alias = cms_utils::get_app_data('root_alias');
        if ($alias)
            return $alias;

        $gCms = cmsms();
        $contentops = $gCms->GetContentOperations();
        $smarty = $gCms->GetSmarty();

        if ($alias == '') {
            $alias = $smarty->get_template_vars('page_alias');
        }
        $id = $contentops->GetPageIDFromAlias($alias);

        while ($id > 0) {
            $content = $contentops->LoadContentFromId($id);
            if (!is_object($content))
                return '';
            $alias = $content->Alias();
            $id = $content->ParentId();
        }
        cms_utils::set_app_data('root_alias', $alias);
        return $alias;
    }

    public static function getLangsLocale() {
        $mod = cms_utils::get_module('MleCMS');
        $alllangs = array(
            "Afrikaans" => "af_ZA", "Български" => "bg_BG", "Català" => "ca_ES", "Česky" => "cs_CZ", "Dansk" => "da_DK", "Deutsch" => "de_DE", "Ελληνικα" => "el_GR", "English" => "en_US",
            "Español" => "es_ES", "Eesti" => "et_EE", "Euskara" => "eu_ES", "Esperanto" => "eo_UY", "Suomi" => "fi_FI", "Français" => "fr_FR", "Magyar" => "hu_HU", "Bahasa Indonesia" => "id_ID", "Íslenska" => "is_IS", "Italiano" => "it_IT", "Hebrew" => "iw_IL",
            "日本語" => "ja_JP", "Lietuvių" => "lt_LT", "Mongolian" => "mn_MN", "Norsk bokmål" => "nb_NO", "Nederlands" => "nl_NL", "Polski" => "pl_PL", "Português Brasileiro" => "pt_BR",
            "Português" => "pt_PT", "Romansh" => "rm_CH", "Română" => "ro_RO", "Русский" => "ru_RU", "Slovenčina" => "sk_SK", "Slovenia" => "sl_SI", "српски Srpski" => "sr_YU", "Svenska" => "sv_SE", "Türkçe" => "tr_TR", "简体中文" => "zh_CN", "繁體中文" => "zh_TW",
            $mod->Lang("custom") => "custom"
        );
        return $alllangs;
    }

}

?>
