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
if (!is_readable($cgextensions)) {
    echo '<h1><font color="red">ERROR: The CGExtensions module could not be found.</font></h1>';
    return;
}
require_once($cgextensions);

define('MLE_SNIPPET', 'snippet_');
define('MLE_BLOCK', 'block_');

class MleCMS extends CGExtensions {
    function __construct() {
        parent::CMSModule();
    }

    function GetName() {
        return 'MleCMS';
    }

    function GetFriendlyName() {
        return $this->Lang('friendlyname');
    }

    function GetVersion() {
        return '1.0';
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

    function GetAdminSection() {
        return 'layout';
    }

    /* ---------------------------------------------------------
      GetAdminDescription()
      If your module does have an Admin Panel, you
      can have it return a description string that gets shown
      in the Admin Section page that contains the module.
      --------------------------------------------------------- */

    function GetAdminDescription() {
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

    function VisibleToAdminUser() {
        return true;
    }

    /* ---------------------------------------------------------
      CheckAccess()
      This wrapper function will check against the specified permission,
      and display an error page if the user doesn't have adequate permissions.
      --------------------------------------------------------- */

    function CheckAccess($perm = 'manage mle_cms') {
        return $this->CheckPermission($perm);
    }

    /* ---------------------------------------------------------
      DisplayErrorPage()
      This is a simple function for generating error pages.
      --------------------------------------------------------- */

    function DisplayErrorPage($id, &$params, $return_id, $message='') {
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

    function GetDependencies() {
        return array('CGExtensions' => '1.22');
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

    function MinimumCMSVersion() {
        return "1.9.2";
    }

    /* ---------------------------------------------------------
      InstallPostMessage()
      After installation, there may be things you want to
      communicate to your admin. This function returns a
      string which will be displayed.
      --------------------------------------------------------- */

    function InstallPostMessage() {
        return $this->Lang('postinstall');
    }

    /* ---------------------------------------------------------
      UninstallPostMessage()
      After removing a module, there may be things you want to
      communicate to your admin. This function returns a
      string which will be displayed.
      --------------------------------------------------------- */

    function UninstallPostMessage() {
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
    function UninstallPreMessage() {
        return $this->Lang('really_uninstall');
    }

    function SetParameters() {
        $this->RegisterModulePlugin();
        $this->RestrictUnknownParams();

        $this->CreateParameter('name', '', $this->Lang('help_name'));
        $this->SetParameterType('name', CLEAN_STRING);
    }

    public function getLangs($sortorder='ASC') {
        $db = & $this->GetDb();
        $query = 'SELECT * FROM ' . cms_db_prefix() . 'module_mlecms_config ORDER BY sort ' . $sortorder;
        $langs = $db->GetAll($query, array());
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

}

?>
