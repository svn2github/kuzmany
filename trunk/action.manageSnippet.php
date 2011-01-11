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
if (!$this->CheckAccess('manage ' . $params["prefix"] . 'mle')) {
    return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}


if (isset($params['cancel'])) {
    $this->RedirectToTab($id, "manage_" . $params["prefix"] . "mle");
    exit;
}


if (isset($params['name']) && $params['name'] != '') {
    if (isset($params['submitbutton']) || isset($params['applybutton'])) {
        // set all langaugages
        $this->SetTemplate($params["prefix"] . $params['name'], json_encode($params["source"]));

        if (isset($params['submitbutton'])) {
            $this->SetMessage($this->Lang('info_success'));
            $this->RedirectToTab($id, "manage_" . $params["prefix"] . "mle");
            exit;
        }
    }
}


$this->smarty->assign('form_start', $this->CreateFormStart($id, 'manageSnippet', $returnid)
        . $this->CreateInputHidden($id, 'prefix', $params["prefix"])
        . $this->CreateInputHidden($id, 'wysiwyg', $params["wysiwyg"])
);
$this->smarty->assign('title', $this->Lang('name'));
$this->smarty->assign('input', $this->CreateInputText($id, 'name', (isset($params['name'])) ? str_replace($params["prefix"], '', $params['name']) : '', 50));
$this->smarty->assign('title_source', $this->Lang('source'));



$this->smarty->assign('langs', cge_array::to_object($this->GetLangsForm($this->getLangs(), $id, $params, $params["wysiwyg"])));

$this->smarty->assign('form_details_submit', $this->CreateInputSubmit($id, 'submitbutton', $this->Lang('submit')));
$this->smarty->assign('form_details_apply', $this->CreateInputSubmit($id, 'applybutton', $this->Lang('apply')));
$this->smarty->assign('form_details_cancel', $this->CreateInputSubmit($id, 'cancel', $this->Lang('cancel')));
$this->smarty->assign('form_end', $this->CreateFormEnd());

echo $this->ProcessTemplate('manageSnippet.tpl');
?>