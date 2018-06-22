
{if !$config.tweaks.disable_dhtml}
    {assign var="ajax_class" value="cm-ajax"}
{/if}
{$c_url = $redirect_url|default:$config.current_url}
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
{include file="addons/cscart_uvdesk/views/uvdesk_dashboard/components/status_nav_bar.tpl"}
{include file="common/pagination.tpl" id="uvdesk_manage_id"}   
<table class="ty-table ty-orders-search">
    <thead>
        <tr>
            <th><a class="{$ajax_class}" href="{"`$c_url`&sort_by=order_id&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("ticket_id")}</a>{if $search.sort_by == "order_id"}{$sort_sign nofilter}{/if}</th>
            <th><a class="{$ajax_class}" href="{"`$c_url`&sort_by=status&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("subject")}</a>{if $search.sort_by == "status"}{$sort_sign nofilter}{/if}</th>
            <th><a class="{$ajax_class}" href="{"`$c_url`&sort_by=date&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("timestamp")}</a>{if $search.sort_by == "date"}{$sort_sign nofilter}{/if}</th>
            <th><a class="{$ajax_class}" href="{"`$c_url`&sort_by=total&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("agent")}</a>{if $search.sort_by == "total"}{$sort_sign nofilter}{/if}</th>
            <th>{__("action")}</th>
        </tr>
    </thead>
    {foreach from=$tickets item="ticket"}
        <tr>
            <td class="ty-orders-search__item"><a href="{"uvdesk_dashboard.view_ticket&increment_id=`$ticket.incrementId`#reply_form"|fn_url}"><strong>#{$ticket.incrementId}</strong></a></td>
            <td class="ty-orders-search__item">{$ticket.subject|truncate:50:'..':true:true}</td>
            <td class="ty-orders-search__item">{$ticket.formatedCreatedAt}</td>
            <td class="ty-orders-search__item"><img src="{$ticket.agent_smallThumbnail}"  width="35" height="35" alt="" title=""> {$ticket.agent}</td>
            <td class="ty-orders-search__item">
                <a href="{"uvdesk_dashboard.view_ticket&increment_id=`$ticket.incrementId`#reply_form"|fn_url}" class=""><i class="fa fa-eye" aria-hidden="true"></i> {_("view")}</a>
            </td>
        </tr>
    {foreachelse}
        <tr class="ty-table__no-items">
            <td colspan="7"><p class="ty-no-items">{__("text_no_ticket_found")}</p></td>
        </tr>
    {/foreach}
</table>
{include file="common/pagination.tpl" id="uvdesk_manage_id"}   
{capture name="mainbox_title"}
{__("ticket_list")}
<span class="uvdesk-create-ticket">
        <a  href="{"uvdesk_dashboard.customer_create_ticket"|fn_url}"class="ty-btn ty-btn__primary"  rel="nofollow" >{__("create_ticket")}</a>
</span>
{/capture}