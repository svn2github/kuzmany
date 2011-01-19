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

if (!isset($gCms)) exit;

$auto_redirect_items = array();
$auto_redirect_items[0] = $this->Lang('none');
$auto_redirect_items[1] = $this->Lang('root_redirect');
$auto_redirect_items[2] = $this->Lang('hierarchy_redirect');

$smarty->assign('startform', $this->CreateFormStart($id, 'admin_optionstab_edit', $returnid,'get'));
$smarty->assign('endform', $this->CreateFormEnd());

$smarty->assign('submit', $this->CreateInputSubmit($id, 'optionssubmitbutton', $this->Lang('submit')));
$this->smarty->assign('mle_id', $this->CreateInputText($id, 'mle_id', $this->GetPreference('mle_id'),55,255));
$this->smarty->assign('mle_auto_redirect',$this->CreateInputDropdown($id, 'mle_auto_redirect', array_flip($auto_redirect_items),-1,$this->GetPreference('mle_auto_redirect')));
$this->smarty->assign('mle_hierarchy_switch', $this->CreateInputYesNoDropdown($id,  'mle_hierarchy_switch',$this->GetPreference('mle_hierarchy_switch')));
$this->smarty->assign('mle_template', $this->CreateTextArea(false,$id, $this->GetTemplate('mle_template'), 'mle_template'));


// Display the populated template
echo $this->ProcessTemplate('adminprefs.tpl');
?>