<div style="clear:both" class="pageoptions"><p class="pageoptions">{$addlink}</p></div>
{if $itemcount > 0}
<table cellspacing="0"  class="pagetable">
	<thead>
		<tr>
			<th>{$mod->Lang('idtext')}</th>
			<th>{$mod->Lang('name')}</th>
			<th>{$mod->Lang('alias')}</th>
			<th>{$mod->Lang('locale')}</th>
			<th class="pageicon" style="width:50px;"></th>
			<th class="pageicon" style="width:50px;"></th>
			<th class="pageicon" style="width:30px;"></th>
		</tr>
	</thead>
	<tbody>
{foreach from=$items item=entry}
	{cycle values="row1,row2" assign='rowclass'}
	{capture assign="pay_type"}pay_types{$entry->payment_type}{/capture}
		<tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
			<td>{$entry->id}</td>
			<td>{$entry->title}</td>
			<td>{$entry->alias}</td>
			<td>{$entry->locale}</td>
			<td>
                        {if isset($entry->moveuplink)}{$entry->moveuplink}{/if}
                        {if isset($entry->movedownlink)}{$entry->movedownlink}{/if}
                        </td>
			<td>{$entry->editlink}</td>
			<td>{$entry->deletelink}</td>
		</tr>
{/foreach}
	</tbody>
</table>
<div class="pageoptions"><p class="pageoptions">{$addlink}</p></div>
{/if}
