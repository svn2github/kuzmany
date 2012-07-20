

{literal}
    <style type="text/css">
        #trans input { width: 100%; }
        #trans span { display: block; cursor: pointer; }
    </style>
{/literal}

<p><strong>{$mod->Lang('example')}</strong>: {literal}{translate text="my text"} or {"my text"|translate} or {translate}my text{/translate}{/literal}</p>

<table id="trans" cellspacing="0" class="pagetable">

    <tr id="label">
        <th><span></span></th>
        {foreach from=$langsArray item=pLang}
            <th><span>{$pLang.name}</span></th>
        {/foreach}

        <th class="pageicon"></th>
    </tr>




    {foreach from=$keysArray item=items key=key name="itemsLoop"}
             <tr id="{$key}" class="keys{if $smarty.foreach.itemsLoop.index is odd} row2{else} row1{/if}">
                 <td>
                     {$key}
                 </td>
        {foreach from=$langsArray item=pLang}
            {assign var="locale" value=$pLang.locale}
                <td data-lang="{$pLang.locale}">
                    <span>{if $items.$locale}{$items.$locale}{else}{$key|trim}{/if}</span>
        </td>
        {/foreach}
    <td><a class='del' href="#">{$deleteIcon}</a></td>
</tr>
{foreachelse}
    <tr>
        <td>
            <p>{$mod->Lang('mle_translator_example')}</p>
        </td>
    </tr>
{/foreach}


</table>

{literal}
    <script type="text/javascript">

    {/literal}
        var areyousure = "{$mod->Lang('areyousure')}";
    {literal}

        $(window).load(function(){
           //$('#trans .keys td').css('width', $('#trans').width() / $('#trans th').size());
        });

        $(document).ready(function(){
            $('#trans .keys td span').live('click', function(){
                $(this).hide();
                $(this).parents('td').append('<input type="text" value="" />');
                $(this).siblings('input').val($.trim($(this).text())).focus().select();
            });

            /** remove events */
            $('#trans .del').bind('click', function(event){
                var confirmBox = window.confirm(areyousure);
                if (confirmBox){
                    $.myvars = {};
                    $.myvars.thisObj = $(this);
                    event.preventDefault();
                    var delKey = $(this).parents('tr').attr('id');

                    $.ajax({
                        type: 'POST',
                        url: '{/literal}{$ajaxLink}{literal}',
                        dataType: 'json',
                        data: ({
                            'delKey': delKey,
                            '{/literal}{$cms_secure_param_name}{literal}': '{/literal}{$smarty.get.$cms_secure_param_name}{literal}',
                            'module': '{/literal}{$smarty.get.module}{literal}',
                            'showtemplate': 'false',
                            'aAction': 'remove'
                        }),
                        complete: function(){
                            $.myvars.thisObj.parents('tr').find('td').css('background-color','yellow').parents('tr').fadeOut('slow', function(){
                                $(this).remove();
                                $('#trans tr').removeClass('row2');
                                $('#trans tr:even').addClass('row2');
                            });
                        }
                    });
                }else{
                    return false;
                        } // end confirmBox
            })

            /** update events */
            $('#trans tr td input').live('blur', function(){
                var $this = this;
                $.ajax({
                    type: 'POST',
                    url: '{/literal}{$ajaxLink}{literal}',
                    dataType: 'json',
                    data: ({
                        'editKey': $(this).parents('tr').attr('id'),
                        'editValue': $.trim($(this).val()),
                        'editLang': $(this).parents('td').attr('data-lang'),
                        '{/literal}{$cms_secure_param_name}{literal}': '{/literal}{$smarty.get.$cms_secure_param_name}{literal}',
                        'module': '{/literal}{$smarty.get.module}{literal}',
                        'showtemplate': 'false',
                        'aAction': 'update'
                    }),
                    complete: function(){
                        $($this).hide();
                        $($this).siblings('span').text($.trim($($this).val())).show();
                        $($this).remove();
                    }
                });
            });
        })
    </script>
{/literal}

