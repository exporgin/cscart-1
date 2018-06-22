
    {hook name="uvdesk_dashboard:manage_sidebar"}
        {if !$status_u}
            {assign var="status_u" value=1}
        {/if}
        <div class="sidebar-row" id="label" style="margin:0px">
            <h6>{__("uvdesk_label")}</h6>
            <ul class="unstyled sidebar-stat">
                <a href="{"uvdesk_dashboard.manage?label=all&status={$status_u}"|fn_url}" class="underlined"><li class="{if $label_u == 'all'}active-li{/if} uv-li-sidebar">{__("All")} <span class="uvdesk-sidebar-label">{$tabs_label.all}</span> </li></a>
                <a href="{"uvdesk_dashboard.manage?label=new&status={$status_u}"|fn_url}" class="underlined"><li class="{if $label_u == 'new'}active-li{/if} uv-li-sidebar">{__("New")} <span class="uvdesk-sidebar-label {if $label_u == 'new'}{/if}">{$tabs_label.new}</span></li></a>
                <a href="{"uvdesk_dashboard.manage?label=unassigned&status={$status_u}"|fn_url}" class="underlined"><li class="{if $label_u == 'unassigned'}active-li{/if} uv-li-sidebar">{__("uvdesk_unassigned")} <span class="uvdesk-sidebar-label {if $label_u == 'unassigned'}{/if}">{$tabs_label.unassigned}</span> </li></a>
                <a href="{"uvdesk_dashboard.manage?label=notreplied&status={$status_u}"|fn_url}" class="underlined"><li class="{if $label_u == 'notreplied'}active-li{/if} uv-li-sidebar">{__("uvdesk_notreplied")} <span class="uvdesk-sidebar-label {if $label_u == 'notreplied'}{/if}">{$tabs_label.notreplied}</span> </li></a>
                <a href="{"uvdesk_dashboard.manage?label=mine&status={$status_u}"|fn_url}" class="underlined"><li class="{if $label_u == 'mine'}active-li{/if} uv-li-sidebar"> {__("uvdesk_mine")} <span class="uvdesk-sidebar-label {if $label_u == 'mine'}{/if}">{$tabs_label.mine}</span> </li></a>
               <a href="{"uvdesk_dashboard.manage?label=starred&status={$status_u}"|fn_url}" class="underlined"><li class="{if $label_u == 'starred'}active-li{/if} uv-li-sidebar">{__("uvdesk_starred")} <span class="uvdesk-sidebar-label {if $label_u == 'starred'}{/if}">{$tabs_label.starred}</span> </li></a>
                <a href="{"uvdesk_dashboard.manage?label=trashed&status={$status_u}"|fn_url}" class="underlined"><li class="{if $label_u == 'trashed'}active-li{/if} uv-li-sidebar">{__("uvdesk_trashed")} <span class="uvdesk-sidebar-label {if $label_u == 'trashed'}{/if}">{$tabs_label.trashed}</span> </li></a>
            </ul>
        </div>
    {/hook}
