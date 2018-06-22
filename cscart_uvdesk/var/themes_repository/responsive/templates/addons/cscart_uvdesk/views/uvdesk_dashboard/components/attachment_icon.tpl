{if $icon_text}
    {assign var=icon_text_values value="/"|explode:$icon_text}
    {if $icon_text_values.1}
        {assign var=icon_text value=$icon_text_values.1}
    {/if}
{else}
    {$icon_text="File"}
{/if}
{if $icon_link}
    {assign var="icon_link" value=$icon_link|fn_url}
{else}
    {assign var="icon_link" value=""|fn_url}    
{/if}
<a href="{$icon_link}" target="_blank">
    <span class="fa-stack fa-2x cm-tooltip">
        <i class="fa fa-file-o fa-stack-2x"></i>
        <strong class="fa-stack-1x uvdesk-file-text">{$icon_text|truncate:4:"":true}</strong>
    </span>
</a>