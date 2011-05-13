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
$lang['module_missing'] = 'Please, instal module %s';

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

$lang['custom'] = 'Custom';
$lang['locale_custom'] = 'Locale custom';
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
$lang['mle_id'] = 'Mle identifier (for monolingual site use {$lang})';
$lang['mle_separator'] = 'Separator between langs (for {MleCMS action="langs" template="Separator"})';
$lang['mle_template'] = 'Multilang template';
$lang['addedit_mle_template'] = 'Add/Edit multilang template';
$lang['mle_hierarchy_switch'] = 'Hierarchy switch';
$lang['mle_search_restriction'] = 'Search MLE restriction (only for page search)';
$lang['mle_auto_redirect'] = 'Language detection';
$lang['none'] = 'None';
$lang['root_redirect'] = 'Redirect in the root directory';
$lang['hierarchy_redirect'] = 'Redirect on each level of hierarchy';

// Translator
$lang['mle_translator'] = 'Translator';
$lang['mle_translator_example'] = 'Put to your template: {translate text="anything"}, return to the translator tab and edit it.';

$lang['help_name'] = 'snippet or block name';
$lang['help_template'] = 'template (default Flags)';


$lang['changelog'] = '<ul>
<li>Version 1.4 - 1.7 - april 2011 - som small updates</li>
<li>Version 1.3 - january 2011 - new millestone - Mle Translator</li>
<li>Version 1.2 - january 2011 - new millestone - auto redirection</li>
<li>Version 1.1 - january 2011 - small update</li>
<li>Version 1 - january 2011 - Initial Release.</li>
</ul>';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>This module add multilanguage solution to your CMS Made Simple.</p>
<h3>How Do I Use It</h3>
<p>Check installation guide <a href="http://cmsmadesimple.sk/modules/MleCMS/installation-guide.html">Installation Guide</a></p>
<h3>Plugins</h3>
<p><strong>Translate</strong> {translate text="some text"} or {translator}some text{/translator}</p>
<p>Params</p>
<ul>
<li>text (required) - text for translate</li>
<li>assign (optional)  - smarty assign</li>
</ul>
<br />
<p><strong>Mle assign</strong> - (news example: {mle_assign object=$entry par="title" assign="entry"}) </p>
<p>Params</p>
<ul>
<li>from (required) - object for mle assign</li>
<li>par (required)  - par for find mutlilangue string (example: title and mle version  are  title_sk, title_de, title_fr)</li>
<li>assign (optional)  - assign to object</li>
</ul>
<br />
<p><strong>Mle search checker</strong> - (for modules search search restriction, plugin create sql query) </p>
<p>Example</p>
<code>
 {foreach from=$results item=entry}<br />
        {if $entry->module == "MyModule"}<br />
        {mle_search_checker select="filed" from="module_mymodule" id=$entry->modulerecord assign="language"}                <br />
        {if !$lang_parent}{MleCMS action="get_root_alias" assign="lang_parent"}{/if}<br />
        {*display every record from my category *}<br />
        {if $language == $lang_parent}  <br />
        {$entry->title}<br />
        '.htmlspecialchars('<a href="{$entry->url}">{$entry->urltxt}</a>&nbsp;<span>({$entry->weight}%)</span>').'<br />
        {/if}<br />
        {/foreach}<br />
</code><br />
<p>Params</p>
<ul>
<li>select (required)  - SELECT select</li>
<li>from (required) - FROM table</li>
<li>assign (optional)  - assign to object</li>
</ul>
    <h3>Like it? Donate :)</h3>
    <p><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</p>
';
?>
