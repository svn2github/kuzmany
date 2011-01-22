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

## TAB HEADERS from CGE
echo $this->StartTabHeaders();
if ($this->CheckAccess())
{
    echo $this->SetTabHeader('mle_config', $this->Lang('mle_config'));
}

if ($this->CheckAccess('manage ' . MLE_SNIPPET . 'mle'))
{
    echo $this->SetTabHeader('manage_' . MLE_SNIPPET . 'mle', $this->Lang('manage_snippets'));
}

if ($this->CheckAccess('manage ' . MLE_BLOCK . 'mle'))
{
    echo $this->SetTabHeader('manage_' . MLE_BLOCK . 'mle', $this->Lang('manage_blocks'));
}

if ($this->CheckAccess('manage translator_mle'))
{
    echo $this->SetTabHeader('mle_translator', $this->Lang('mle_translator'));
}


if ($this->CheckPermission('Modify Site Preferences'))
{
    echo $this->SetTabHeader('options', $this->Lang('options'));
}

echo $this->EndTabHeaders();

#
#The content of the tabs
#
echo $this->StartTabContent();

if ($this->CheckAccess())
{
    echo $this->StartTab('mle_config');
    include(dirname(__FILE__) . '/function.admin_mle_config.php');
    echo $this->EndTab();
}

if ($this->CheckAccess('manage ' . MLE_SNIPPET . 'mle'))
{
    $prefix = MLE_SNIPPET;
    echo $this->StartTab('manage_' . $prefix . 'mle', $params);
    $wysiwyg = false;
    include(dirname(__FILE__) . '/function.admin_snippets.php');
    echo $this->EndTab();
}

if ($this->CheckAccess('manage ' . MLE_BLOCK . 'mle'))
{
    $prefix = MLE_BLOCK;
    echo $this->StartTab('manage_' . $prefix . 'mle', $params);
    $wysiwyg = true;
    include(dirname(__FILE__) . '/function.admin_snippets.php');
    echo $this->EndTab();
}

if ($this->CheckAccess('manage translator_mle'))
{
    $prefix = MLE_BLOCK;
    echo $this->StartTab('mle_translator', $params);
    $wysiwyg = true;
    include(dirname(__FILE__) . '/function.admin_mle_translator.php');
    echo $this->EndTab();
}


if ($this->CheckPermission('Modify Site Preferences'))
{
    echo $this->StartTab('options', $params);
    include(dirname(__FILE__) . '/function.admin_optionstab.php');
    echo $this->EndTab();
}

echo $this->EndTabContent();

?>