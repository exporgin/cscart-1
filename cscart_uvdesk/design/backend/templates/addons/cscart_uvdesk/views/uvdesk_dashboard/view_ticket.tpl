{capture name="mainbox"}
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    {$c_url = $redirect_url|default:$config.current_url}
    {assign var=id value=0}
    
    {assign var=ticket_attachment value=$ticket_arr.ticket_attachment}
     <div class="ui-widget">
        <div class="uvdesk-header">
            Ticket View
        </div>
        <div class="uvdesk-main">
            {hook name="uvdesk_dashboard:label"}
                {capture name="sidebar"}
                    {include file="addons/cscart_uvdesk/views/uvdesk_dashboard/components/customer_information.tpl" }
                    {include file="addons/cscart_uvdesk/views/uvdesk_dashboard/components/ticket_manage.tpl" }
                    {include file="addons/cscart_uvdesk/views/uvdesk_dashboard/components/label.tpl" }
                {/capture}
            {/hook}                    
            <div class="">
                <div class="vtt-header-top">
                    <span id="star_reload">
                        {if $ticket_arr.isStarred}
                            <i class="icon-star" id="uvdesk-star"></i>
                        {else}
                            <i class="icon-star-empty" id="uvdesk-star"></i>
                        {/if}
                    </span>
                    <span>{$ticket_arr.increment_id} {$ticket_arr.subject}</span>
                </div>
                <div class="vtt-header-bottom">
                     <span class="label label-info uvdesk-h-label" title="" data-toggle="tooltip" data-original-title="Status">{$ticket_arr.status}</span>
                     {if $ticket_arr.Priority_Id == 1}
                         <span class="label uvdesk-h-label background-green">Low</span>
                     {else if $ticket_arr.Priority_Id == 2}
                         <span class="label uvdesk-h-label background-yellow">Medium</span>
                     {else if $ticket_arr.Priority_Id == 3}
                         <span class="label uvdesk-h-label background-orange">High</span>
                     {else if $ticket_arr.Priority_Id == 4}
                         <span class="label uvdesk-h-label background-red">Urgent</span>
                     {/if}
                      <span class="label uvdesk-h-label label-info" title="" data-toggle="tooltip" data-original-title="Type">{$ticket_arr.type}</span>
                    <span class="label uvdesk-h-label label-info" title="" data-toggle="tooltip" data-original-title="Threads">{$ticket_arr.total_threads}</span>
                    <span class="label uvdesk-h-label label-success" title="" data-toggle="tooltip" data-original-title="Agent">{$ticket_arr.agent} </span>                    
                </div>
            </div>

            <div class="margin-top-15px">
                <div>
                    {$ticket_arr.ticket_date}- {$ticket_arr.ticket_creater} <span style="color: #9E9E9E;">created Ticket</span>
                </div>
                <div class="uvdesk-thread-box">
                    <table>
                        <tr>
                        <td style="width: 5%;vertical-align: baseline;">
                            <img src="{$customer.smallThumbnail}"  width="45" height="45" alt="" title=""> 
                        </td>
                        <td>
                            <div class="inline-block uvdesk-thread-message-con">
                                <span class="bold">{$ticket_arr.ticket_creater}</span>
                                <div class="main-reply"> 
                                    {$ticket_arr.ticket_msg nofilter}
                                </div>
                                {if $ticket_attachment}
                                    <div class="uvdesk-attachment">
                                    <div class="strong">{__("uploaded_files")}</div>
                                    {foreach from=$ticket_attachment key=key item=value}
                                        {include file="addons/cscart_uvdesk/views/uvdesk_dashboard/components/attachment_icon.tpl" icon_text="`$value.contentType`" icon_link="uvdesk_dashboard.download_attachment&attachment_id=`$value.id`"}
                                    {/foreach}
                                    </div>
                                {/if}
                            </div>
                        </td>
                    </table>
                </div>
            </div>

            {if $ticket_arr.total_left}
            <div class="uvdesk-ticket-count-wrapper">
                <span class="uvdesk-ticket-count-stat uvdesk-more">{$ticket_arr.total_left}</span>
            </div>
            {else}
                <hr class="uvdesk-hr" />
            {/if}
            {for $i=$ticket_arr.total_page to 1 step -1}
                <div id="threads_more_{$i}">
                </div>
            {/for}
            {include file="addons/cscart_uvdesk/views/uvdesk_dashboard/components/threads_view.tpl"}    

            <table style="margin-left: 2.5em;">
            <tr>
            <td style="width: 5%;vertical-align: baseline;">
                <img src="{$ticket_arr.agent_thumbnail}"  width="40" height="40" alt="" title=""> 
            </td>
            <td style="width:100%">
                <div class="inline-block uvdesk-thread-message-con" style="width:100%"> 
                <span class="bold">{$agent_info.name}</span> 
                <form name="ticket_reply" action="{""|fn_url}" method="post" enctype="multipart/form-data">
                    <div class="control-group {$no_hide_input_if_shared_product}">
                        <label class="control-label cm-required" for="elm_product_promo_text" style="width:9%">{__("write_a_reply")}</label>
                        <div class="controls">
                            <input class="hidden" name="ticket_id" value="{$ticket_arr.ticket_id}">
                            <input class="hidden" name="email" value="{$agent_info.email}">
                            <input class="hidden" name="redirect_url" value="{$c_url}">
                            <textarea id="elm_product_promo_text" name="message" cols="55" rows="2" class="cm-wysiwyg input-large"></textarea>
                            <div class="ty-control-group">
                                <div class="form-group ">
                                    <div class="">
                                        <span class="btn btn-success fileinput-button">
                                        <span>Select file</span>
                                        <input id="attachments" name="attachments[]" infolabel="right" infolabeltext="+ Attach File" decoratefile="decorateFile" decoratecss="attach-file" enableremoveoption="enableRemoveOption" multiple="true" class="fileHide" type="file">
                                    </div>
                                </div>
                            </div>
                            <span id="filelist" style="display:none;"></span>
                            <br>
                            {include file="buttons/button.tpl" but_text=__("reply") but_role="submit-link" but_name="dispatch[uvdesk_dashboard.ticket_reply]"  but_target_form="ticket_reply" save=$id}
                        </div>
                    </div>
                </form>
                </div>
            </td>
            <tr>
            </table>
        </div>
    </div>
{/capture}



