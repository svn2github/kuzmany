{$form_start}

<div class="pageoverflow">
    <p class="pagetext">{$title}:</p>
    <p class="pageinput">{$input}</p>
</div>

<fieldset>
    <legend>{$title_source}</legend>
    <div class="pageoverflow">
        <div class="pageinput">
{$mod->StartTabHeaders()}
{foreach from=$langs item=lang}
{$mod->SetTabHeader($lang.alias, $lang.name)}
{/foreach}
{$mod->EndTabHeaders()}
{$mod->StartTabContent()}
{foreach from=$langs item=lang}
{$mod->StartTab($lang.alias)}
{$lang.textarea}
{$mod->EndTab()}
{/foreach}
{$mod->EndTabHeaders()}
        </div>
    </div>
</fieldset>
<div class="pageoverflow">
    <p class="pagetext"></p>
    <p class="pageinput">{$form_details_submit} {$form_details_apply}</p>
</div>
<div class="pageoverflow">
    <p class="pagetext"></p>
    <p  class="pageinput">{$form_details_cancel}</p>
</div>

{$form_end}