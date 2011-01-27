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

if (!$this->CheckAccess("")) {
    return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

if (!isset($params['compid'])) {
    $this->RedirectToTab();
    exit;
}

$sort = $db->GetOne('SELECT sort FROM ' . cms_db_prefix() . 'module_mlecms_config WHERE id = ?',array($params["compid"]));

$db->Execute('UPDATE ' . cms_db_prefix() . 'module_mlecms_config SET sort  =  ? WHERE sort > ? LIMIT 1',array(($sort),$sort));
$db->Execute('UPDATE ' . cms_db_prefix() . 'module_mlecms_config SET sort  =  ? WHERE id = ? LIMIT 1',array(($sort+1),$params["compid"]));

@$this->SendEvent('LangEdited', array());

$this->RedirectToTab();
exit;

?>