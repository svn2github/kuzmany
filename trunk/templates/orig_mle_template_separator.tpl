{if $langs|@count}
{foreach from=$langs item=lang name=language}
{if $smarty.foreach.language.first==false}{$mle_separator}{/if}
{capture assign="lang_href"}{cms_selflink href=$lang.alias}{/capture}
{if $lang_href}
{if $page_alias==$lang.alias}
<span class="active">
{$lang.name}
</span>
{else}
<a   href="{$lang_href}">
    {$lang.name}
</a>
{/if}
{/if}
{/foreach}
{/if}