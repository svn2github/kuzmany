<?php

# Module: Multilanguage CMS
# Zdeno Kuzmany (zdeno@kuzmany.biz) kuzmany.biz
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2009 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------


$cgextensions = cms_join_path($gCms->config['root_path'], 'modules', 'CGExtensions', 'CGExtensions.module.php');
if (!is_readable($cgextensions)) {
    echo '<h1><font color="red">ERROR: The CGExtensions module could not be found.</font></h1>';
    return;
}
require_once($cgextensions);

define('MLE_SNIPPET', 'snippet_');
define('MLE_BLOCK', 'block_');

class MleCMS extends CGExtensions {

    public function __construct() {
        parent::__construct();
    }

    public function AllowAutoUpgrade() {
        return TRUE;
    }

    function GetName() {
        return 'MleCMS';
    }

    function GetFriendlyName() {
        return $this->Lang('friendlyname');
    }

    function GetVersion() {
        return '1.10.6';
    }

    function GetHelp() {
        return $this->Lang('help');
    }

    function GetAuthor() {
        return 'Zdeno Kuzmany';
    }

    function GetAuthorEmail() {
        return 'zdeno@kuzmany.biz';
    }

    function GetChangeLog() {
        return $this->Lang('changelog');
    }

    function IsPluginModule() {
        return true;
    }

    function HasAdmin() {
        return ($this->CheckAccess()
        || $this->CheckAccess('manage ' . MLE_SNIPPET . 'mle')
        || $this->CheckAccess('manage ' . MLE_BLOCK . 'mle')
        || $this->CheckAccess('manage translator_mle')
        );
    }

    /**
     * DoAction - default add default params
     * @param type $name
     * @param type $id
     * @param type $params
     * @param type $returnid 
     */
    public function DoAction($name, $id, $params, $returnid='') {
        switch ($name) {
            case "translator":
                if ($this->GetPreference('translator_action_params') != "") {
                    $default_action_params = explode(" ", $this->GetPreference('translator_action_params'));
                    if (is_array($default_action_params)) {
                        foreach ($default_action_params as $default_action_param) {
                            $default_action_param_array = explode("=", $default_action_param);
                            if (count($default_action_param_array) == 2) {
                                $params[$default_action_param_array[0]] = $this->ProcessTemplateFromData(str_replace(array('"', "'"), array('', ''), $default_action_param_array[1]));
                            }
                        }
                    }
                }
                break;
            case "langs":
            case "default":
            case "init":
                $params["nocache"] = 1;
                break;
        }
        parent::DoAction($name, $id, $params, $returnid);
    }

    function GetAdminSection() {
        return 'content';
    }

    function GetAdminDescription() {
        return $this->Lang('admindescription');
    }

    function VisibleToAdminUser() {
        return true;
    }

    function CheckAccess($perm = 'manage mle_cms') {
        return $this->CheckPermission($perm);
    }

    function GetDependencies() {
        return array('CGExtensions' => '1.23');
    }

    function MinimumCMSVersion() {
        return "1.9.4";
    }

    function InstallPostMessage() {
        return $this->Lang('postinstall');
    }

    function UninstallPostMessage() {
        return $this->Lang('postuninstall');
    }

    function UninstallPreMessage() {
        return $this->Lang('really_uninstall');
    }

    function InitializeFrontend() {
        $this->RegisterModulePlugin();
        $this->RestrictUnknownParams();

        $this->SetParameterType('excludeprefix', CLEAN_STRING);
        $this->SetParameterType('includeprefix', CLEAN_STRING);
        $this->SetParameterType('template', CLEAN_STRING);
        $this->SetParameterType('name', CLEAN_STRING);

        mle_smarty::init();
    }

    function SetParameters() {

        if (version_compare(CMS_VERSION, '1.10') < 0) {
            $this->InitializeFrontend();
            $this->InitializeAdmin();
        }
    }

    function InitializeAdmin() {
        $this->CreateParameter('includeprefix', '', $this->Lang('help_includeprefix'));
        $this->CreateParameter('excludeprefix', '', $this->Lang('help_excludeprefix'));
        $this->CreateParameter('name', '', $this->Lang('help_name'));
        $this->CreateParameter('template', '', $this->Lang('help_template'));
    }

