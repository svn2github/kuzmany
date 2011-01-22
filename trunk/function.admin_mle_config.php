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

$query = "SELECT * FROM " . cms_db_prefix() . "module_mlecms_config ORDER BY sort ASC";
$dbresult = $db->Execute($query);

$admintheme = & $gCms->variables['admintheme'];
global $themeObject;
$numrows = $dbresult->NumRows();
$index = 0;
while ($dbresult && $row = $dbresult->FetchRow()) {
    $onerow = cge_array::to_object($row);

    $onerow->title = $this->CreateLink($id, 'admin_mlecms_config_editlang', $returnid, $row['name'], array('compid' => $row['id']));
    $onerow->editlink = $this->CreateLink($id, 'admin_mlecms_config_editlang', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('compid' => $row['id']));
    $onerow->deletelink = $this->CreateLink($id, 'admin_mlecms_config_deletelang', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('compid' => $row['id']), $this->Lang('areyousure'));

        if ($index > 0) {
            $onerow->moveuplink = $this->CreateLink($id, 'moveup', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/arrow-u.gif', '', '', '', 'systemicon'), array('compid' => $row['id']), '', false, false, 'class="itemlink"');
        }
        if ($index < $numrows - 1) {
            $onerow->movedownlink = $this->CreateLink($id, 'movedown', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/arrow-d.gif', '', '', '', 'systemicon'), array('compid' => $row['id']), '', false, false, 'class="itemlink"');
        }

    $entryarray[] = $onerow;
    $index++;
}


$addlink = $this->CreateLink($id, 'admin_mlecms_config_editlang', $returnid, $this->Lang('add'));
$smarty->assign('addlink', $addlink);

$this->smarty->assign_by_ref('items', $entryarray);
$this->smarty->assign('itemcount', count($entryarray));

echo $this->ProcessTemplate('langs.tpl');
?>