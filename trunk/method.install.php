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

$taboptarray = array('mysql' => 'TYPE=MyISAM');

// Creates the otazky table
$flds = "
	id I KEY AUTO,
	name C(64),
	alias C(10),
	locale C(10),
	setlocale C(100),
	direction C(10),
	flag C(60),
	extra C(60),
	sort I,
	modified_date " . CMS_ADODB_DT . ",
	created_date " . CMS_ADODB_DT . "
	";
$dict = NewDataDictionary($db);
$sqlarray = $dict->CreateTableSQL(cms_db_prefix() . "module_mlecms_config", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// permissions
$this->CreatePermission('manage translator_mle', 'manage translator_mle');
$this->CreatePermission('manage mle_cms', 'manage mle_cms');
$this->CreatePermission('manage ' . MLE_SNIPPET . 'mle', 'manage ' . MLE_SNIPPET . 'mle');
$this->CreatePermission('manage ' . MLE_BLOCK . 'mle', 'manage ' . MLE_BLOCK . 'mle');

// preference
$this->SetPreference('mle_hierarchy_switch', 1);
$this->SetPreference('mle_auto_redirect', 0);
$this->SetPreference('mle_id', '{get_root_alias}');
$this->SetPreference('mle_separator', '/');
$this->SetPreference('mle_search_restriction', 1);

$fn = cms_join_path(dirname(__FILE__), 'templates', 'orig_mle_template.tpl');
if (file_exists($fn)) {
    $template = file_get_contents($fn);
    $this->SetPreference('default_mle_template', $template);
    $this->SetTemplate('mle_templateFlags', $template);
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

$this->AddEventHandler('Core', 'ContentPostRender', false);
$this->AddEventHandler('Search', 'SearchCompleted', false);

$this->CreateEvent('LangEdited');
$this->CreateEvent('BlockEdited');

// put mention into the admin log
$this->Audit(0, $this->Lang('friendlyname'), $this->Lang('installed', $this->GetVersion()));
?>