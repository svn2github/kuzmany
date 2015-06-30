{if $langs_count}
    <select onchange="location.href=options[selectedIndex].value;">
        {foreach from=$langs item=l name=language}
        {capture assign="lang_href"}{cms_selflink href=$l.alias}{/capture}
        {if $lang_href}
            {if $page_alias==$l.alias}
                <option selected="selected" value="{$lang_href}">{$l.name}</option>
            {else}
                <option value="{$lang_href}">{$l.name}</option>
            {/if}
        {/if}
    {/foreach}
</select>
{/if}