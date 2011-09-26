{if $langs|@count}
{foreach from=$langs item=l name=language}
{if $smarty.foreach.language.first==false}{$mle_separator}{/if}
{capture assign="lang_href"}{cms_selflink href=$l.alias}{/capture}
{if $lang_href}
{if $page_alias==$l.alias}
<span class="active">
{$l.name}
</span>
{else}
<a   href="{$lang_href}">
    {$l.name}
</a>
{/if}
{/if}
{/foreach}
{/if}