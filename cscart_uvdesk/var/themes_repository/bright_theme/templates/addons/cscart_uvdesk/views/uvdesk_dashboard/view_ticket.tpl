{if !$config.tweaks.disable_dhtml}
    {assign var="ajax_class" value="cm-ajax"}
    {* {$c_url = $redirect_url|default:$config.current_url|escape:url} *}
{else}
{/if}
    {$c_url = $redirect_url|default:$config.current_url}
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<div>
    <div class="row-fluid">

        <div class="span4 side-grid uvdesk-sidebox-ticket-info">
            <div class="ty-sidebox">
                <h2 class="ty-sidebox__title cm-combination  open" id="sw_sidebox_32">
                    <span class="ty-sidebox__title-wrapper hidden-phone">{__("ticket_information")}</span>
                    <span class="ty-sidebox__title-wrapper visible-phone">{__("ticket_information")}</span>
                    <span class="ty-sidebox__title-toggle visible-phone">
                        <i class="ty-sidebox__icon-open ty-icon-down-open"></i>
                        <i class="ty-sidebox__icon-hide ty-icon-up-open"></i>
                    </span>
                </h2>
                <div class="ty-sidebox__body" id="">
                    {include file="addons/cscart_uvdesk/views/uvdesk_dashboard/components/sidebox_ticket_info.tpl"}
                </div>
            </div>
        </div> 

        <div class="span12 main-content-grid uvdesk-ticket-view">
            <h2>{$ticket.subject}</h2>

            <div class="uvdesk-ticket-strip">
                <span class="uvdesk-ticket-strip-label">Created</span> - {$ticket.ticket_date} <span class="uvdesk-ticket-strip-label">By</span> - {$ticket.ticket_creater} <span class="uvdesk-ticket-strip-label">Agent</span> - {$ticket.agent}
            </div>
            <hr class="uvdesk-hr" />

            <div>
                <div>
                    {$ticket.ticket_date} - {$ticket.ticket_creater} <span class="uvdesk-ticket-strip-label">created Ticket</span>
                </div>
            </div>

            <div class="uvdesk-thread-box" style="margin-left: 0px;">
                <table>
                    <tr>
                    <td style="width: 5%;vertical-align: baseline;">
                        <img src="{$customer.smallThumbnail}"  width="45" height="45" alt="" title=""> 
                    </td>
                    <td>
                        <div class="inline-block uvdesk-thread-message-con">
                            <span class="uvdesk-ticket-creater">{$ticket.ticket_creater}</span>
                            <div class="uvdesk-main-reply"> 
                                <span>{$ticket.ticket_msg nofilter}</span>
                            </div>
                            {if $ticket.ticket_attachment}
                                <div class="uvdesk-attachment">
                                <div class="uvdesk-uploaded-file">{__("uploaded_files")}</div>
                                {foreach from=$ticket.ticket_attachment key=key item=value}
                                    {include file="addons/cscart_uvdesk/views/uvdesk_dashboard/components/attachment_icon.tpl" icon_text="`$value.contentType`" icon_link="uvdesk_dashboard.download_attachment&attachment_id=`$value.id`"}
                                {/foreach}
                                </div>
                            {/if}
                        </div>
                    </td>
                </table>
            </div>

            {if $ticket.total_left}
            <div class="uvdesk-ticket-count-wrapper">
                <span class="uvdesk-ticket-count-stat uvdesk-more">{$ticket.total_left}</span>
            </div>
            {else}
                <hr class="uvdesk-hr" />
            {/if}
            {for $i=$ticket.total_page to 1 step -1}
                <div id="test_target_{$i}">
                </div>
            {/for}
            {include file="addons/cscart_uvdesk/views/uvdesk_dashboard/components/threads_view.tpl"}    
           
            <table style="margin-left: 20px;">
                <tr>
                    <td style="width: 5%;vertical-align: baseline;">
                        <img src="{$customer.smallThumbnail}"  width="40" height="40" alt="" title=""> 
                    </td>
                    <td style="width:100%">
                        <div class="inline-block uvdesk-thread-message-con" style="width:100%"> 
                        <span class="uvdesk-ticket-creater">{$reply_memeber.name}</span> 
                        <form name="ticket_reply" action="{""|fn_url}" method="post" enctype="multipart/form-data" id="reply_form">
                            <div class="control-group" style="margin-top: 10px;">
                                <label class="control-label cm-required" for="elm_product_promo_text" style="width:11%">{__("write_a_reply")}</label>
                                <div class="controls" style="margin-top: 10px;">
                                    <input class="hidden" name="ticket_id" value="{$ticket.ticket_id}">
                                    <input class="hidden" name="email" value="{$reply_memeber.email}">
                                    <input class="hidden" name="redirect_url" value="{"`$c_url`#reply_form"}">
                                    <textarea id="elm_product_promo_text" name="message" cols="55" rows="2" class="cm-wysiwyg input-large"></textarea>
                                    <div class="ty-control-group">
                                        <div class="form-group ">
                                            <div class="">
                                                <span class="btn uvdesk-btn-success uvdesk-fileinput-button" style="padding: 5px;">
                                                <span>Select file</span>
                                                <input id="attachments" name="attachments[]" infolabel="right" infolabeltext="+ Attach File" decoratefile="decorateFile" decoratecss="attach-file" enableremoveoption="enableRemoveOption" multiple="true" class="fileHide" type="file">
                                            </div>
                                        </div>
                                    </div>
                                    <span id="filelist" style="display:none;"></span>
                                    <br>
                                     {include file="buttons/button.tpl" but_text=__("reply") but_role="submit-link" but_name="dispatch[uvdesk_dashboard.ticket_reply]" but_meta="uvdesk-reply-button" but_target_form="ticket_reply"  save=$id}
                                </div>
                            </div>
                        </form>
                        </div>
                    </td>
                <tr>
            </table>

        </div>

    </div>   
</div>
{capture name="mainbox_title"}
{__("view_ticket")}
{/capture}

<script type="text/javascript">
    document.getElementById('attachments').addEventListener('change', function(e) {
        var list = document.getElementById('filelist');
        list.innerHTML = '';
        for (var i = 0; i < this.files.length; i++) {
            list.innerHTML += this.files[i].name + ', \n';
        }
        if (list.innerHTML == '') list.style.display = 'none';
        else list.style.display = 'block';
    });

    (function(_, $) {
        $('.uvdesk-more').on('click',function(){
            var next = $('#next').val();
            if(!next){
                next = {$ticket.total_page};
            }
            var n = next - 1;
            $.ceAjax('request', fn_url('uvdesk_dashboard.load_more&ticket_id={$ticket.ticket_id}&page='+next),
            {
                caching: true,
                result_ids: 'test_target_'+n,
                callback: function(data) {
                    if(data.total_threads > 0){
                        $('.uvdesk-more').html(data.total_threads);
                    }else{
                        $('.uvdesk-more').remove();
                    }
                }
            });
        });
    })(Tygh,Tygh.$);

</script>
