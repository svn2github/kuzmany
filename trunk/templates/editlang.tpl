{$startform} 
{if isset($compid)}
<div class="pageoverflow">
    <p class="pagetext">{$idtext}:</p>
    <p class="pageinput">{$compid}</p>
</div>
{/if}
<div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('name')}:</p>
    <p class="pageinput">
	{$name}
    </p>
</div>
<div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('alias')}:</p>
    <p class="pageinput">
	{$alias}
        <br />
        {$mod->Lang('par_template')}: {literal}{$lang_parent}{/literal}
    </p>
</div>
<div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('extra')}:</p>
    <p class="pageinput">
	{$extra}
        <br />
        {$mod->Lang('par_template')}: {literal}{$lang_extra}{/literal}
    </p>
</div>
<div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('canonical')}:</p>
    <p class="pageinput">
	{$canonical}
    </p>
</div>

<div class="pageoverflow locale">
    <p class="pagetext">{$mod->Lang('locale')}:</p>
    <p class="pageinput">
	{$locale}
        <br />
        {$mod->Lang('par_template')}: {literal}{$lang_locale}{/literal}
    </p>
</div>

<div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('flag')}:</p>
    <p class="pageinput">
	     {if isset($flag) && !empty($flag) && $flag != '0'}{$flag}<br/>
       {$mod->Lang('delete')}:<input type="checkbox" name="{$mod->GetActionId()}deleteimg" value="{$flag}" /><br/>
     {/if}
        <input type="file" name="{$actionid}flag" size="50" maxlength="255" />
    </p>
</div>

    {*
<div class="pageoverflow locale">
    <p class="pagetext">{$mod->Lang('setlocale')}:</p>
    <p class="pageinput">
	{$setlocale}
<br >{$mod->Lang('documentation')}: <a target="_blank" href="http://www.php.net/setlocale">www.php.net/setlocale</a> 
<br >{$mod->Lang('example')}:  de_DE@euro
    </p>
</div>*}


<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}</p>
</div>

{$endform}
