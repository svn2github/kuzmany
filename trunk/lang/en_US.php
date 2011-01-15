<?php

$lang['friendlyname'] = 'Mle CMS';
$lang['postinstall'] = 'Mle CMS was successful installed';
$lang['postuninstall'] = 'Mle CMS was successful uninstalled';
$lang['really_uninstall'] = 'Really? Are you sure
you want to unsinstall this fine module?';
$lang['uninstalled'] = 'Module Uninstalled.';
$lang['installed'] = 'Module version %s installed.';
$lang['upgraded'] = 'Module upgraded to version %s.';
$lang['moddescription'] = 'This module add multilanguage solutions to you CMS Made Simple';
$lang['info_success'] = 'Succes';
$lang['optionsupdated'] = 'Options updated';

$lang['error'] = 'Error!';
$land['admin_title'] = 'Admin Panel';
$lang['admindescription'] = '';
$lang['accessdenied'] = 'Access Denied. Please check your permissions.';
$lang['postinstall'] = 'Post Install Message, (e.g., Be sure to set "manage mle_cms" permissions to use this module!)';

// Mle config
$lang['mle_config'] = 'Multilang config';
$lang['idtext'] = 'ID';
$lang['alias'] = 'Root alias';
$lang['name'] = 'Name';

$lang['locale'] = 'Locale';
$lang['flag'] = 'Flag';

// Snippets

$lang['manage_snippets'] = 'Snippets';
$lang['unknown'] = 'Error: Unknown';
$lang['delete'] = 'Delete';
$lang['areyousure'] = 'Are you sure ?';
$lang['edit'] = 'Edit';
$lang['add'] = 'Add';
$lang['source'] = 'Source';
$lang['submit'] = 'Submit';
$lang['cancel'] = 'Cancel';
$lang['apply'] = 'Apply';
$lang['tag'] = 'Tag';

// Blocks
$lang['manage_blocks'] = 'Blocks';

// Options
$lang['options'] = 'Options';
$lang['mle_template'] = 'Multilang template';
$lang['mle_hierarchy_switch'] = 'Hierarchy switch';


$lang['help_name'] = 'snippet or block name';


$lang['changelog'] = '<ul>
<li>Version 1 - january 2011 Initial Release.</li>
</ul>';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>This module add multilanguage solution to your CMS Made Simple.</p>
<h3>How Do I Use It</h3>
<p>Each language have own page structure. Root alias is ID for each language. </p>
<p>Set up your language in module. Put {MleCMS action="init"} tag on top your templates.</p>
<p>Put {MleCMS action="langs"} tag to your template for language switch. </p>
<p>For better experience use Snippet or Blocks with multilanguage support. Build easy your multilanguage site.</p>
<p>Example for multilanguage News module: {news number="5" category=$lang_parent lang=$lang_locale}</p>';
?>
