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


$cgextensions = cms_join_path($gCms->config['root_path'], 'modules',
                'CGExtensions', 'CGExtensions.module.php');
if (!is_readable($cgextensions))
{
    echo '<h1><font color="red">ERROR: The CGExtensions module could not be found.</font></h1>';
    return;
}
require_once($cgextensions);

define('MLE_SNIPPET', 'snippet_');
define('MLE_BLOCK', 'block_');
define('MLE_CACHE_PREFIX', 'mlecms_');

class MleCMS extends CGExtensions
{
    public $alllangs = array(
        "Afrikaans" => "af_ZA", "Български" => "bg_BG", "Català" => "ca_ES", "Česky" => "cs_CZ", "Dansk" => "da_DK", "Deutsch" => "de_DE", "Ελληνικα" => "el_GR", "English" => "en_US",
        "Español" => "es_ES", "Eesti" => "et_EE", "Euskara" => "eu_ES", "Esperanto" => "eo_UY", "Suomi" => "fi_FI", "Français" => "fr_FR", "Magyar" => "hu_HU", "Bahasa Indonesia" => "id_ID", "Íslenska" => "is_IS", "Italiano" => "it_IT", "Hebrew" => "iw_IL",
        "日本語" => "ja_JP", "Lietuvių" => "lt_LT", "Mongolian" => "mn_MN", "Norsk bokmål" => "nb_NO", "Nederlands" => "nl_NL", "Polski" => "pl_PL", "Português Brasileiro" => "pt_BR",
        "Português" => "pt_PT", "Romansh" => "rm_CH", "Română" => "ro_RO", "Русский" => "ru_RU", "Slovenčina" => "sk_SK", "Slovenia" => "sl_SI", "српски Srpski" => "sr_YU", "Svenska" => "sv_SE", "Türkçe" => "tr_TR", "简体中文" => "zh_CN", "繁體中文" => "zh_TW");

    function __construct()
    {
        parent::CMSModule();

        $smarty = & cmsms()->GetSmarty();
        $smarty->register_function('translate', array(&$this, 'smarty_translator'));
    }

    function smarty_translator($params, &$smarty)
    {
        return $this->DoAction('translator', '', $params);
    }

    function GetName()
    {
        return 'MleCMS';
    }

    function GetFriendlyName()
    {
        return $this->Lang('friendlyname');
    }

    function GetVersion()
    {
        return '1.4';
    }

    function GetHelp()
    {
        return $this->Lang('help');
    }

    function GetAuthor()
    {
        return 'Zdeno Kuzmany';
    }

    function GetAuthorEmail()
    {
        return 'zdeno@kuzmany.biz';
    }

    function GetChangeLog()
    {
        return $this->Lang('changelog');
    }

    function IsPluginModule()
    {
        return true;
    }

    function HasAdmin()
    {
        return ($this->CheckAccess()
        || $this->CheckAccess('manage ' . MLE_SNIPPET . 'mle')
        || $this->CheckAccess('manage ' . MLE_BLOCK . 'mle')
        );
    }

    /* ---------------------------------------------------------
      GetAdminSection()
      If your module has an Admin Panel, you can specify
      which Admin Section (or top-level Admin Menu) it shows
      up in. This method returns a string to specify that
      section. Valid return values are:

      main        - the Main menu tab.
      content     - the Content menu
      layout      - the Layout menu
      usersgroups - the Users and Groups menu
      extensions  - the Extensions menu (this is the default)
      siteadmin   - the Site Admin menu
      viewsite    - the View Site menu tab
      logout      - the Logout menu tab

      Note that if you place your module in the main,
      viewsite, or logout sections, it will show up in the
      menus, but will not be visible in any top-level
      section pages.
      --------------------------------------------------------- */

    function GetAdminSection()
    {
        return 'content';
    }

    /* ---------------------------------------------------------
      GetAdminDescription()
      If your module does have an Admin Panel, you
      can have it return a description string that gets shown
      in the Admin Section page that contains the module.
      --------------------------------------------------------- */

    function GetAdminDescription()
    {
        return $this->Lang('admindescription');
    }

    /* ---------------------------------------------------------
      VisibleToAdminUser()
      If your module does have an Admin Panel, you
      can control whether or not it's displayed by the boolean
      that is returned by this method. This is primarily used
      to hide modules from admins who lack permission to use
      them.

      Typically, you'll use some permission to set this
      (e.g., $this->CheckPermission('Some Permission'); )
      --------------------------------------------------------- */

    function VisibleToAdminUser()
    {
        return true;
    }

    /* ---------------------------------------------------------
      CheckAccess()
      This wrapper function will check against the specified permission,
      and display an error page if the user doesn't have adequate permissions.
      --------------------------------------------------------- */

