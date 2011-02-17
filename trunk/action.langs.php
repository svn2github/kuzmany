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

if ($this->GetPreference('mle_hierarchy_switch')) {
// get hierarchy lang switch
    $smarty = cmsms()->GetSmarty();
    $friendly_position = $smarty->get_template_vars('friendly_position');
    $friendly_position_array = explode(".", $friendly_position);
    unset($friendly_position_array[0]);
    $hierarchy_array = array();
    foreach ($friendly_position_array as $one) {
        $hierarchy_array[] = str_pad($one, 5, '0', STR_PAD_LEFT);
    }
    $new_friendly_position = (count($hierarchy_array) ? '.' : '') . implode(".", $hierarchy_array);
    $query = 'SELECT 
        mle.id,
        mle.name,
        mle.locale,
        mle.flag,
        content_hierchy.content_alias as alias FROM ' . cms_db_prefix() . 'module_mlecms_config mle
INNER JOIN ' . cms_db_prefix() . 'content  content ON content.content_alias = mle.alias
LEFT JOIN ' . cms_db_prefix() . 'content  content_hierchy ON (content_hierchy.hierarchy = CONCAT(content.hierarchy,?))
ORDER BY mle.sort ASC';
    $langs = $db->GetAll($query, array($new_friendly_position));
} else {
    $langs = $this->getLangs();
}

$smarty->assign_by_ref('langs', cge_array::to_object($langs));

// unlike template
$template = 'mle_template' . $this->GetPreference('current_mle_template');
if (isset($params['template'])) {
    $template = 'mle_template' . $params['template'];
}
echo $this->ProcessTemplateFromDatabase($template);
?>