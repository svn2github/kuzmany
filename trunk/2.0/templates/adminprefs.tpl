{$startform}
<fieldset>
    <legend>{$mod->Lang('options')}</legend>
    {*<div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('mle_id')}:</p>
    <p class="pageinput">
    {$mle_id}
    </p>
    </div>
    <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('mle_separator')}:</p>
    <p class="pageinput">
    {$mle_separator}
    <br /><strong>{$mod->Lang('for_template_separator')}</strong>
    </p>
    </div>
    <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('translator_action_params')}:</p>
    <p class="pageinput">
    {$translator_action_params}
    <br /><strong>{$mod->Lang('example')}</strong>: {literal}nocache=1{/literal}
    </p>
    </div>*}

    <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('mle_init')}:</p>
        <p class="pageinput">
            <select name="{$actionid}mle_init">
                {html_options options=$mle_init selected=$mle_init_module}
            </select>
        </p>
    </div>

    <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('mle_auto_redirect')}:</p>
        <p class="pageinput">
            {$mle_auto_redirect}
        </p>
    </div>
    <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('mle_hierarchy_switch')}:</p>
        <p class="pageinput">
            {$mle_hierarchy_switch}
        </p>
    </div>
    <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('mle_search_restriction')}:</p>
        <p class="pageinput">
            {$mle_search_restriction}
        </p>
    </div>

</fieldset>
<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}</p>
</div>
{$endform}
