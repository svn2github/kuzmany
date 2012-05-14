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
if (!isset($gCms))
    exit;

$current_version = $oldversion;
$db = cmsms()->GetDb();

$taboptarray = array('mysql' => 'TYPE=MyISAM');
$dict = NewDataDictionary($db);

switch ($current_version) {
    case "1.0":
        $dict = NewDataDictionary($db);
        $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . "module_mlecms_config", "flag C(60)");
        $dict->ExecuteSQLArray($sqlarray);
        $current_version = "1.1";
    case "1.1":
        $this->AddEventHandler('Core', 'ContentPostRender', false);
        $this->AddEventHandler('Search', 'SearchCompleted', false);
        $this->SetPreference('mle_auto_redirect', 0);
        $this->SetPreference('mle_id', '{MleCMS action="get_root_alias"}');
        $current_version = "1.2";
    case "1.2":
    case "1.3":
        $this->CreateEvent('LangEdited');
        $this->CreateEvent('BlockEdited');
        $current_version = "1.4";
    case "1.4":
        $this->AddEventHandler('Core', 'ContentPostRender', false);
        $this->AddEventHandler('Search', 'SearchCompleted', false);
        $this->SetPreference('mle_search_restriction', 1);
        $current_version = "1.5";
    case "1.5":
        $this->SetPreference('mle_separator', '/');

        $fn = cms_join_path(dirname(__FILE__), 'templates', 'orig_mle_template.tpl');
        if (file_exists($fn)) {
            $template = file_get_contents($fn);
            $this->SetPreference('default_mle_template', $template);
            $this->SetTemplate('mle_templateFlags', $this->GetTemplate('mle_template'));
            $this->SetPreference('current_mle_template', 'Flags');
        }
        $fn = cms_join_path(dirname(__FILE__), 'templates', 'orig_mle_template_dropdown.tpl');
        if (file_exists($fn)) {
            $template = file_get_contents($fn);
            $this->SetTemplate('mle_templateDropdown', $template);
        }

        $fn = cms_join_path(dirname(__FILE__), 'templates', 'orig_mle_template_separator.tpl');
        if (file_exists($fn)) {
            $template = file_get_contents($fn);
            $this->SetTemplate('mle_templateSeparator', $template);
        }
        $this->DeleteTemplate('mle_template');
        $current_ve2rsion = "1.6";
    case "1.6":
        $this->CreatePermission('manage translator_mle', 'manage translator_mle');
        $current_version = "1.7";
    case "1.8":
        $current_version = "1.9";
    case "1.9":
        // delete any dependencies
        $query = "DELETE FROM " . cms_db_prefix() . "module_deps WHERE child_module = ? AND parent_module = ?";
        $db->Execute($query, array($this->GetName(), 'ContentCache'));
        $contentops = cmsms()->GetContentOperations();
        $current_version = "1.9";
    case "1.10.1":
        $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . 'module_mlecms_config', 'extra C(60)');
        $dict->ExecuteSQLArray($sqlarray);
    case "1.10.2":
        $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . 'module_mlecms_config', 'direction C(10)');
        $dict->ExecuteSQLArray($sqlarray);
        $current_version = "1.10.3";
    case "1.10.3":
        if ($this->GetPreference('mle_id') == '{MleCMS action="get_root_alias"}' || $this->GetPreference('mle_id') == "{MleCMS action='get_root_alias'}")
            $this->SetPreference('mle_id', '{get_root_alias}');
    case "1.10.4":
        $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . 'module_mlecms_config', 'setlocale C(100)');
        $dict->ExecuteSQLArray($sqlarray);
    case "1.10.5":
        $query = "UPDATE " . cms_db_prefix() . "module_mlecms_config SET setlocale = ''";
        $db->Execute($query, array());
        
        $current_version = "1.10.6";
}

// put mention into the admin log
$this->Audit(0, $this->Lang('friendlyname'), $this->Lang('upgraded', $this->GetVersion()));
?>