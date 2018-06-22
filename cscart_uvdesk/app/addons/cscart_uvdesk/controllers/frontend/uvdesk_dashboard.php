<?php
use Tygh\Registry;
use Tygh\Tools\Url;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if($mode == 'manage'){

    if (AREA == 'C') {
        $_REQUEST['user_id'] = $auth['user_id'];
    }

    if (empty($_REQUEST['user_id'])) {
        if (AREA == 'C') {
            return array(CONTROLLER_STATUS_REDIRECT, 'auth.login_form?return_url=' . urlencode(Registry::get('config.current_url')));
        } else {
            return array(CONTROLLER_STATUS_NO_PAGE);
        }
    }

    $tickets = array();
    fn_add_breadcrumb(__('uvdesk_tickets'));
    $user_data = fn_get_user_short_info($auth['user_id']);
    if(isset($user_data['user_type'])){
        $customer_id = json_decode(fn_uvdesk_get_customer_id($user_data['email']),true);
        if(isset($customer_id['customers'][0]['id'])){
            $_SESSION['uvdesk_customer'] = $customer_id['customers'][0];
            $_REQUEST['customer'] = $customer_id['customers'][0]['id'];
            $tickets_data = json_decode(fn_uvdesk_get_ticket_list(), TRUE); 
            $tabs_status = $tickets_data['tabs'];  //counts of the status sidebar 
            foreach($tickets_data['tickets'] as $key => $ticket){
                $t = array(
                    'incrementId' => $ticket['incrementId'],
                    'subject' => $ticket['subject'],
                    'type' => $ticket['type'],
                    'formatedCreatedAt' => $ticket['formatedCreatedAt'],
                    'agent' => $ticket['agent']['name'],
                    'agent_smallThumbnail' => isset($ticket['agent']['smallThumbnail'])?$ticket['agent']['smallThumbnail']:"design/backend/media/images/addons/cscart_uvdesk/uvdesk.png",
                );
                $tickets[] = $t;
            }
            $search = array(
                'page' => $tickets_data['pagination']['current'],
                'items_per_page' => $tickets_data['pagination']['numItemsPerPage'],
                'total_items' => $tickets_data['pagination']['totalCount'],
            );
            Registry::get('view')->assign('tabs_status',$tabs_status);
            Registry::get('view')->assign('customer_info',$_SESSION['uvdesk_customer']);
            Registry::get('view')->assign('types',$tickets_data['type']);           
            Registry::get('view')->assign('search',$search);           
            Registry::get('view')->assign('tickets',$tickets);
            Registry::get('view')->assign('status_u',isset($_REQUEST['status'])?$_REQUEST['status']:"1");            
        }
    }
}

