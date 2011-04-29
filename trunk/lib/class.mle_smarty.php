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

class mle_smarty {

    /**
     * Initialize the smarty plugins.
     */
    public static function init() {
        $smarty = cmsms()->GetSmarty();

        $smarty->register_function('mle_assign', array('mle_smarty', 'mle_assign'));
        $smarty->register_function('translate', array('mle_smarty', 'translator'));
        $smarty->register_block('translator', array('mle_smarty', 'translator_block'));
    }

    /**
     *  Translator smarty functon
     * @param array $params 
     * @param array $smarty
     * @return type 
     */
    public function translator($params, &$smarty) {
        $module = cms_utils::get_module('MleCMS');
        return $module->DoAction('translator', '', $params);
    }

    public function translator_block($params, $content, &$smarty, &$repeat) {
        if (!$content)
            return;

        $module = cms_utils::get_module('MleCMS');
        // opening tag
        if ($repeat) {
            // get from cache
            // exist, stop work
            $repeat = false;
        } else {
            // set cache
            $params["text"] = $content;
            return $module->DoAction('translator', '', $params);

            return;
        }
    }

    /**
     *  get mle values from object (example $item->title, $item->title_en...)
     * @param array $params
     * @param array $smarty 
     */
    public function mle_assign($params, &$smarty) {

        if (!isSet($params["object"]) || !is_object($params["object"]) || !isSet($params["par"]))
            return;

        $smarty = cmsms()->GetSmarty();
        $lang_parent = $smarty->get_template_vars('lang_parent');
        $object = $params["object"];
        $par = $params["par"];
        $mle_par = $params["par"] . '_' . $lang_parent;


        $value = $object->$par;
        if ($object->$mle_par != "")
            $value = $object->$mle_par;

        $object->$par = $value;

        if (isSet($params["assign"]))
            $smarty->assign($params["assign"], $object);
        else
            echo $value;
    }

}

// end of class
#
# EOF
#
?>
