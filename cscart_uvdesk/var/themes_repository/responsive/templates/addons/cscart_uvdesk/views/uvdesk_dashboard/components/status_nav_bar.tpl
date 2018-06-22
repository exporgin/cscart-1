<div>
    <ul class="uvdesk-nav">
        <li class="uvdesk-nav-bars  {if $status_u == 1}uvdesk-active{/if}" style="">
		    <a class="nav-link " href="{"uvdesk_dashboard.manage?status=1"|fn_url}">
                <i class="fa fa-inbox"></i> {__('uvdesk_open')} <span class="uvdesk-label">{$tabs_status.1|default:0}</span>
		    </a>
	    </li>
        <li class="uvdesk-nav-bars  {if $status_u == 2}uvdesk-active{/if}" style="">
			<a class="nav-link {if $status_u == 2}active{/if}" href="{"uvdesk_dashboard.manage?status=2"|fn_url}">
				<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {__("uvdesk_pending")} <span class="uvdesk-label">{$tabs_status.2|default:0}</span>
			</a>
		</li>
        <li class="uvdesk-nav-bars  {if $status_u == 6}uvdesk-active{/if}" style="">
			<a class="nav-link {if $status_u == 6}active{/if}" href="{"uvdesk_dashboard.manage?status=6"|fn_url}">
				<i class="fa fa-lightbulb-o" aria-hidden="true"></i> Answered <span class="uvdesk-label">{$tabs_status.6|default:0}</span>
			</a>
		</li>
        <li class="uvdesk-nav-bars  {if $status_u == 3}uvdesk-active{/if}" style="">
			<a class="nav-link {if $status_u == 3}active{/if}" href="{"uvdesk_dashboard.manage?status=3"|fn_url}">
				<i class="fa fa-check-circle" aria-hidden="true"></i> Resolved <span class="uvdesk-label">{$tabs_status.3|default:0}</span>
			</a>
		</li>
        <li class="uvdesk-nav-bars  {if $status_u == 4}uvdesk-active{/if}" style="">
			<a class="nav-link {if $status_u == 4}active{/if}" href="{"uvdesk_dashboard.manage?status=4"|fn_url}">
				<i class="fa fa-minus-circle" aria-hidden="true"></i> Closed <span class="uvdesk-label">{$tabs_status.4|default:0}</span>
			</a>
		</li>
        <li class="uvdesk-nav-bars  {if $status_u == 5}uvdesk-active{/if}" style="">
			<a class="nav-link {if $status_u == 5}active{/if}" href="{"uvdesk_dashboard.manage?status=5"|fn_url}">
				<i class="fa fa-ban" aria-hidden="true"></i> Spam <span class="uvdesk-label">{$tabs_status.5|default:0}</span>
			</a>
		</li>
    </ul>
</div>