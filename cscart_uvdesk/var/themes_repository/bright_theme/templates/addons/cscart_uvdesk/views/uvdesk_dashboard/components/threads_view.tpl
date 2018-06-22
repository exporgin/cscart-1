<input type="hidden" value={$next} id='next'>
{if $threads_arr}
{foreach from=$threads_arr item=thread}
<div class="uvdesk-ticket-main" id="{$thread.id}">
    <div class="well-sm uvdesk-replied-msg-head">
        <div class="">
            {$thread.formatedCreatedAt}- {$thread.name} <span style="color: #9E9E9E;">replied</span>- #{$thread.id}
        </div>
        <div class="uvdesk-thread-box">
            <table>
                <tr>
                <td style="width: 5%;vertical-align: baseline;">
                    <img src="{$thread.smallThumbnail}"  width="40" height="40" alt="" title=""> 
                </td>
                <td>                        
                    <div class="inline-block uvdesk-thread-message-con">
                        <span class="uvdesk-ticket-creater">{$thread.name}</span> <span class="uvdesk-badge">{$thread.userType}</span>
                        <div class="uvdesk-main-reply"> 
                            {$thread.reply nofilter}
                        </div>
                        {if $thread.attachments}
                            <div class="uvdesk-attachment">
                            <div class="uvdesk-uploaded-file">{__("uploaded_files")}</div>
                            {foreach from=$thread.attachments key=key item=value}
                                {include file="addons/cscart_uvdesk/views/uvdesk_dashboard/components/attachment_icon.tpl" icon_text="`$value.contentType`" icon_link="uvdesk_dashboard.download_attachment&attachment_id=`$value.id`"}
                            {/foreach}
                            </div>
                        {/if}
                    </div>
                </td>
                </tr>
            </table>
        </div>
    </div>
</div>
{/foreach}
{/if}
