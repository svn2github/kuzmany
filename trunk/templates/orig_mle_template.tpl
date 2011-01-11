{if $langs|@count}
{foreach from=$langs item=lang name=language}
{if $smarty.foreach.language.first==false}/{/if} <a href="{cms_selflink href=$lang.alias}" {if $page_alias==$lang.alias} class="active"{/if}>{$lang.name}</a>
{/foreach}
{/if}