<?php
if (!defined('BOOTSTRAP')) { die('Access denied'); }
use Tygh\Registry;

if($mode == 'manage'){
    //get all the list
    $tickets_arr = array();
    if(isset($auth['user_id'])){
        $result = db_get_row('SELECT firstname, lastname, email, user_type, lang_code from ?:users WHERE user_id = ?i',$auth['user_id']);
        $agent_info = json_decode(fn_uvdesk_get_member_by_email($result['email']), TRUE);
        if(isset($agent_info['users'][0])){
            $agent_info = $agent_info['users'][0];
        }else{
            return array(CONTROLLER_STATUS_NO_PAGE);
        }
    }
    if($agent_info['role'] == 'ROLE_SUPER_ADMIN' || $agent_info['role'] ==  'ROLE_ADMIN'){
        Registry::get('view')->assign('all_privileges',TRUE);
    }else{
        $_REQUEST['agent'] = $agent_info['id'];
        $member_complete_info = json_decode(fn_get_member_details($agent_info['id']),TRUE);
        Registry::get('view')->assign('privileges',$member_complete_info['roles']); 
        Registry::get('view')->assign('all_privileges',FALSE);        
    }
    $tickets = json_decode(fn_uvdesk_get_ticket_list(), TRUE) ;
    $tabs_status = $tickets['tabs'];  //counts of the status sidebar 
    $tabs_label = $tickets['labels']['predefind']; //count of label sidebar
    foreach($tickets['tickets'] as $ticket){
        $ticket = array(
                'id'=>$ticket['id'],
                'Priority_Id'=>$ticket['priority']['id'],
                'isStarred'=> $ticket['isStarred'],
                'Increment_Id'=>$ticket['incrementId'],
                'Cus_name'=>$ticket['customer']['name'],
                'Subject'=>$ticket['subject'],
                'date_added'=>$ticket['formatedCreatedAt'],
                'Replies'=> $ticket['totalThreads'],
                'agent_name'=>($ticket['agent'] != null)?$ticket['agent']['name']:"undefined",
                'agent_id'=>($ticket['agent'] != null)?$ticket['agent']['id']:"0"
            
        );
        array_push($tickets_arr,$ticket);
    }
    
    $agents = json_decode(getAgents());
    $users = array();
    foreach($agents->users as $agent){
        if($agent->isActive == 1){
            $data = array(
                'id' => $agent->id,
                'name' => $agent->name
            );
            array_push($users,$data);
        }
    }
    $search = array(
        'page' => $tickets['pagination']['current'],
        'items_per_page' => $tickets['pagination']['numItemsPerPage'],
        'total_items' => $tickets['pagination']['totalCount'],
    );
    Registry::get('view')->assign('agents',$users);
    Registry::get('view')->assign('types',$tickets['type']);
    Registry::get('view')->assign('tabs_status',$tabs_status);
    Registry::get('view')->assign('tabs_label',$tabs_label);
    Registry::get('view')->assign('tickets', $tickets_arr); 
    Registry::get('view')->assign('status_u',isset($_REQUEST['status'])?$_REQUEST['status']:"1");  
    Tygh::$app['view']->assign('search', $search);    
    Registry::get('view')->assign('label_u',isset($_REQUEST['label'])?$_REQUEST['label']:'all'); 
}

