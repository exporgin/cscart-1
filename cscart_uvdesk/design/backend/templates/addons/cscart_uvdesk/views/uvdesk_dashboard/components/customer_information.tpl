<div class="sidebar-row" id="status_label" style="">
    <div class="uvdesk-customer-avtar-aside">
        <h4>{__("customer_information")}</h4>
        <div class="row-fluid">
                <span class="span2">
                    <img src="{$customer.smallThumbnail}"  width="30" height="30" alt="" title="">
                </span>
                <span class="span10">
                    <span>{$customer.name}</span>
                    <span style="word-break: break-word;">{$customer.email}</span>
                </span>
        </div>
    </div>
    <div class="uvdesk-total-replies-aside" >
        <h4>{__("total_replies")}</h4>
        <i class="icon-reply"></i> {$ticket_arr.total_threads}        
    </div>
    <div class="uvdesk-timestamp-aside" >
        <h4>{__("timestamp")}</h4>
        <i class="fa fa-clock-o" aria-hidden="true"></i> {$ticket_arr.ticket_date}        
    </div>
</div>