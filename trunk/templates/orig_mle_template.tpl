{if $langs|@count}
{foreach from=$langs item=lang name=language}
{capture assign="lang_href"}{cms_selflink href=$lang.alias}{/capture}
{if $lang_href}
{if $page_alias==$lang.alias}
<span class="active">
{if $lang.flag}<img src="uploads/{$lang.flag}" alt="{$lang.name}" title="{$lang.name}"  />{else}{$lang.name}{/if}
</span>
{else}
<a   {if $lang.flag}style="-ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=50)'; filter: alpha(opacity=50); opacity:.5;"{/if} href="{$lang_href}">
    {if $lang.flag}<img src="uploads/{$lang.flag}" alt="{$lang.name}" title="{$lang.name}"  />{else}{$lang.name}{/if}
</a>
{/if}
{/if}
{/foreach}
{/if}