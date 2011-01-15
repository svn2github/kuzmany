{if $langs|@count}
{foreach from=$langs item=lang name=language}
{*if $smarty.foreach.language.first==false}/{/if*}
{if $page_alias==$lang.alias}
<span class="active"><img src="uploads/{$lang.flag}" alt="{$lang.name}" /></span>
{else}
<a   style="-ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=50)'; filter: alpha(opacity=50); opacity:.5;" href="{cms_selflink href=$lang.alias}"><img src="uploads/{$lang.flag}" alt="{$lang.name}"  /></a>
{/if}
{/foreach}
{/if}