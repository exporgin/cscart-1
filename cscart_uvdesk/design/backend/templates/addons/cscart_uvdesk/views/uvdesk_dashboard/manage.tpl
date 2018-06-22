
{capture name="mainbox"}
    {$c_url = $redirect_url|default:$config.current_url}
     <div class="ui-widget">
        <div class="uvdesk-header">
        </div>
        <div class="uvdesk-main">
                    {hook name="uvdesk_dashboard:label"}
                        {capture name="sidebar"}
                            {include file="addons/cscart_uvdesk/views/uvdesk_dashboard/components/label.tpl" }
                            {if $all_privileges || ($privileges && in_array('ROLE_AGENT_CREATE_TICKET',$privileges))}
                                {$id = "create_ticket_"}
                                <a id="opener_{$id}"  id="guest-follow" class="cm-dialog-opener cm-dialog-auto-size btn uvdesk-create-ticket" data-ca-target-id="content_{$id}"  rel="nofollow" ><i class="icon-plus-sign"></i> {__("create_ticket")}{$cat_total_followers}</a>
                                <div class="hidden" id="content_{$id}" title="{__("create_ticket")}">
                                    {include file="addons/cscart_uvdesk/views/uvdesk_dashboard/components/create_ticket_form.tpl"}
                                </div>
                            {/if}
                        {/capture}
                    {/hook} 
                    <div class="">
                        <form action="{""|fn_url}" method="post" name="tickets_form" id="tickets_form" class="">
                        <input type="hidden" name="redirect_url" value="{$c_url}"/>
                        {capture name="buttons"}
                            {if $all_privileges || ($privileges && in_array('ROLE_AGENT_DELETE_TICKET',$privileges))} 
                            {include file="addons/cscart_uvdesk/views/uvdesk_dashboard/components/delete_selected.tpl" but_name="dispatch[uvdesk_dashboard.t_delete]" but_role="submit-link" but_form="tickets_form" but_confirm="This will delete the ticket. It doesnt move the ticket to the trash." but_name_show=__("delete")}
                            {/if}
                        {/capture}
                        {include file="addons/cscart_uvdesk/views/uvdesk_dashboard/components/status_nav_bars.tpl" }
                        {include file="common/pagination.tpl" save_current_page=true save_current_url=true div_id=$smarty.request.content_id}                        
                        <table width="100%" class="table table-middle">
                            <thead>
                                <tr>
                                    <th  class="center">{include file="common/check_items.tpl" }</th>
                                    <th></th>
                                    <th  class="nowrap">Priority</th>
                                    <th >Ticket No.</th>
                                    <th >Customer Name</th>
                                    <th>Subject</th>
                                    <th>Created Date</th>
                                    <th >Replies</th>
                                    <th>Agent</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                                {if $tickets}
                                {foreach from=$tickets item=ticket}
                                    <tr>
                                        <td class="center"><input type="checkbox" name="ticket_ids[]" value="{$ticket.id}" class="checkbox cm-item" /></td>
                                        <td>
                                            <span class="star_reload" stid='{$ticket.id}'>
                                                {if $ticket.isStarred}
                                                    <i class="icon-star"></i>
                                                {else}
                                                    <i class="icon-star-empty"></i>
                                                {/if}
                                            </span>
                                        </td>
                                        <td>
                                            {if $ticket.Priority_Id == 1}
                                                <span class="badge background-green">Low</span>
                                            {else if $ticket.Priority_Id == 2}
                                                <span class="badge background-yellow">Medium</span>
                                            {else if $ticket.Priority_Id == 3}
                                                <span class="badge background-orange">High</span>
                                            {else if $ticket.Priority_Id == 4}
                                                <span class="badge background-red">Urgent</span>
                                            {/if}
                                        </td>
                                        <td><a href="{"uvdesk_dashboard.view_ticket&increment_id=`$ticket.Increment_Id`"|fn_url}">#{$ticket.Increment_Id}</a></td>
                                        <td>{$ticket.Cus_name|truncate:15:true:true}</td>
                                        <td>{$ticket.Subject|truncate:30:'..':true:true}</td>
                                        <td>{$ticket.date_added}</td>
                                        <td>{$ticket.Replies}</td>
                                        <td>
                                            {if $all_privileges || ($privileges && in_array('ROLE_AGENT_ASSIGN_TICKET',$privileges))}
                                            <span>
                                            <div class="controls">
                                                <input type="hidden" name="agent_data[]" id="agent_add" value=""/>
                                                <div class="dropdown agent-change-dropdown">
                                                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" ><span id="agent-change-{$ticket.id}">{$ticket.agent_name}</span> <span class="caret"></span></button>
                                                    <ul class="dropdown-menu">
                                                        {foreach from=$agents item=agent}
                                                            <li id="{$agent.id}" class="uvdesk-change-sidebox-dropdown uvdesk-change-agent" ticketid="{$ticket.id}">
                                                                {$agent.name}
                                                            </li>
                                                        {/foreach}
                                                        <li></li>
                                                    </ul>
                                                </div>
                                                
                                            </div>
                                            <span>
                                            {else}
                                                {$ticket.agent_name}
                                            {/if}
                                        </td>
                                        <td><a href="{"uvdesk_dashboard.view_ticket&increment_id=`$ticket.Increment_Id`"|fn_url}"><i class="icon-eye-open"></i> {_("view")}</a></td>
                                    </tr>
                                {/foreach}
                                {else}
                                    <tr class="items-container">
                                        <td  colspan="10"><p class="no-items">{__("text_no_ticket_found")}</p></td>
                                    </tr>
                                {/if}
                            </table>
                            <div class="clearfix">
                                {include file="common/pagination.tpl" div_id=$smarty.request.content_id}
                            </div>
                            </form>
                    </div>
        </div>
    </div>
{/capture}



{include file="common/mainbox.tpl" title=__("webkul_uvdesk") content=$smarty.capture.mainbox  sidebar=$smarty.capture.sidebar sidebar_position="left" adv_buttons=$smarty.capture.adv_buttons buttons=$smarty.capture.buttons select_languages=true content_id="manage_tickets"}

<script type="text/javascript">
    (function(_, $) {
        $('.uvdesk-change-agent').on('click',function(){
            var agentId = $(this).attr('id');
            var ticketId = $(this).attr('ticketid');
            var agentName = $(this).html();
            $.ceAjax('request', fn_url('uvdesk_dashboard.updateAgent&agent_id='+agentId+'&ticket_id='+ticketId),
            {
                caching: false,
                result_ids: 'agent-change-'+ticketId,
                callback: function(data) {
                    if(data.agent){
                        $('#agent-change-'+ticketId).html(agentName);
                        $('.agent-change-dropdown').removeClass('open');
                    }
                }
            });
        });

        $('.star_reload').on('click',function(){
            var star = $(this).children();
            var tid = $(this).attr('stid');
            var d = star.attr('class');
            $.ceAjax('request', fn_url('uvdesk_dashboard.ticket_starred&ticket_id='+tid),
            {
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