<div class="uvdesk-sidebox-content">
    <div class="uvdesk-sidebox-content-head">{__("total_replies")}</div>
    <i class="fa fa-reply" aria-hidden="true"></i> {$ticket.total_threads}
</div>
<div class="uvdesk-sidebox-content">
    <div class="uvdesk-sidebox-content-head">{__("uvdesk_timestamp")}</div>
    <i class="fa fa-clock-o" aria-hidden="true"></i> {$ticket.ticket_date}
</div>
<hr/>
<div class="uvdesk-sidebox-content">
    <div class="uvdesk-sidebox-content-head">{__("agent")}</div>
    {$ticket.agent}
</div>
<div class="uvdesk-sidebox-content">
    <div class="uvdesk-sidebox-content-head">{__("status")}</div>
    {$ticket.status}
</div>
<div class="uvdesk-sidebox-content">
    <div class="uvdesk-sidebox-content-head">{__("type")}</div>
    {$ticket.type}
</div>
<hr class="uvdesk-hr">
<div class="uvdesk-sidebox-content">
    <div class="uvdesk-sidebox-content-head">Collaborators</div>
    <input id="add-collaborators" type="text">
    <div class="collaborator-list">
    {foreach from=$collaborators item=colab}
        <a class="uv-btn-tag" colabid="{$colab.id}"><span class="uv-tag"><i class="fa fa-close"></i>{$colab.email}</span></a>
    {/foreach}
    </div>
</div>


<script type="text/javascript">
    (function(_, $) {
        $('#add-collaborators').on('keyup',function(e){
            if (e.keyCode == 13) {
                var email = $(this).val();
                $.ceAjax('request', fn_url('uvdesk_dashboard.add_collaborators&ticket_id={$ticket.ticket_id}&email='+email),
                {
                    caching: false,
                    callback: function(data) {
                        if(data.id){
                            var i = data.id;
                            var a = '<a class="uv-btn-tag" colabid="'+i+'"><span class="uv-tag"><i class="fa fa-close"></i>'+email+'</span></a>';
                            $('.collaborator-list').append(a);
                            $('#add-collaborators').val('');
                        }
                    }
                });
            }
        });

        $('body').on('click', '.uv-btn-tag', function () {
            var th = $(this);
            var cid = th.attr('colabid');
            $.ceAjax('request',fn_url('uvdesk_dashboard.remove_collaborators&ticket_id={$ticket.ticket_id}&colab_id='+cid),{
                callback: function(data){
                    th.remove();
                }
            });
        });
    })(Tygh,Tygh.$);
</script>