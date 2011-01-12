<?php
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

if(!isset($gCms)) exit;

if (!$this->CheckAccess('manage translator_mle')) {
    return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$config = cmsms()->getConfig();


include_once $this->moduleDir.'simplexml4.php';

$langs = $this->getLangs();
foreach($langs as $lang){
    $file = cms_join_path($config["uploads_path"],'translations','tr.'.$lang["locale"].'.xml');
    if(is_file($file))
	{
                $xml = simplexml_load_file($file);
                print_r($xml);
continue;
		$orig_lang = file_get_contents($file);
		$parser_orig = new SimpleXML4($orig_lang, false);
		$parser_orig->Parse();
		$arr_orig=array();
		if(isset($parser_orig->document->lt)) $_lt_orig = $parser_orig->document->lt[0]->tagData;
		if(isset($parser_orig->document->lu)) $_lu_orig = $parser_orig->document->lu[0]->tagData;
		if(isset($parser_orig->document->{$this->tagTranslations}))
		{
			foreach($parser_orig->document->{$this->tagTranslations} as $objTag)
			{
				$_safe_tr = cms_html_entity_decode_utf8(base64_decode($objTag->tr[0]->tagData));
				$arr_orig[$objTag->st[0]->tagData] = array('tr_orig'=>$_safe_tr, 'ts_orig'=>$objTag->ts[0]->tagData);
			}
		}
		$error = false;
	}
}
/*
 *    [0] => XMLTag Object
                                        (
                                            [tagAttrs] => Array
                                                (
                                                )

                                            [tagName] => st
                                            [tagData] => test
                                            [tagChildren] => Array
                                                (
                                                )

                                            [tagParents] => 2
                                        )

                                    [1] => XMLTag Object
                                        (
                                            [tagAttrs] => Array
                                                (
                                                )

                                            [tagName] => tr
                                            [tagData] => aGlwIGhvcA==
                                            [tagChildren] => Array
                                                (
                                                )

                                            [tagParents] => 2
                                        )

 */
return;

$error=true;
if(in_array($params['orig_lang'], $arr_currentlangs))
{
	if(is_file($this->translationsDir.$this->prefixFile.$params['orig_lang'].'.xml'))
	{
		$orig_lang = file_get_contents($this->translationsDir.$this->prefixFile.$params['orig_lang'].'.xml');
		$parser_orig = new SimpleXML4($orig_lang, false);
		$parser_orig->Parse();

		$arr_orig=array();
		if(isset($parser_orig->document->lt)) $_lt_orig = $parser_orig->document->lt[0]->tagData;
		if(isset($parser_orig->document->lu)) $_lu_orig = $parser_orig->document->lu[0]->tagData;
		if(isset($parser_orig->document->{$this->tagTranslations}))
		{
			foreach($parser_orig->document->{$this->tagTranslations} as $objTag)
			{
				$_safe_tr = cms_html_entity_decode_utf8(base64_decode($objTag->tr[0]->tagData));
				$arr_orig[$objTag->st[0]->tagData] = array('tr_orig'=>$_safe_tr, 'ts_orig'=>$objTag->ts[0]->tagData);
			}
		}
		$error = false;
	}
}
if($error)
{
	return $this->_DisplayErrorPage($id, $params, $returnid, $this->Lang('nolanguage_xml', $params['orig_lang']));
}


if($params['orig_lang'] != $params['target_lang'])
{
	$error=true;
	if(in_array($params['target_lang'], $arr_currentlangs))
	{
		if(is_file($this->translationsDir.$this->prefixFile.$params['target_lang'].'.xml'))
		{
			$target_lang = file_get_contents($this->translationsDir.$this->prefixFile.$params['target_lang'].'.xml');
			$parser_target = new SimpleXML4($target_lang, false);
			$parser_target->Parse();

			$arr_target=array();
			if(isset($parser_target->document->lt)) $_lt_target = $parser_target->document->lt[0]->tagData;
			if(isset($parser_target->document->lu)) $_lu_target = $parser_target->document->lu[0]->tagData;
			if(isset($parser_target->document->{$this->tagTranslations}))
			{
				foreach($parser_target->document->{$this->tagTranslations} as $objTag)
				{
					$_safe_tr = cms_html_entity_decode_utf8(base64_decode($objTag->tr[0]->tagData));
					$arr_target[$objTag->st[0]->tagData] = array('tr_target'=>$_safe_tr, 'ts_target'=>$objTag->ts[0]->tagData);
				}
			}
			$error = false;
		}
	}
	if($error)
	{
		return $this->_DisplayErrorPage($id, $params, $returnid, $this->Lang('nolanguage_xml', $params['target_lang']));
	}
}




if($params['orig_lang'] != $params['target_lang'])
{
	$_flag=false;
	$arr_view=array();
	$parents=1;
	if(!isset($parser_target->document->{$this->tagTranslations}))
		$parents = 0;

	foreach($arr_orig as $key=>$value)
	{
		if(!isset($arr_target[$key]))
		{
			$idx = $parser_target->document->AddChild($this->tagTranslations, array(), $parents);
			$parser_target->document->{$this->tagTranslations}[$idx]->AddChild('st', array(), 2);
			$parser_target->document->{$this->tagTranslations}[$idx]->AddChild('tr', array(), 2);
			$parser_target->document->{$this->tagTranslations}[$idx]->AddChild('ts', array(), 2);
			$parser_target->document->{$this->tagTranslations}[$idx]->Update('st', trim($key));
			$parser_target->document->{$this->tagTranslations}[$idx]->Update('tr', '<![CDATA['.base64_encode($value['tr_orig']).']]>');
			$parser_target->document->{$this->tagTranslations}[$idx]->Update('ts', 1);
			$arr_target[$key] = array('tr_target'=>$value['tr_orig'], 'ts_target'=>1);
			$_flag = true;
		}
		$arr_view[$key] = array_merge($arr_orig[$key], $arr_target[$key]);
	}
	if($_flag)
	{
		$parser_target->saveXML($this->translationsDir.$this->prefixFile.$params['target_lang'].'.xml');
	}

	$smarty->assign('arr_view', $arr_view);
}

$userid = get_userid();
$smarty->assign('tr_orig_edit', $this->_permission_editing($userid, $params['orig_lang']));
$smarty->assign('userid', $userid);

$userops =& $gCms->GetUserOperations();
#$oneuser =& $userops->LoadUserByID($userid)->username;


if(isset($params['message'])) $smarty->assign('message', $params['message']);
$smarty->assign('arr_orig', $arr_orig);

$smarty->assign('orig_lang', $params['orig_lang']);
$smarty->assign('target_lang', $params['target_lang']);
$smarty->assign('orig_native_lang', array_search($params['orig_lang'], $arr_currentlangs));
$smarty->assign('target_native_lang', array_search($params['target_lang'], $arr_currentlangs));
$smarty->assign('orig_last_time', (!empty($_lt_orig)) ? strftime('%c', $_lt_orig) : '');
$smarty->assign('target_last_time', (!empty($_lt_target)) ? strftime('%c', $_lt_target) : '');
$smarty->assign('orig_last_editor', (!empty($_lu_orig)) ? $userops->LoadUserByID($_lu_orig)->username : '');
$smarty->assign('target_last_editor', (!empty($_lu_target)) ? $userops->LoadUserByID($_lu_target)->username : '');

$_module_url = $gCms->config['root_url'].'/modules/'.$this->GetName();
$smarty->assign('module_url', $_module_url);

$smarty->assign('script_pre_16', '<script src="'.$_module_url.'/prototype.js" type="text/javascript"></script>');
$smarty->assign('backurl', $this->CreateLink($id, 'defaultadmin', $returnid, $this->Lang('back')));

$smarty->assign('fulledit', false);
$smarty->assign('moduleId', $id);
$smarty->assign('hidden',
	$this->CreateInputHidden($id, 'do', '').
	$this->CreateInputHidden($id, 'orig_lang', $params['orig_lang']).
	$this->CreateInputHidden($id, 'target_lang', $params['target_lang'])
);


if($this->CheckPermission('Translation Administration') || $this->CheckPermission('Translation Full Editing'))
{
	$smarty->assign('fulledit', true);
	$smarty->assign('delete_icon', $gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif',lang('delete'),'','','systemicon'));
	$smarty->assign('new_icon', $gCms->variables['admintheme']->DisplayImage('icons/system/newobject.gif',lang('add'),'','','systemicon'));

	$smarty->assign('form_start', $this->CreateFormStart($id, 'admin_edit_key', $returnid, 'post', '', false, 'trm', array(), 'name=moduleform_trm'));
	$smarty->assign('form_end', $this->CreateFormEnd());
	$smarty->assign('input_newkey', $this->CreateInputText($id, 'key', '', '25', '64', 'title="'.$this->Lang('add_key').'"'));
}


echo $this->ProcessTemplate('admin_edit_lang.tpl');
?>