    function LazyLoadFrontend() {
        return TRUE;
    }

    function DoEvent($originator, $eventname, &$params) {
        $gCms = cmsms();
        $db = cmsms()->GetDb();
        $config = cmsms()->GetConfig();
        if ($originator == 'Search' && $eventname == 'SearchCompleted' && $this->GetPreference('mle_search_restriction')) {
            $results = array();
            $search_results = $params[1];
            foreach ($search_results as $param) {
                if (isSet($param->module) && isSet($param->modulerecord)) {
                    $results[] = $param;
                } else {
                    // only for url_rewriting
                    // url check
                    if ($config['url_rewriting'] == 'mod_rewrite') {
                        $base_url = $config["root_url"] . '/' . mle_tools::get_root_alias();
                    } else if ($config['url_rewriting'] == 'internal') {
                        $base_url = $config["root_url"] . '/index.php/' . mle_tools::get_root_alias();
                    }
                    if (startswith($param->url, $base_url)) {
                        $results[] = $param;
                    }
                }
            }
            $params[1] = $results;
        } elseif ($originator == 'Core' && $eventname == 'ContentPostRender' && $this->GetPreference('mle_auto_redirect')) {

            $contentops = $gCms->GetContentOperations();
            $smarty = $gCms->GetSmarty();
            // set cookie
            $pu_root_url = parse_url($config['root_url']);
            $pu_root_url['path'] = (empty($pu_root_url['path'])) ? '/' : $pu_root_url['path'];
            $cookie_path = rtrim($pu_root_url['path'], '/') . '/';
            $cookie_domain = (strpos($pu_root_url['host'], '.') !== false) ? $pu_root_url['host'] : null;
            $cookie_secure = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? true : false;


            switch ($this->GetPreference('mle_auto_redirect')) {
                case 1:
                    $friendly_position = $smarty->get_template_vars('friendly_position');
                    $friendly_position_array = explode(".", $friendly_position);
                    // if no root, no redirect
                    if (count($friendly_position_array) != 1) {
                        setcookie('mle_init', 1, time() + 1800, $cookie_path, $cookie_domain, $cookie_secure);
                        return;
                    }
            }

            $alias = mle_tools::get_root_alias();
            // alias
            if (!$alias)
                return;
            // compare to your DB
            //  return
            if (isset($_COOKIE['mle_init'])) {
                setcookie('mle', $alias, time() + (3600 * 24 * 31 * 12), $cookie_path, $cookie_domain, $cookie_secure);
                setcookie('mle_init', 1, time() + 1800, $cookie_path, $cookie_domain, $cookie_secure);
                return;
            }

            if (isset($_COOKIE['mle'])) {
                $root_alias = $_COOKIE['mle'];
            } else {
                $root_alias = $db->GetOne('SELECT alias FROM ' . cms_db_prefix() . 'module_mlecms_config WHERE alias = ?', array($alias));
            }
            if ($root_alias) {
                $all_langs = $this->getLangs();
                $user_lang = $this->language_user_setting($all_langs);
                if ($root_alias != $user_lang) {
                    setcookie('mle_init', 1, time() + 1800, $cookie_path, $cookie_domain, $cookie_secure);
                    switch ($this->GetPreference('mle_auto_redirect')) {
                        case 1:
                            // root, i redirect page
                            redirect_to_alias($user_lang);
                            break;
                        case 2:
                            // no root
                            $friendly_position = $smarty->get_template_vars('friendly_position');
                            $friendly_position_array = explode(".", $friendly_position);
                            unset($friendly_position_array[0]);
                            $hierarchy_array = array();
                            foreach ($friendly_position_array as $one) {
                                $hierarchy_array[] = str_pad($one, 5, '0', STR_PAD_LEFT);
                            }
                            $new_friendly_position = (count($hierarchy_array) ? '.' : '') . implode(".", $hierarchy_array);
                            $query = 'SELECT mle.*,content_hierchy.content_alias as alias FROM ' . cms_db_prefix() . 'module_mlecms_config mle
INNER JOIN ' . cms_db_prefix() . 'content  content ON content.content_alias = mle.alias
LEFT JOIN ' . cms_db_prefix() . 'content  content_hierchy ON (content_hierchy.hierarchy = CONCAT(content.hierarchy,?))
    WHERE content.content_alias = ?
';
                            $lang = $db->GetRow($query, array($new_friendly_position, $user_lang));
                            if (!$lang)
                                return;
                            redirect_to_alias($lang["alias"]);
                            break;
                    }
                } else {
                    setcookie('mle_init', 1, time() + 1800, $cookie_path, $cookie_domain, $cookie_secure);
                }
            }
        }
    }

