<div>
    <ul class="nav nav-tabs">
        <li class="nav-item uvdesk-nav-bars {if $status_u == 1}active{/if}" style="">
		    <a class="nav-link {if $status_u == 1}active{/if}" href="{"uvdesk_dashboard.manage?status=1&label=`$label_u`"|fn_url}">
                <i class="icon-inbox"></i>{__('uvdesk_open')} <span class="label label-primary">{$tabs_status.1}</span>
		    </a>
	    </li>
        <li class="nav-item uvdesk-nav-bars {if $status_u == 2}active{/if}" style="">
			<a class="nav-link {if $status_u == 2}active{/if}" href="{"uvdesk_dashboard.manage?status=2&label=`$label_u`"|fn_url}">
				<i class="icon-exclamation-sign"></i>{__("uvdesk_pending")} <span class="label label-default">{$tabs_status.2}</span>
			</a>
		</li>
        <li class="nav-item uvdesk-nav-bars {if $status_u == 6}active{/if}" style="">
			<a class="nav-link {if $status_u == 6}active{/if}" href="{"uvdesk_dashboard.manage?status=6&label=`$label_u`"|fn_url}">
				<i class="icon-lightbulb"></i>Answered <span class="label label-default">{$tabs_status.6}</span>
			</a>
		</li>
        <li class="nav-item uvdesk-nav-bars {if $status_u == 3}active{/if}" style="">
			<a class="nav-link {if $status_u == 3}active{/if}" href="{"uvdesk_dashboard.manage?status=3&label=`$label_u`"|fn_url}">
				<i class="icon-ok-circle"></i>Resolved <span class="label label-default">{$tabs_status.3}</span>
			</a>
		</li>
        <li class="nav-item uvdesk-nav-bars {if $status_u == 4}active{/if}" style="">
			<a class="nav-link {if $status_u == 4}active{/if}" href="{"uvdesk_dashboard.manage?status=4&label=`$label_u`"|fn_url}">
				<i class="icon-minus-sign"></i>Closed <span class="label label-default">{$tabs_status.4}</span>
			</a>
		</li>
        <li class="nav-item uvdesk-nav-bars {if $status_u == 5}active{/if}" style="">
			<a class="nav-link {if $status_u == 5}active{/if}" href="{"uvdesk_dashboard.manage?status=5&label=`$label_u`"|fn_url}">
				<i class="icon-ban-circle"></i>Spam <span class="label label-default">{$tabs_status.5}</span>
			</a>
		</li>
    </ul>
</div>