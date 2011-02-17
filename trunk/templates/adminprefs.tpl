{$startform}
<fieldset>
    <legend>{$mod->Lang('options')}</legend>
        <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('mle_id')}:</p>
        <p class="pageinput">
                  {$mle_id}
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
    <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('mle_template')}:</p>
        <div class="pageinput">
                  {$mle_template}
        </div>
    </div>
   </fieldset>
<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}</p>
</div>
{$endform}