    public function getLangs($sortorder='ASC') {
        $langs = cms_utils::get_app_data('langs');
        if ($langs)
            return $langs;
        $db = cmsms()->GetDb();
        $query = 'SELECT * FROM ' . cms_db_prefix() . 'module_mlecms_config ORDER BY sort ' . $sortorder;
        $langs = $db->GetAll($query, array());
        cms_utils::set_app_data('langs', $langs);
        return $langs;
    }

    public function getLangsForm($langs, $id, $params, $wysiwyg) {
        if (!is_array($langs) && count($langs) < 1)
            return;
        $entryarray = array();
        $source = '';
        foreach ($langs as $lang) {
            if (isSet($params["name"])) {
                if (!isSet($params["source"])) {
                    $source_array = json_decode($this->GetTemplate($params["name"]));
                    $source = $source_array->$lang["alias"];
                } else {
                    $source = $params["source"][$lang["alias"]];
                }
            }
            $lang["textarea"] = $this->CreateTextArea($wysiwyg, $id, $source, 'source[' . $lang["alias"] . ']');
            $entryarray[] = $lang;
        }
        return $entryarray;
    }

    /**
     * Browser settings identification - from MLE CMSMS edition
     * @param array $row
     * @return array
     */
    public function language_user_setting(array $rows) {
        $browser_langs = array();

        //Check if we have $_SERVER['HTTP_ACCEPT_LANGUAGE'] set and
        //it no longer breaks if you only have one language set :)
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $str = strtolower(trim($_SERVER["HTTP_ACCEPT_LANGUAGE"]));
            $str = str_replace(' ', '', $str);
            $browser_accept = explode(',', $str);

            //Go through all language preference specs
            for ($i = 0; $i < count($browser_accept); $i++) {
                //The language part is either a code or a code with a quality
                //We cannot do anything with a * code, so it is skipped
                //If the quality is missing, it is assumed to be 1 according to the RFC
                if (preg_match("!([a-z-]+)(;q=([0-9\\.]+))?!", $browser_accept[$i], $found)) {
                    $quality = (isset($found[3]) ? (float) $found[3] : 1.0);
                    $browser_langs[] = array($found[1], $quality, $i + 1);
                }
                unset($found);
            }
        } elseif (isset($_SERVER['HTTP_USER_AGENT'])) {
            $str = strtolower(trim($_SERVER["HTTP_USER_AGENT"]));
            $user_agent = explode(';', $str);

            for ($i = 0; $i < sizeof($user_agent); $i++) {
                $languages = explode('-', $user_agent[$i]);
                if (sizeof($languages) == 2 || strlen(trim($languages[0])) == 2) {
                    $browser_langs[] = array(trim($languages[0]), 1.0, $i + 1);
                }
            }
        }
        //Sort by quality and order
        usort($browser_langs, "language_accept_order");
        foreach ($browser_langs as $arr_language) {
            $language = $arr_language[0];
            if (strlen($language) > 2)
                $language = substr($language, 0, 2);
            foreach ($rows as $row) {
                $row_index = cge_array::find_index($row, $language);
                if ($row_index)
                    return $row["alias"];
            }
        }
        return false;
    }

}

//Order the array of compiled accept-language codes by quality value
function language_accept_order($a, $b) {
    if ($a[1] == $b[1])
        return ($a[2] > $b[2]) ? 1 : -1;
    return ($a[1] > $b[1]) ? -1 : 1;
}

function isAjax() {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest")
        return true;

    return false;
}

?>