if($mode == 'view_ticket'){
    if (AREA == 'C') {
        $_REQUEST['user_id'] = $auth['user_id'];
    }
    $collaborators = array();
    if (empty($_REQUEST['user_id'])) {
        if (AREA == 'C') {
            return array(CONTROLLER_STATUS_REDIRECT, 'auth.login_form?return_url=' . urlencode(Registry::get('config.current_url')));
        } else {
            return array(CONTROLLER_STATUS_NO_PAGE);
        }
    }
    fn_add_breadcrumb(__('uvdesk_tickets'), "uvdesk_dashboard.manage");
    fn_add_breadcrumb(__('uvdesk_viewticket'));
    
    if(isset($_REQUEST['increment_id']) && isset($_SESSION['uvdesk_customer'])){
        $ticket = json_decode(fn_uvdesk_getTicket(),true);
        $ticket_arr = array(
            'ticket_id' => $ticket['ticket']['id'],
            'increment_id'=> $ticket['ticket']['incrementId'],
            'subject'=> $ticket['ticket']['subject'],
            'status'=>$ticket['ticket']['status']['name'],
            'type'=>!empty($ticket['ticket']['type']['name'])?$ticket['ticket']['type']['name']:"",
            'total_threads'=>$ticket['ticketTotalThreads'],
            'agent'=>($ticket['ticket']['agent'] != null)?$ticket['ticket']['agent']['detail']['agent']['name']:"undefined",
            'ticket_creater'=>$ticket['createThread']['fullname'],
            'ticket_msg'=>$ticket['createThread']['reply'],
            'ticket_attachment'=>!empty($ticket['createThread']['attachments'])?json_decode(json_encode($ticket['createThread']['attachments']), TRUE):array(),
            'ticket_date'=>$ticket['createThread']['createdAt']['date'],
            'agent_thumbnail'=>isset($ticket['agent']['smallThumbnail'])?$ticket['agent']['smallThumbnail']:" https://cdn.uvdesk.com/uvdesk/images/163b0ed.png",
        );
        $customer = array(
            'name' => isset($ticket['ticket']['customer']['detail']['customer']['name'])?$ticket['ticket']['customer']['detail']['customer']['name']:"",
            'isActive' => $ticket['ticket']['customer']['detail']['customer']['isActive'],
            'email' => !empty($ticket['ticket']['customer']['email'])?$ticket['ticket']['customer']['email']:"*****",
            'smallThumbnail' => !empty($ticket['ticket']['customer']['smallThumbnail'])?$ticket['ticket']['customer']['smallThumbnail']:"design/backend/media/images/addons/cscart_uvdesk/uvdesk.png",
        );
        foreach($ticket['ticket']['collaborators'] as $key => $colab){
            $c = array(
                'id'=>$colab['id'],
                'email'=>$colab['email']
            ); 
            $collaborators[] = $c;
        }
        if(isset($_REQUEST['page'])){
            $page = $_REQUEST['page'];
        }else{
            $page = 1;
        }
        $threads = json_decode(fn_uvdesk_getAllThreads($ticket['ticket']['id'],$page),true);
    
        $threads_arr = array(); 
        $thread = array();
        foreach($threads['threads'] as $key=>$value){
            $thread = array(
                'id'=>$value['id'],
                'reply'=>$value['reply'],
                'userType'=>$value['userType'],
                'formatedCreatedAt'=>$value['formatedCreatedAt'],
                'userId'=>$value['user']['id'],
                'name'=>$value['fullname'],
                'attachments'=>$value['attachments'],
                'smallThumbnail'=>isset($value['user']['smallThumbnail'])?$value['user']['smallThumbnail']:"design/backend/media/images/addons/cscart_uvdesk/uvdesk.png",
            );
            $threads_arr[] = $thread;
        }
        $total_threads_load = ($threads['pagination']['current']*$threads['pagination']['numItemsPerPage']);
        if($threads['pagination']['totalCount'] > $total_threads_load){
            $total_left = $threads['pagination']['totalCount'] - $total_threads_load;
        }else{
            $total_left = 0;
        }
        $ticket_arr += array(
            'next'=>isset($threads['pagination']['next'])?$threads['pagination']['next']:"",
            'total_page'=>isset($threads['pagination']['pageCount'])?$threads['pagination']['pageCount']:1,
            'total_left'=>$total_left
        );
        if(isset($_SESSION['uvdesk_customer']) && !empty($_SESSION['uvdesk_customer'])){
            Registry::get('view')->assign('reply_memeber',$_SESSION['uvdesk_customer']);                           
        }
        Registry::get('view')->assign('next',isset($threads['pagination']['next'])?$threads['pagination']['next']:1);    
        Registry::get('view')->assign('threads_arr',array_reverse($threads_arr));        
        Registry::get('view')->assign('ticket',$ticket_arr);                   
        Registry::get('view')->assign('collaborators',$collaborators);                   
        Registry::get('view')->assign('customer',$customer);                   
    }   
}


if($mode == 'download_attachment'){
    if(isset($_REQUEST['attachment_id']) && !empty($_REQUEST['attachment_id'])){
        fn_uvdesk_donwloadAttachment($_REQUEST['attachment_id']);
    }
}

if($mode == 'ticket_reply'){
    fn_trusted_vars('message');
    if(isset($_REQUEST['ticket_id']) && isset($_REQUEST['email']) && isset($_REQUEST['message'])){
        $response = fn_uvdesk_ticket_reply($_REQUEST['ticket_id'],$_REQUEST['message'], $_REQUEST['email'],'customer');
    }  
}

