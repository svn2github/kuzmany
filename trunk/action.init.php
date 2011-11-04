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

$alias = $this->ProcessTemplateFromData($this->GetPreference('mle_id'));
if (!$alias)
    $alias = $this->get_root_alias();

if (!$alias)
    return;

$db = cmsms()->GetDb();
$query = 'SELECT * FROM ' . cms_db_prefix() . 'module_mlecms_config  WHERE alias = ?';
$lang = $db->GetRow($query, array($alias));
if (!$lang)
    return;
$smarty->assign('lang_parent', $lang["alias"]);
$smarty->assign('lang_locale', $lang["locale"]);
$smarty->assign('lang_extra', $lang["extra"]);
$smarty->assign('lang_direction', $lang["direction"]);
if (isSet($lang["locale"]) && empty($lang["locale"]) == false)
    setlocale(LC_ALL, $lang["locale"]);
?>