    function CheckAccess($perm = 'manage mle_cms')
    {
        return $this->CheckPermission($perm);
    }

    /* ---------------------------------------------------------
      DisplayErrorPage()
      This is a simple function for generating error pages.
      --------------------------------------------------------- */

    function DisplayErrorPage($id, &$params, $return_id, $message='')
    {
        $this->smarty->assign('title_error', $this->Lang('error'));
        $this->smarty->assign_by_ref('message', $message);

        // Display the populated template
        echo $this->ProcessTemplate('error.tpl');
    }

    /* ---------------------------------------------------------
      GetDependencies()
      Your module may need another module to already be installed
      before you can install it.
      This method returns a list of those dependencies and
      minimum version numbers that this module requires.

      It should return an hash, eg.
      return array('somemodule'=>'1.0', 'othermodule'=>'1.1');
      --------------------------------------------------------- */

    function GetDependencies()
    {
        return array('CGExtensions' => '1.22', 'GBFilePicker' => '1.2', 'ContentCache' => '1.0');
    }

    /* ---------------------------------------------------------
      MinimumCMSVersion()
      Your module may require functions or objects from
      a specific version of CMS Made Simple.
      Ever since version 0.11, you can specify which minimum
      CMS MS version is required for your module, which will
      prevent it from being installed by a version of CMS that
      can't run it.

      This method returns a string representing the
      minimum version that this module requires.
      --------------------------------------------------------- */

    function MinimumCMSVersion()
    {
        return "1.9.2";
    }

    /* ---------------------------------------------------------
      InstallPostMessage()
      After installation, there may be things you want to
      communicate to your admin. This function returns a
      string which will be displayed.
      --------------------------------------------------------- */

    function InstallPostMessage()
    {
        return $this->Lang('postinstall');
    }

    /* ---------------------------------------------------------
      UninstallPostMessage()
      After removing a module, there may be things you want to
      communicate to your admin. This function returns a
      string which will be displayed.
      --------------------------------------------------------- */

    function UninstallPostMessage()
    {
        return $this->Lang('postuninstall');
    }

    /**
     * UninstallPreMessage()
     * This allows you to display a message along with a Yes/No dialog box. If the user responds
     * in the affirmative to your message, the uninstall will proceed. If they respond in the
     * negative, the uninstall will be canceled. Thus, your message should be of the form
     * "All module data will be deleted. Are you sure you want to uninstall this module?"
     *
     * If you don't want the dialog, have this method return a FALSE, which will cause the
     * module to uninstall immediately if the user clicks the "uninstall" link.
     */
    function UninstallPreMessage()
    {
        return $this->Lang('really_uninstall');
    }

    function SetParameters()
    {
        $this->RegisterModulePlugin();
        $this->RestrictUnknownParams();

        $this->CreateParameter('name', '', $this->Lang('help_name'));
        $this->SetParameterType('name', CLEAN_STRING);
    }

