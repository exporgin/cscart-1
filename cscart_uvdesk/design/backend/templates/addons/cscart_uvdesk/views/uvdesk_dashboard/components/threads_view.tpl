<input type="hidden" value={$next} id='next'>
{foreach from=$threads_arr key=key item=thread}            
<div class="" id="{$thread.id}">
    <div class="well-sm replied-msg-head">
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
                    <span class="bold">{$thread.name}</span> <span class="badge">{$thread.userType}</span>
                    <div class="main-reply"> 
                        {$thread.reply nofilter}
                    </div>
                    {if $thread.attachments}
                        <div class="uvdesk-attachment">
                        <div class="strong">{__("uploaded_files")}</div>
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
<hr class="uvdesk-hr"/>
{/foreach}