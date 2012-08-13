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


$config = cmsms()->GetConfig();

$cgextensions = cms_join_path($config['root_path'], 'modules', 'CGExtensions', 'CGExtensions.module.php');
if (!is_readable($cgextensions)) {
    echo '<h1><font color="red">ERROR: The CGExtensions module could not be found.</font></h1>';
    return;
}
require_once($cgextensions);

define('MLE_SNIPPET', 'snippet_');
define('MLE_BLOCK', 'block_');

class MleCMS extends CGExtensions {

    private $_mle_init = false;

    public function __construct() {
        parent::__construct();
    }

    public function AllowAutoUpgrade() {
        return FALSE;
    }

    function GetName() {
        return 'MleCMS';
    }

    function GetFriendlyName() {
        return $this->Lang('friendlyname');
    }

    function GetVersion() {
        return '1.11.2.1';
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
    public function DoAction($name, $id, $params, $returnid = '') {
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
                //$params["nocache"] = 1;
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
        return array('CGExtensions' => '1.29', 'ExtendedTools' => '1.3.1',);
    }

    function MinimumCMSVersion() {
        return "1.11-beta";
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
        return false;
    }

    function LazyLoadAdmin() {
        return TRUE;
    }

    public function AllowSmartyCaching() {
        return TRUE;
    }

    public function HandlesEvents() {
        return true;
    }

    public function RegisterEvents() {
        $this->AddEventHandler('Core', 'ContentPostRender');
        $this->AddEventHandler('Search', 'SearchCompleted');
        $this->AddEventHandler('Search', 'SmartyPreCompile');
    }

    function DoEvent($originator, $eventname, &$params) {
        $gCms = cmsms();
        $db = cmsms()->GetDb();
        $config = cmsms()->GetConfig();
        $smarty = $gCms->GetSmarty();

        if ($originator == 'Search' && $eventname == 'SearchCompleted' && $this->GetPreference('mle_search_restriction')) {
            $results = array();
            $search_results = $params[1];
            foreach ($search_results as $param) {
                if (isset($param->module) && isset($param->modulerecord)) {
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
        } elseif ($originator == 'Core' && $eventname == 'SmartyPreCompile' && $this->_mle_init == false) {

            // language detector
            $obj = new mle_detector($this);
            $obj->find_language();

            /* if (is_object($obj))
              CmsNlsOperations::set_language_detector($obj); */

            $this->_mle_init = true;
        } elseif ($originator == 'Core' && $eventname == 'ContentPostRender' && $this->GetPreference('mle_auto_redirect')) {

            // dont check language
            if (!$this->GetPreference('mle_auto_redirect'))
                return;

            if (cms_cookies::get($this->GetName() . 'init'))
                return;

            // defaul locale setting
            $locale = cms_cookies::get(__CLASS__);
            if (!$locale)
                $locale = CmsNlsOperations::detect_browser_language();

            // root alias detection
            $contentops = $gCms->GetContentOperations();
            $alias = mle_tools::get_root_alias();
            // alias
            if (!$alias)
                return;

            $lang = mle_tools::get_lang_from_alias($alias);

            // set ini
            if (!cms_cookies::get($this->GetName() . 'init'))
                cms_cookies::set($this->GetName() . 'init', 1);


            // do redirection
            if ($locale != $lang["locale"]) {
                cms_cookies::set($this->GetName(), $locale, time() + (3600 * 24 * 31));
                $lang = mle_tools::get_lang_from_locale($locale);
                switch ($this->GetPreference('mle_auto_redirect')) {
                    case 1:
                        // root, i redirect page
                        redirect_to_alias($lang["alias"]);
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
                        $lang = $db->GetRow($query, array($new_friendly_position, $lang["alias"]));
                        if (!$lang)
                            return;
                        redirect_to_alias($lang["alias"]);
                        break;
                }
            }
        }
    }

    public function getLangs($sortorder = 'ASC') {
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
            if (isset($params["name"])) {
                if (!isset($params["source"])) {
                    $source_array = json_decode($this->GetTemplate($params["name"]));
                    if (isset($source_array->$lang["alias"]))
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

}

?>