    function DoEvent($originator, $eventname, &$params)
    {
        $gCms = cmsms();
        $db = cmsms()->GetDb();
        $config = cmsms()->GetConfig();

        if ($originator == 'Core' && $eventname == 'ContentPostRender' && $this->GetPreference('mle_auto_redirect'))
        {

            $contentops = $gCms->GetContentOperations();
            $smarty = $gCms->GetSmarty();
            // set cookie
            $pu_root_url = parse_url($config['root_url']);
            $pu_root_url['path'] = (empty($pu_root_url['path'])) ? '/' : $pu_root_url['path'];
            $cookie_path = rtrim($pu_root_url['path'], '/') . '/';
            $cookie_domain = (strpos($pu_root_url['host'], '.') !== false) ? $pu_root_url['host'] : null;
            $cookie_secure = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? true : false;

            switch ($this->GetPreference('mle_auto_redirect'))
            {
                case 1:
                    $friendly_position = $smarty->get_template_vars('friendly_position');
                    $friendly_position_array = explode(".", $friendly_position);
                    // if no root, no redirect
                    if (count($friendly_position_array) != 1)
                    {
                        setcookie('mle_init', 1, time() + 1800, $cookie_path, $cookie_domain, $cookie_secure);
                        return;
                    }
            }

            $alias = $this->get_root_alias();
            // alias
            if (!$alias)
                return;
            // compare to your DB
            //  return
            if (isset($_COOKIE['mle_init']))
            {
                setcookie('mle', $alias, time() + (3600 * 24 * 31 * 12), $cookie_path, $cookie_domain, $cookie_secure);
                setcookie('mle_init', 1, time() + 1800, $cookie_path, $cookie_domain, $cookie_secure);
                return;
            }

            if (isset($_COOKIE['mle']))
            {
                $root_alias = $_COOKIE['mle'];
            }
            else
            {
                $root_alias = $db->GetOne('SELECT alias FROM ' . cms_db_prefix() . 'module_mlecms_config WHERE alias = ?', array($alias));
            }
            if ($root_alias)
            {
                $all_langs = $this->getLangs();
                $user_lang = $this->language_user_setting($all_langs);
                if ($root_alias != $user_lang)
                {
                    setcookie('mle_init', 1, time() + 1800, $cookie_path, $cookie_domain, $cookie_secure);
                    switch ($this->GetPreference('mle_auto_redirect'))
                    {
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
                            foreach ($friendly_position_array as $one)
                            {
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
                } else
                {
                    setcookie('mle_init', 1, time() + 1800, $cookie_path, $cookie_domain, $cookie_secure);
                }
            }
        }
    }

    public function getLangsLocale()
    {
        return $this->alllangs;
    }

    public function getLangs($sortorder='ASC')
    {
        $langs = cms_utils::get_app_data('langs');
        if ($langs)
            return $langs;
        $db = cmsms()->GetDb();
        $query = 'SELECT * FROM ' . cms_db_prefix() . 'module_mlecms_config ORDER BY sort ' . $sortorder;
        $langs = $db->GetAll($query, array());
        cms_utils::set_app_data('langs', $langs);
        return $langs;
    }

    public function getLangsForm($langs, $id, $params, $wysiwyg)
    {
        if (!is_array($langs) && count($langs) < 1)
            return;
        $entryarray = array();
        $source = '';
        foreach ($langs as $lang)
        {
            if (isSet($params["name"]))
            {
                if (!isSet($params["source"]))
                {
                    $source_array = json_decode($this->GetTemplate($params["name"]));
                    $source = $source_array->$lang["alias"];
                }
                else
                {
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
    public function language_user_setting(array $rows)
    {
        $browser_langs = array();

        //Check if we have $_SERVER['HTTP_ACCEPT_LANGUAGE'] set and
        //it no longer breaks if you only have one language set :)
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
        {
            $str = strtolower(trim($_SERVER["HTTP_ACCEPT_LANGUAGE"]));
            $str = str_replace(' ', '', $str);
            $browser_accept = explode(',', $str);

            //Go through all language preference specs
            for ($i = 0; $i < count($browser_accept); $i++)
            {
                //The language part is either a code or a code with a quality
                //We cannot do anything with a * code, so it is skipped
                //If the quality is missing, it is assumed to be 1 according to the RFC
                if (preg_match("!([a-z-]+)(;q=([0-9\\.]+))?!", $browser_accept[$i], $found))
                {
                    $quality = (isset($found[3]) ? (float) $found[3] : 1.0);
                    $browser_langs[] = array($found[1], $quality, $i + 1);
                }
                unset($found);
            }
        }
        elseif (isset($_SERVER['HTTP_USER_AGENT']))
        {
            $str = strtolower(trim($_SERVER["HTTP_USER_AGENT"]));
            $user_agent = explode(';', $str);

            for ($i = 0; $i < sizeof($user_agent); $i++)
            {
                $languages = explode('-', $user_agent[$i]);
                if (sizeof($languages) == 2 || strlen(trim($languages[0])) == 2)
                {
                    $browser_langs[] = array(trim($languages[0]), 1.0, $i + 1);
                }
            }
        }
        //Sort by quality and order
        usort($browser_langs, "language_accept_order");
        foreach ($browser_langs as $arr_language)
        {
            $language = $arr_language[0];
            if (strlen($language) > 2)
                $language = substr($language, 0, 2);
            foreach ($rows as $row)
            {
                $row_index = cge_array::find_index($row, $language);
                if ($row_index)
                    return $row["alias"];
            }
        }
        return false;
    }

    /**
     * Root alias with cms cache
     * @return <type>
     */
    public function get_root_alias()
    {
        $alias = cms_utils::get_app_data('root_alias');
        if ($alias)
            return $alias;

        $gCms = cmsms();
        $contentops = $gCms->GetContentOperations();
        $smarty = $gCms->GetSmarty();
        if ($alias == '')
        {
            $alias = $smarty->get_template_vars('page_alias');
        }
        $id = $contentops->GetPageIDFromAlias($alias);

        while ($id > 0)
        {
            $content = $contentops->LoadContentFromId($id);
            if (!is_object($content))
                return '';
            $alias = $content->Alias();
            $id = $content->ParentId();
        }
        cms_utils::set_app_data('root_alias', $alias);
        return $alias;
        ;
    }

}

//Order the array of compiled accept-language codes by quality value
function language_accept_order($a, $b)
{
    if ($a[1] == $b[1])
        return ($a[2] > $b[2]) ? 1 : -1;
    return ($a[1] > $b[1]) ? -1 : 1;
}

function isAjax()
{
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest")
        return true;

    return false;
}

?>
