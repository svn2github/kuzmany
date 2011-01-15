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
<div class="pageoverflow">
<p class="pagetext">{$mod->Lang('locale')}:</p>
<p class="pageinput">
	{$locale}
	</p>
</div>
<div class="pageoverflow">
<p class="pagetext">{$mod->Lang('flag')}:</p>
<p class="pageinput">
	{$flag}
	</p>
</div>



<div class="pageoverflow">
<p class="pagetext">&nbsp;</p>
<p class="pageinput">{$hidden}{$submit}{$cancel}</p>
</div>
    
{$endform}
    