if($mode == 'view_ticket'){
    if(isset($auth['user_id'])){
        $result = db_get_row('SELECT firstname, lastname, email, user_type, lang_code from ?:users WHERE user_id = ?i',$auth['user_id']);
        $agent_info = json_decode(fn_uvdesk_get_member_by_email($result['email']), TRUE);
        if(isset($agent_info['users'][0])){
            $agent_info = $agent_info['users'][0];
        }else{
            return array(CONTROLLER_STATUS_NO_PAGE);
        }
    }
    if($agent_info['role'] == 'ROLE_SUPER_ADMIN' || $agent_info['role'] ==  'ROLE_ADMIN'){
        Registry::get('view')->assign('all_privileges',TRUE);
    }else{
        $_REQUEST['agent'] = $agent_info['id'];
        $member_complete_info = json_decode(fn_get_member_details($agent_info['id']),TRUE);
        Registry::get('view')->assign('privileges',$member_complete_info['roles']); 
    }
    $ticket = json_decode(fn_uvdesk_getTicket(),true);
    $ticket_id = $ticket['ticket']['id'];
    $tabs_label = $ticket['labels']['predefind']; //count of label sidebar
    
    $ticket_arr = array(
        'ticket_id' => $ticket['ticket']['id'],
        'increment_id'=> $ticket['ticket']['incrementId'],
        'subject'=> $ticket['ticket']['subject'],
        'status'=>$ticket['ticket']['status']['name'],
        'priority'=>$ticket['ticket']['priority']['name'],
        'priority_color'=>$ticket['ticket']['priority']['color'],
        'Priority_Id'=>$ticket['ticket']['priority']['id'],
        'type'=>!empty($ticket['ticket']['type']['name'])?$ticket['ticket']['type']['name']:"",
        'total_threads'=>$ticket['ticketTotalThreads'],
        'agent'=>($ticket['ticket']['agent'] != null)?$ticket['ticket']['agent']['detail']['agent']['name']:"undefined",
        'agent_id'=>($ticket['ticket']['agent'] != null)?$ticket['ticket']['agent']['detail']['agent']['name']:"undefined",
        'ticket_creater'=>$ticket['createThread']['fullname'],
        'ticket_creater_email_id'=>$ticket['createThread']['user']['email'],
        'ticket_msg'=>$ticket['createThread']['reply'],
        'ticket_attachment'=>!empty($ticket['createThread']['attachments'])?json_decode(json_encode($ticket['createThread']['attachments']), TRUE):array(),
        'ticket_date'=>$ticket['createThread']['createdAt']['date'],
        'agent_thumbnail'=>isset($ticket['agent']['smallThumbnail'])?$ticket['agent']['smallThumbnail']:"design/backend/media/images/addons/cscart_uvdesk/uvdesk.png",
        'isStarred'=>$ticket['ticket']['isStarred']
    );
    $customer = array(
        'name' => isset($ticket['ticket']['customer']['detail']['customer']['name'])?$ticket['ticket']['customer']['detail']['customer']['name']:"",
        'isActive' => $ticket['ticket']['customer']['detail']['customer']['isActive'],
        'email' => !empty($ticket['ticket']['customer']['email'])?$ticket['ticket']['customer']['email']:"*****",
        'smallThumbnail' => !empty($ticket['ticket']['customer']['smallThumbnail'])?$ticket['ticket']['customer']['smallThumbnail']:"design/backend/media/images/addons/cscart_uvdesk/uvdesk.png",
    );
    if(isset($_REQUEST['page'])){
        $page = $_REQUEST['page'];
    }else{
        $page = 1;
    }
    $threads = json_decode(fn_uvdesk_getAllThreads($ticket_id,$page),true);

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

    $agents = json_decode(getAgents());
    $users = array();
    foreach($agents->users as $agent){
        if($agent->isActive == 1){
            $data = array(
                'id' => $agent->id,
                'name' => $agent->name
            );
            array_push($users,$data);
        }
    }
    Registry::get('view')->assign('agents',$users);

    Registry::get('view')->assign('threads_arr',array_reverse($threads_arr));
    Registry::get('view')->assign('next',isset($threads['pagination']['next'])?$threads['pagination']['next']:1);        
    Registry::get('view')->assign('agent_info',$agent_info );    
    Registry::get('view')->assign('status_arr',$ticket['status']);
    Registry::get('view')->assign('priority_arr',$ticket['priority']);
    Registry::get('view')->assign('customer',$customer);
    Registry::get('view')->assign('type_arr',$ticket['type']);
    Registry::get('view')->assign('ticket_arr',$ticket_arr);
    Registry::get('view')->assign('tabs_label',$tabs_label);    
    // Registry::get('view')->assign('reply_user_data',$result);
}


if($mode == 'getAgents'){
    $page = 1;
    $search = "";
    if(isset($_REQUEST['page'])){
        $page = $_REQUEST['page'];
    }
    if(isset($_REQUEST['q'])){
        $search = $_REQUEST['q'];
    }
    $agents = json_decode(getAgents($page,$search));
    $users = array();
    foreach($agents->users as $agent){
        if($agent->isActive == 1){
            $data = array(
                'id' => $agent->id,
                'text' => $agent->name
            );
            array_push($users,$data);
        }
    }
    Tygh::$app['ajax']->assign('objects', $users);
    Tygh::$app['ajax']->assign('total_objects', isset($pagination_data['totalCount']) ? $pagination_data['totalCount'] : count($users));    
}

if($mode == 'updateAgent'){
    if(isset($_REQUEST['ticket_id']) && isset($_REQUEST['agent_id'])){
        $response = fn_uvdesk_updateAgent($_REQUEST['ticket_id'],$_REQUEST['agent_id']);
        if($response){
            Tygh::$app['ajax']->assign('agent', true);
        }
    }
}

if($mode == 't_delete'){
    if(isset($_REQUEST['ticket_ids'])){
        moveToTrash($_REQUEST['ticket_ids']);   
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
        $response = fn_uvdesk_ticket_reply($_REQUEST['ticket_id'],$_REQUEST['message'], $_REQUEST['email'],'agent');
    }  
}

if($mode == 'create_ticket'){
    // fn_trusted_vars('ticket_message');
    fn_uvdesk_create_ticket();
}

if($mode == 'ticket_starred'){
    if (defined('AJAX_REQUEST')) {
        if(isset($_REQUEST['ticket_id']) && !empty($_REQUEST['ticket_id'])){
            fn_uvdesk_ticket_starred($_REQUEST['ticket_id']);
        }
    }
}

if($mode == 'ticket_priority'){
    if(isset($_REQUEST['priority_id']) && isset($_REQUEST['ticket_id'])){
        $response = fn_uvdesk_update_ticket_priority($_REQUEST['ticket_id'], $_REQUEST['priority_id']);
        if($response){
            Tygh::$app['ajax']->assign('priority', true);
        }
    }
}

if($mode == 'ticket_status'){
    if(isset($_REQUEST['status_id']) && isset($_REQUEST['ticket_id'])){
        $response = fn_uvdesk_update_ticket_status($_REQUEST['ticket_id'], $_REQUEST['status_id']);
        if($response){
            Tygh::$app['ajax']->assign('status', true);
        }
    }
}

if($mode == 'ticket_type'){
    if(isset($_REQUEST['type_id']) && isset($_REQUEST['ticket_id'])){
        $response = fn_uvdesk_update_ticket_type($_REQUEST['ticket_id'], $_REQUEST['type_id']);
        if($response){
            Tygh::$app['ajax']->assign('type', true);
        }
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
