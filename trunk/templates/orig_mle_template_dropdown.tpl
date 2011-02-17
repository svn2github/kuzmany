{if $langs|@count}
<select onchange="location.href=options[selectedIndex].value;">
{foreach from=$langs item=lang name=language}
{capture assign="lang_href"}{cms_selflink href=$lang.alias}{/capture}
{if $lang_href}
{if $page_alias==$lang.alias}
<option selected="selected" value="{$lang_href}">{$lang.name}</option>
{else}
<option value="{$lang_href}">{$lang.name}</option>
{/if}
{/if}
{/foreach}
</select>
{/if}