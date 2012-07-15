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

if (!$this->CheckAccess('manage ' . $prefix . 'mle')) 
	{
	echo $this->ShowErrors($this->Lang('accessdenied')); return;
	}
/* -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

   Code for Snippets "defaultadmin" admin action

   -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

   Typically, this will display something from a template
   or do some other task.

*/


$template_list = cge_template_utils::get_templates_by_prefix('', $prefix);

$rowclass = 'row1';

$templates = array();

foreach ($template_list as $template)
{
	$onerow = new stdClass();
	$onerow->name = $template;
	$onerow->deletelink = $this->CreateLink($id, 'deleteSnippet', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/delete.gif', $this->Lang('delete'),'','','systemicon'), array('name'=>$template,'prefix'=>$prefix), $this->Lang('areyousure'));
	$onerow->editlink = $this->CreateLink($id, 'manageSnippet', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/edit.gif', $this->Lang('edit'),'','','systemicon'), array('name'=>$template,'prefix'=>$prefix,'wysiwyg'=>$wysiwyg));
	$onerow->edit = $this->CreateLink($id, 'manageSnippet', $returnid,$template, array('name'=>$template,'prefix'=>$prefix,'wysiwyg'=>$wysiwyg));
	$onerow->rowclass = $rowclass;
	$templates[] = $onerow;
	($rowclass=="row1"?$rowclass="row2":$rowclass="row1");
}

$this->smarty->assign('snippets', $templates);

$this->smarty->assign('title', $this->Lang('name'));
$this->smarty->assign('title_tag', $this->Lang('tag'));


$this->smarty->assign('addSnippetLink',$this->CreateLink($id,
				'manageSnippet', '', $this->Lang('add'),
				array('prefix'=>$prefix,'wysiwyg'=>$wysiwyg)));

$this->smarty->assign('addSnippetIcon',$this->CreateLink($id,
				'manageSnippet', '',
				cmsms()->get_variable('admintheme')->DisplayImage('icons/system/newobject.gif', $this->Lang('add_snippet'),'',
					'','systemicon'), array('prefix'=>$prefix,'wysiwyg'=>$wysiwyg)));

// Import section

$this->smarty->assign('form_start', $this->CreateFormStart($id, 'importSnippet', $returnid, 'post','multipart/form-data'));
$this->smarty->assign('form_end',$this->CreateFormEnd());

$this->smarty->assign('info_leaveempty',$this->Lang('help_leaveempty'));



echo $this->ProcessTemplate('adminpanel.tpl');
?>