if($mode == 'load_more'){
    if(isset($_REQUEST['page'])){
        $page = $_REQUEST['page'];
    }else{
        $page = 1;
    }
    $id= $_REQUEST['result_ids'];
    $threads = json_decode(fn_uvdesk_getAllThreads($_REQUEST['ticket_id'],$page),true);
    $threads_arr = array(); 
    $thread = array();
    foreach($threads['threads'] as $key=>$value){
        $thread = array(
            'id'=>$value['id'],
            'reply'=>$value['reply'],
            'userType'=>$value['userType'],
            'formatedCreatedAt'=>$value['formatedCreatedAt'],
            'userId'=>$value['user']['id'],
            'name'=>$value['fullname'],
            'attachments'=>$value['attachments'],
            'smallThumbnail'=>isset($value['user']['smallThumbnail'])?$value['user']['smallThumbnail']:"design/backend/media/images/addons/cscart_uvdesk/uvdesk.png",
        );
        $threads_arr[] = $thread;
    }
    $total_threads_load = ($threads['pagination']['current']*$threads['pagination']['numItemsPerPage']);
    if($threads['pagination']['totalCount'] > $total_threads_load){
        $total_left = $threads['pagination']['totalCount'] - $total_threads_load;
    }else{
        $total_left = 0;
    }
    Registry::get('view')->assign('next',isset($threads['pagination']['next'])?$threads['pagination']['next']:"");
    Registry::get('view')->assign('threads_arr',array_reverse($threads_arr));
    $res = Registry::get('view')->fetch('addons/cscart_uvdesk/views/uvdesk_dashboard/components/threads_view.tpl');
    Registry::get('ajax')->assignHtml("$id",$res);
    Tygh::$app['ajax']->assign('next', isset($threads['pagination']['next'])?$threads['pagination']['next']:"");
    Tygh::$app['ajax']->assign('total_threads', $total_left);
    exit;
}

if($mode == 'create_ticket'){
    // fn_trusted_vars('ticket_message');
    fn_uvdesk_create_ticket();
    if(isset($auth['user_id']) && $auth['user_id'] == 0){
        $is_update = !empty($auth['user_id']);
            if (!$is_update) {
                $is_valid_user_data = true;
                $_REQUEST['user_data']['email'] = $_REQUEST['customer_email'];
                $_REQUEST['return_url'] = 'uvdesk_dashboard.customer_create_ticket';
                if (empty($_REQUEST['user_data']['email'])) {
                    $is_valid_user_data = false;
    
                } elseif (!fn_validate_email($_REQUEST['user_data']['email'])) {
                    $is_valid_user_data = false;
                }
                    
                $password = fn_uvdesk_random_password(10);
                $_REQUEST['user_data']['password1'] = $password;
                $_REQUEST['user_data']['password2'] = $password;
                
                if (!$is_valid_user_data) {
                    $redirect_params = array();
                    if (isset($_REQUEST['return_url'])) {
                        $redirect_params['return_url'] = $_REQUEST['return_url'];
                    }
    
                    return array(CONTROLLER_STATUS_REDIRECT, fn_uvdesk_buildUrn(array('uvdesk_dashboard', 'customer_create_ticket', $action), $redirect_params));
                }
            }
            $u_id = db_get_field("SELECT user_id FROM ?:users WHERE email = ?s",$_REQUEST['user_data']['email']);
            if($u_id){
                $redirect_params = array();
                if (isset($_REQUEST['return_url'])) {
                    $redirect_params['return_url'] = $_REQUEST['return_url'];
                }
                fn_set_notification("N",__("notice"), __("uvdesk_already_account"));
                return array(CONTROLLER_STATUS_REDIRECT, fn_uvdesk_buildUrn(array('uvdesk_dashboard', 'customer_create_ticket', $action), $redirect_params));
            }
            fn_restore_processed_user_password($_REQUEST['user_data'], $_POST['user_data']);
    
            $res = fn_update_user($auth['user_id'], $_REQUEST['user_data'], $auth, !empty($_REQUEST['ship_to_another']), true);
    
            if ($res) {
                list($user_id, $profile_id) = $res;
                list($auth_token) = fn_uvdesk_get_user_auth_token($user_id);
    
                // Cleanup user info stored in cart
                if (!empty(Tygh::$app['session']['cart']) && !empty(Tygh::$app['session']['cart']['user_data'])) {
                    Tygh::$app['session']['cart']['user_data'] = fn_array_merge(Tygh::$app['session']['cart']['user_data'], $_REQUEST['user_data']);
                }
    
                // Delete anonymous authentication
                if ($cu_id = fn_get_session_data('cu_id') && !empty($auth['user_id'])) {
                    fn_delete_session_data('cu_id');
                }
    
                Tygh::$app['session']->regenerateID();
    
            } else {
                fn_save_post_data('user_data');
                fn_delete_notification('changes_saved');
            }
    
            $redirect_params = array();
    
            if (!empty($user_id) && !$is_update) {
                fn_login_user($user_id);
    
                $redirect_dispatch = array('uvdesk_dashboard', 'manage');
            } else {
                $redirect_dispatch = array('uvdesk_dashboard', empty($user_id) ? 'customer_create_ticket' : 'update', $action);
    
                if (Registry::get('settings.General.user_multiple_profiles') == 'Y' && isset($profile_id)) {
                    $redirect_params['profile_id'] = $profile_id;
                }
    
                if (!empty($_REQUEST['return_url'])) {
                    $redirect_params['return_url'] = $_REQUEST['return_url'];
                }
            }
    
            if ($action === 'get_auth_token' && isset($auth_token)) {
                $redirect_params['token'] = $auth_token;
            }
            return array(CONTROLLER_STATUS_OK, fn_uvdesk_buildUrn($redirect_dispatch, $redirect_params));
    }
        
}


