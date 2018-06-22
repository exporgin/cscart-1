<div class="sidebar-row" id="status_label" style="">
    <div class="uvdesk-assign-agent-aside">
        <h4>{__("agent")}</h4>
        {if $all_privileges || ($privileges && in_array('ROLE_AGENT_ASSIGN_TICKET',$privileges))}
        <span>
            <div class="controls">
                <input type="hidden" name="agent_data[]" id="agent_add" value=""/>
                <div class="dropdown agent-change-dropdown">
                    <button class="btn uvdesk-dropdown-box-w dropdown-toggle" type="button" data-toggle="dropdown"><span id="agent-change">{$ticket_arr.agent}</span> <span class="caret"></span></button>
                    <ul class="dropdown-menu uvdesk-dropdown-box-w">
                        {foreach from=$agents item=agent}
                            <li id="{$agent.id}" class="uvdesk-change-sidebox-dropdown uvdesk-change-agent">
                                {$agent.name}
                            </li>
                        {/foreach}
                        <li></li>
                    </ul>
                </div>
            </div>
        <span>
        {else}
            {$ticket_arr.agent}
        {/if}
    </div>
    <div class="uvdesk-assign-priority-aside">
        <h4>{__("priority")}</h4>
        {if $all_privileges || ($privileges && in_array('ROLE_AGENT_UPDATE_TICKET_PRIORITY',$privileges))}        
        <span>
            <div class="dropdown priority-change-dropdown">
            <button class="btn uvdesk-dropdown-box-w  dropdown-toggle" type="button" data-toggle="dropdown"><span id="priority-change">{$ticket_arr.priority}</span> <span class="caret"></span></button>
            <ul class="dropdown-menu uvdesk-dropdown-box-w" style="">
                {foreach from=$priority_arr item=priority}
                    <li id="{$priority.id}" class="uvdesk-change-sidebox-dropdown uvdesk-change-priority">
                        {$priority.name}
                    </li>
                {/foreach}
                <li></li>
            </ul>
            </div>
        <span>
        {else}
            {$ticket_arr.priority}
        {/if}
    </div>
    <div>
        <h4>{__("status")}</h4>
        {if $all_privileges || ($privileges && in_array('ROLE_AGENT_UPDATE_TICKET_STATUS',$privileges))}        
        <span>
            <div class="dropdown status-change-dropdown">
            <button class="btn uvdesk-dropdown-box-w  dropdown-toggle " type="button" data-toggle="dropdown"><span id="status-change">{$ticket_arr.status}</span>
            <span class="caret"></span></button>
            <ul class="dropdown-menu uvdesk-dropdown-box-w" style="">
                {foreach from=$status_arr item=status}
                    <li id="{$status.id}" class="uvdesk-change-sidebox-dropdown uvdesk-change-status">
                        {$status.name}
                    </li>
                {/foreach}
                <li></li>
            </ul>
            </div>
        </span>
        {else}
            {$ticket_arr.status}
        {/if}
    </div>
    <div class="uvdesk-type-aside">
        <h4>{__("type")}</h4>
        {if $all_privileges || ($privileges && in_array('ROLE_AGENT_UPDATE_TICKET_TYPE',$privileges))}        
        <span>
            <div class="dropdown type-change-dropdown">
            <button class="btn uvdesk-dropdown-box-w  dropdown-toggle " type="button" data-toggle="dropdown"><span class="type-change">{$ticket_arr.type}</span> <span class="caret"></span></button>
            <ul class="dropdown-menu uvdesk-dropdown-box-w" style="">
                {foreach from=$type_arr item=type}
                    <li id="{$type.id}" class="uvdesk-change-sidebox-dropdown uvdesk-change-type">
                        {$type.name}
                    </li>
                {/foreach}
                <li></li>
            </ul>
            </div>
        </span>
        {else}
            {$ticket_arr.type}
        {/if}
    </div>
</div>

<script type="text/javascript">
    (function(_, $) {
        $('.uvdesk-change-agent').on('click',function(){
            var agentId = $(this).attr('id');
            var agentName = $(this).html();
            $.ceAjax('request', fn_url('uvdesk_dashboard.updateAgent&agent_id='+agentId+'&ticket_id={$ticket_arr.ticket_id}'),
            {
                caching: false,
                result_ids: 'agent-change',
                callback: function(data) {
                    if(data.agent){
                        $('#agent-change').html(agentName);
                        $('.agent-change-dropdown').removeClass('open');
                    }
                }
            });
        });

        $('.uvdesk-change-priority').on('click',function(){
            var pId = $(this).attr('id');
            var pName = $(this).html();
            $.ceAjax('request', fn_url('uvdesk_dashboard.ticket_priority&priority_id='+pId+'&ticket_id={$ticket_arr.ticket_id}'),
            {
                caching: false,
                result_ids: 'priority-change',
                callback: function(data) {
                    if(data.priority){
                        $('#priority-change').html(pName);
                        $('.priority-change-dropdown').removeClass('open');
                    }
                }
            });
        });

        $('.uvdesk-change-status').on('click',function(){
            var sId = $(this).attr('id');
            var sName = $(this).html();
            $.ceAjax('request', fn_url('uvdesk_dashboard.ticket_status&status_id='+sId+'&ticket_id={$ticket_arr.ticket_id}'),
            {
                caching: false,
                result_ids: 'status-change',
                callback: function(data) {
                    if(data.status){
                        $('#status-change').html(sName);
                        $('.status-change-dropdown').removeClass('open');
                    }
                }
            });
        });

        $('.uvdesk-change-type').on('click',function(){
            var sId = $(this).attr('id');
            var sName = $(this).html();
            $.ceAjax('request', fn_url('uvdesk_dashboard.ticket_type&type_id='+sId+'&ticket_id={$ticket_arr.ticket_id}'),
            {
                caching: false,
                result_ids: 'type-change',
                callback: function(data) {
                    if(data.type){
                        $('#type-change').html(sName);
                        $('.type-change-dropdown').removeClass('open');
                    }
                }
            });
        });
    })(Tygh,Tygh.$);
</script>