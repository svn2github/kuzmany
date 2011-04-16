{literal}
<script type="text/javascript">
$(document).ready(function(){
    if($('.locale').find('select').val() == "custom") $('.localecustom').fadeIn(); else $('.localecustom').fadeOut();
        $('.locale').change(function(){
            if($(this).find('option:selected').val() == "custom") $('.localecustom').fadeIn(); else $('.localecustom').fadeOut();
        })

})
</script>
{/literal}

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
    </p>
</div>
<div class="pageoverflow locale">
    <p class="pagetext">{$mod->Lang('locale')}:</p>
    <p class="pageinput">
	{$locale}
    </p>
</div>
<div class="pageoverflow localecustom" style="display:none">
    <p class="pagetext">{$mod->Lang('locale_custom')}:</p>
    <p class="pageinput">
	{$locale_custom}
    </p>
</div>
<div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('flag')}:</p>
    <p class="pageinput">
	     {if isset($flag) && !empty($flag) && $flag != '0'}{$flag}<br/>
       {$mod->Lang('delete')}:<input type="checkbox" name="{$mod->GetActionId()}deleteimg" value="{$flag}"><br/>
     {/if}
        <input type="file" name="{$actionid}flag" size="50" maxlength="255">
    </p>
</div>



<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$hidden}{$submit}{$cancel}</p>
</div>

{$endform}