if($mode == 'customer_create_ticket'){
    if (AREA == 'C') {
        $_REQUEST['user_id'] = $auth['user_id'];
    }
    
    if (empty($_REQUEST['user_id'])) {
        if (AREA == 'C') {
            // return array(CONTROLLER_STATUS_REDIRECT, 'auth.login_form?return_url=' . urlencode(Registry::get('config.current_url')));
        } else {
            return array(CONTROLLER_STATUS_NO_PAGE);
        }
    }
    
    fn_add_breadcrumb(__('uvdesk_tickets'), "uvdesk_dashboard.manage");
    fn_add_breadcrumb(__('customer_create_ticket'));

    $types = json_decode(fn_uvdesk_getTicketTypes(),TRUE);
    Registry::get('view')->assign('types',!empty($types['types'])?array_reverse($types['types']):array());    
    if(isset($auth['user_id']) && $auth['user_id'] != 0 && isset($_SESSION['uvdesk_customer'])){
        Registry::get('view')->assign('customer_info',$_SESSION['uvdesk_customer']);
    }elseif(isset($auth['user_id']) && $auth['user_id'] != 0 ){
        $user_data = fn_get_user_short_info($auth['user_id']);
        if(isset($user_data['user_type']) && AREA == 'C'){
            $customer_id = json_decode(fn_uvdesk_get_customer_id($user_data['email']),true);
            if(isset($customer_id['customers'][0]['id'])){
                $_SESSION['uvdesk_customer'] = $customer_id['customers'][0];
                Registry::get('view')->assign('customer_info',$_SESSION['uvdesk_customer']);
            }else{
                $user_data = array(
                    'name'=>$user_data['firstname'].' '.$user_data['lastname'],
                    'email'=>$user_data['email']
                );
                Registry::get('view')->assign('customer_info',$user_data);                
            }
        }
    }
}

if($mode == 'add_collaborators'){
    $id = fn_uvdesk_addCollaborators();
    if(is_numeric($id)){
        Tygh::$app['ajax']->assign('id', $id);
    }
    exit;
}

if($mode == 'remove_collaborators'){
    fn_uvdesk_removeCollaborators();
    exit;
}