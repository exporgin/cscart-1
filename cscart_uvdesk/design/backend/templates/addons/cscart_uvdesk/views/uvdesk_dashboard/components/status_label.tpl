
    {hook name="uvdesk_dashboard:manage_sidebar"}
        <div class="sidebar-row" id="status_label" style="margin:0px">
            <h6>{__("Status")}</h6>
            <ul class="unstyled sidebar-stat">
                <a href="{"uvdesk_dashboard.manage?status=1"|fn_url}" class="underlined"><li class="{if $status_u == 1}active-li{/if}"><span class="label uvdesk-sidebar-label {if $status_u == 1}uvdesk-active-badge-li{/if}">{$tabs_status.1}</span> {__('uvdesk_open')}</li></a>
                <a href="{"uvdesk_dashboard.manage?status=2"|fn_url}" class="underlined"><li class="{if $status_u == 2}active-li{/if}"><span class="label uvdesk-sidebar-label {if $status_u == 2}uvdesk-active-badge-li{/if}">{$tabs_status.2}</span> {__("uvdesk_pending")}</li></a>
                <a href="{"uvdesk_dashboard.manage?status=6"|fn_url}" class="underlined"><li class="{if $status_u == 6}active-li{/if}"><span class="label uvdesk-sidebar-label {if $status_u == 6}uvdesk-active-badge-li{/if}">{$tabs_status.6}</span> {__("uvdesk_answered")}</li></a>
                <a href="{"uvdesk_dashboard.manage?status=3"|fn_url}" class="underlined"><li class="{if $status_u == 3}active-li{/if}"><span class="label uvdesk-sidebar-label {if $status_u == 3}uvdesk-active-badge-li{/if}">{$tabs_status.3}</span> {__("uvdesk_resolved")}</li></a>
                <a href="{"uvdesk_dashboard.manage?status=4"|fn_url}" class="underlined"><li class="{if $status_u == 4}active-li{/if}"><span class="label uvdesk-sidebar-label {if $status_u == 4}uvdesk-active-badge-li{/if}">{$tabs_status.4}</span> {__("uvdesk_closed")}</li></a>
                <a href="{"uvdesk_dashboard.manage?status=5"|fn_url}" class="underlined"><li class="{if $status_u == 5}active-li{/if}"><span class="label uvdesk-sidebar-label {if $status_u == 5}uvdesk-active-badge-li{/if}">{$tabs_status.5}</span> {__("uvdesk_spam")}</li></a>
            </ul>
        </div>
    {/hook}