{include file="common/mainbox.tpl" title=__("webkul_uvdesk") content=$smarty.capture.mainbox  sidebar=$smarty.capture.sidebar adv_buttons=$smarty.capture.adv_buttons buttons=$smarty.capture.buttons select_languages=true content_id="view_ticket" sidebar_position="left"}


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
                next = {$ticket_arr.total_page};
            }
            var n = next - 1;
            $.ceAjax('request', fn_url('uvdesk_dashboard.load_more&ticket_id={$ticket_arr.ticket_id}&page='+next),
            {
                caching: false,
                result_ids: 'threads_more_'+n,
                callback: function(data) {
                    if(data.total_threads > 0){
                        $('.uvdesk-more').html(data.total_threads);
                    }else{
                        $('.uvdesk-more').remove();
                    }
                }
            });
        });

        $('#star_reload').on('click',function(){
            var star = $(this).children();
            var d = star.attr('class');
            $.ceAjax('request', fn_url('uvdesk_dashboard.ticket_starred&ticket_id={$ticket_arr.ticket_id}'),
            {
                caching: false,
                result_ids: 'star_reload',
                callback: function(data) {
                    if(d == 'icon-star-empty'){
                        star.removeClass('icon-star-empty');
                        star.addClass('icon-star');
                    }
                    if(d == 'icon-star'){
                        star.removeClass('icon-star');
                        star.addClass('icon-star-empty');
                    }
                }
            });
        });
    })(Tygh,Tygh.$);

</script>