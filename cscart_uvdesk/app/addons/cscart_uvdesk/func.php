<?php
/**
* 2010-2018 Webkul.
*
* NOTICE OF LICENSE
*
* All right is reserved,
* Please go through this link for complete license : https://store.webkul.com/license.html
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade this module to newer
* versions in the future. If you wish to customize this module for your
* needs please refer to https://store.webkul.com/customisation-guidelines/ for more information.
*
*  @author    Webkul IN <support@webkul.com>
*  @copyright 2010-2018 Webkul IN
*  @license   https://store.webkul.com/license.html
*/

use Tygh\Registry;

/**
* Get All tickets for all data OR for a specific data ie. by page, by label, by agent, by customer etc
*
* @return object response
*/
function fn_uvdesk_get_ticket_list(){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
    $access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
    $company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');
	$url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/tickets.json?';
	if(isset($_REQUEST['page']) && $_REQUEST['page']){
		$url .= 'page=' . $_REQUEST['page'];
	}else{
		$url .= 'page=1';
	}
	if (isset($_REQUEST['status']) && $_REQUEST['status']) {
		$url .= '&status=' . $_REQUEST['status'];
	}
	if (isset($_REQUEST['label']) && $_REQUEST['label']) {
		$url .= '&'. $_REQUEST['label'];
	}else{
		$url .= '&all';
	}
	if (isset($_REQUEST['custom_label']) && $_REQUEST['custom_label']) {
		$url .= '&label='. $_REQUEST['custom_label'];
	}
	if (isset($_REQUEST['search']) && $_REQUEST['search']) {
		$url .= '&search='. $_REQUEST['search'];
	}
	if (isset($_REQUEST['customer']) && $_REQUEST['customer']) {
		$url .= '&customer='. $_REQUEST['customer'];
	}
	if (isset($_REQUEST['agent']) && $_REQUEST['agent']) {
		$url .= '&agent='. $_REQUEST['agent'];
	}
	if (isset($_REQUEST['priority']) && $_REQUEST['priority']) {
		$url .= '&priority='. $_REQUEST['priority'];
	}
	if (isset($_REQUEST['group']) && $_REQUEST['group']) {
		$url .= '&group='. $_REQUEST['group'];
	}
	if (isset($_REQUEST['team']) && $_REQUEST['team']) {
		$url .= '&team='. $_REQUEST['team'];
	}
	if (isset($_REQUEST['type']) && $_REQUEST['type']) {
		$url .= '&type='. $_REQUEST['type'];
	}
	if (isset($_REQUEST['tag']) && $_REQUEST['tag']) {
		$url .= '&tag='. $_REQUEST['tag'];
	}
	if (isset($_REQUEST['mailbox']) && $_REQUEST['mailbox']) {
		$url .= '&mailbox='. $_REQUEST['mailbox'];
	}
	if (isset($_REQUEST['sort']) && $_REQUEST['sort']) {
		$url .= '&sort=' . $_REQUEST['sort'];
	}
	if (isset($_REQUEST['order']) && $_REQUEST['order']) {
		$url .= '&direction=' . $_REQUEST['order'];
	}
    $ch = curl_init($url);
    $headers = array(
        'Authorization: Bearer '.$access_token,
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $info = curl_getinfo($ch);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($output, 0, $header_size);
    $response = substr($output, $header_size);
    curl_close($ch);
    return $response;
}

/**
* Get customer details at uvdesk by customer email id
*
* @param string $email - customer email
*
* @return object response
*/
function fn_uvdesk_get_customer_id($email){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
	$access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
	$company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');
	$url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/customers.json?email='.$email;
    $ch = curl_init($url);
    $headers = array(
        'Authorization: Bearer '.$access_token,
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $info = curl_getinfo($ch);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($output, 0, $header_size);
    $response = substr($output, $header_size);
    curl_close($ch);
    return $response;
}

/**
* Get all threads of a specific ticket
*
* @param int $ticketId - ticket id
* @param int|bool $page - page number
*
* @return object response
*/
function fn_uvdesk_getAllThreads($ticket_id, $page = '' ){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
    $access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
    $company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');
	$url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/ticket/'.$ticket_id.'/threads.json?page='.$page;
	$ch = curl_init($url);
	$headers = array('Authorization: Bearer '.$access_token,);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$headers = substr($output, 0, $header_size);
	$response = substr($output, $header_size); 
    curl_close($ch);
    return $response;
}

/**
* For getting ticket we always use increment Id
*
* @return object response
*/
function fn_uvdesk_getTicket(){    
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
    $access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
    $company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');
    $url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/ticket/'.$_REQUEST['increment_id'].'.json';
    $ch = curl_init($url);

    $headers = array(
        'Authorization: Bearer '.$access_token,
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $info = curl_getinfo($ch);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($output, 0, $header_size);
    $response = substr($output, $header_size);
    curl_close($ch);
    return $response;
}

/**
* Get members (agents) details by searched name (If no name exist then it will return all members details)
*
* @param int $page - pagination to get the agents
* @param string $search - get the agent list by matching the seach item
*
* @return object response
*/
function getAgents($page = 1,$search = ''){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
    $access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
    $company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');
	$url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/members.json?sort=name&isActive=1&page='.$page.'&search='.$search;
	$ch = curl_init($url);
	$headers = array('Authorization: Bearer '.$access_token,);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$headers = substr($output, 0, $header_size);
	$response = substr($output, $header_size);
	curl_close($ch);
    return $response;
}

/**
* Assign ticket to any agent (member)
*
* @param int $ticketId  - ticket id
* @param int $agentId  - member id
*
* @return boolean true
*/
function fn_uvdesk_updateAgent($ticketId,$agentId){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
    $access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
    $company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');

    $url_a = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/ticket/'.$ticketId.'/agent.json';
	$ch = curl_init($url_a);
	$json_data=array('id' => $agentId);

	$headers = array('Authorization: Bearer '.$access_token,);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($json_data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$headers = substr($output, 0, $header_size);
	$response = substr($output, $header_size);
	$response = json_decode($response);
	curl_close($ch);
	if(isset($response->message)){
		fn_set_notification("N",__("notice"), $response->message);
	}elseif(isset($response->error)){
		fn_set_notification("W",__("warning"), $response->error);
	}
	return true;
}

/**
* Delete customer tickets by Admin
*
* @param array $ticketIds - collection of ticket ids
*
* @return boolean true
*/
function moveToTrash($ticketIds){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
    $access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
    $company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');

    $url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/tickets/trash.json';
	$ch = curl_init($url);
	$json_data=array('ids' => $ticketIds);

	$headers = array('Authorization: Bearer '.$access_token,);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($json_data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$headers = substr($output, 0, $header_size);
	$response = substr($output, $header_size);
	$response = json_decode($response);
	curl_close($ch);
	if(isset($response->message)){
		fn_set_notification("N",__("notice"), $response->message);
	}elseif(isset($response->error)){
		fn_set_notification("W",__("warning"), $response->error);
	}
    return true;
}

/**
* Download file of any thread
*
* @param int $attachmentId - attachment id
*
*/
function fn_uvdesk_donwloadAttachment($attachment_id = 0){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
	$access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
	$company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');
	$url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/ticket/attachment/'.$attachment_id.'.json';
	header('Location: '.$url.'?access_token='.$access_token);
	exit;
}

/**
* Add thread on a speicific ticket
*
* @param int $ticketId - ticket id
* @param string $message - reply by customer or agent
* @param string $actAsEmail - email of customer or agent
* @param stirng $actAsType - act as customer or agent
* @param int $status - status of the ticket
*
* @return boolean true
*/
function fn_uvdesk_ticket_reply($ticketId = 0,$message = "", $actAsEmail = "", $actAsType = '', $status = 1){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
	$access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
	$company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');
	$fileObject = $_FILES['attachments'];	
	$url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/ticket/'.$ticketId.'/threads.json';
	$ch = curl_init($url);
	if(!strlen($fileObject['name'][0])){
		$json_id=array(
				"threadType"=> "reply",
				"reply"=> $message,
				"status"=> $status,
				"actAsType" => $actAsType,
				"actAsEmail"=>$actAsEmail
			);
		if($actAsType == 'customer'){
			$json_id += array(
				"actAsEmail"=>$actAsEmail,
			);
		}
		$headers = array('Authorization: Bearer '.$access_token,);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($json_id));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$headers = substr($output, 0, $header_size);
		$response = substr($output, $header_size);
		$err = curl_error($ch);
		curl_close($ch);
		$response = json_decode($response);
	}else{
		$lineEnd = "\r\n";
		$mime_boundary = md5(time());
		$data = '--' . $mime_boundary . $lineEnd;
		$data .= 'Content-Disposition: form-data; name="threadType"' . $lineEnd . $lineEnd;
		$data .= 'reply'. $lineEnd;
		$data .= '--' . $mime_boundary . $lineEnd;
		$data .= 'Content-Disposition: form-data; name="actAsType"' . $lineEnd . $lineEnd;
		$data .= $actAsType. $lineEnd;
		$data .= '--' . $mime_boundary . $lineEnd;
		$data .= 'Content-Disposition: form-data; name="status"' . $lineEnd . $lineEnd;
		$data .= $status. $lineEnd;
		$data .= '--' . $mime_boundary . $lineEnd;
		$data .= 'Content-Disposition: form-data; name="reply"' . $lineEnd . $lineEnd;
		$data .= $message. $lineEnd;
		/*foreach ($customField as $cust) {
			$data .= '--' . $mime_boundary . $lineEnd;
			$data .= 'Content-Disposition: form-data; name="customFields"' . $lineEnd . $lineEnd;
			$data .= $cust. $lineEnd;	
		}*/
		$data .= '--' . $mime_boundary . $lineEnd;
		if ($actAsType == 'customer') {
            // act as email (email of user making reply to differentiate whether the reply is made by the customer or collaborator)
            $data .= 'Content-Disposition: form-data; name="actAsEmail"' . $lineEnd . $lineEnd;
            $data .= "".$actAsEmail."" . $lineEnd;
            $data .= '--' . $mime_boundary . $lineEnd;
        }
		// $data .= 'Content-Disposition: form-data; name="customFields"' . $lineEnd . $lineEnd;
		// $data .= $customField. $lineEnd;
		// $data .= '--' . $mime_boundary . $lineEnd;
		for($i=0;$i<count($fileObject['name']);$i++) {
			$fileType = $fileObject['type'][$i];
			$fileName = $fileObject['name'][$i];
			$fileTmpName =$fileObject['tmp_name'][$i];
			$data .= 'Content-Disposition: form-data; name="attachments[]"; filename="' .$fileName . '"' . $lineEnd;
			$data .= "Content-Type: $fileType" . $lineEnd . $lineEnd;
			$data .= file_get_contents($fileTmpName) . $lineEnd;
			$data .= '--' . $mime_boundary . $lineEnd;
		}
		 $headers = array(
			"Authorization: Bearer ".$access_token,
			"Content-type: multipart/form-data; boundary=" . $mime_boundary,
		);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$server_output = curl_exec($ch);
		$info = curl_getinfo($ch);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$headers = substr($server_output, 0, $header_size);
		$response = substr($server_output, $header_size);
		$err = curl_error($ch);
		$response=json_decode($response);
		curl_close($ch);
	}

		if($err){
			fn_set_notification("E",__("error"), $err);
		}
		else{
			if(isset($response->message)){
				fn_set_notification("N",__("notice"), $response->message);
			}elseif(isset($response->error)){
				fn_set_notification("W",__("warning"), $response->error);
			}
		}
		return true;
}

/**
* Create ticket by customer with a subject and message
*
* @param array $data - collection of customer name, email, subject and reply
*
* @return object response
*/
function fn_uvdesk_create_ticket(){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
	$access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
	$company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');
	$url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/tickets.json';

	$fileObject = $_FILES['attachments'];
	$customField=array();
	if(isset($_REQUEST['customFields']) && count($_REQUEST['customFields'])){
		foreach ($_REQUEST['customFields'] as $key=>$value) {
			$customField[$key]=$value;
		}
	}
	if(!strlen($fileObject['name'][0])){
		$data = json_encode(array(
			"name" => $_REQUEST['customer_name'],
			"from" => $_REQUEST['customer_email'],
			"subject" => $_REQUEST['ticket_subject'],
			"reply" => $_REQUEST['ticket_message'],
			"type" => $_REQUEST['ticket_type'],
			// "customFields"=>$customField,

		));
		$ch = curl_init($url);
		$headers = array(
			'Authorization: Bearer '.$access_token,
			'Content-type: application/json'
		);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$server_output = curl_exec($ch);
		$info = curl_getinfo($ch);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$headers = substr($server_output, 0, $header_size);
		$err = curl_error($ch);
		$response = substr($server_output, $header_size);
		curl_close($ch);
		$response=json_decode($response);
	}
	else{
		$lineEnd = "\r\n";
		$mime_boundary = md5(time());
		$data = '--' . $mime_boundary . $lineEnd;
		$data .= 'Content-Disposition: form-data; name="type"' . $lineEnd . $lineEnd;
		$data .= $_REQUEST['ticket_type']. $lineEnd;
		$data .= '--' . $mime_boundary . $lineEnd;
		$data .= 'Content-Disposition: form-data; name="name"' . $lineEnd . $lineEnd;
		$data .= $_REQUEST['customer_name'] . $lineEnd;
		$data .= '--' . $mime_boundary . $lineEnd;
		$data .= 'Content-Disposition: form-data; name="from"' . $lineEnd . $lineEnd;
		$data .= $_REQUEST['customer_email']. $lineEnd;
		$data .= '--' . $mime_boundary . $lineEnd;
		$data .= 'Content-Disposition: form-data; name="subject"' . $lineEnd . $lineEnd;
		$data .= $_REQUEST['ticket_subject']. $lineEnd;
		$data .= '--' . $mime_boundary . $lineEnd;
		$data .= 'Content-Disposition: form-data; name="reply"' . $lineEnd . $lineEnd;
		$data .= $_REQUEST['ticket_message']. $lineEnd;
		/*foreach ($customField as $cust) {
			$data .= '--' . $mime_boundary . $lineEnd;
			$data .= 'Content-Disposition: form-data; name="customFields"' . $lineEnd . $lineEnd;
			$data .= $cust. $lineEnd;	
		}*/
		$data .= '--' . $mime_boundary . $lineEnd;
		// $data .= 'Content-Disposition: form-data; name="customFields"' . $lineEnd . $lineEnd;
		// $data .= $customField. $lineEnd;
		// $data .= '--' . $mime_boundary . $lineEnd;
		for($i=0;$i<count($fileObject['name']);$i++) {
			$fileType = $fileObject['type'][$i];
			$fileName = $fileObject['name'][$i];
			$fileTmpName =$fileObject['tmp_name'][$i];
			$data .= 'Content-Disposition: form-data; name="attachments[]"; filename="' .$fileName . '"' . $lineEnd;
			$data .= "Content-Type: $fileType" . $lineEnd . $lineEnd;
			$data .= file_get_contents($fileTmpName) . $lineEnd;
			$data .= '--' . $mime_boundary . $lineEnd;
		}
		 $headers = array(
			"Authorization: Bearer ".$access_token,
			"Content-type: multipart/form-data; boundary=" . $mime_boundary,
		);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$server_output = curl_exec($ch);
		$info = curl_getinfo($ch);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$headers = substr($server_output, 0, $header_size);
		$response = substr($server_output, $header_size);
		$err = curl_error($ch);
		$response=json_decode($response);
		curl_close($ch);
	}

		if($err){
			fn_set_notification("E",__("error"), $err);
		}
		else{
			if(isset($response->message)){
				fn_set_notification("N",__("notice"), $response->message);
			}elseif(isset($response->error)){
				fn_set_notification("W",__("warning"), $response->error);
			}
		}
		return true;
}

/**
* Starred the ticket
*
* @param array $ticketId - ticket id
*
* @return boolean true
*/
function fn_uvdesk_ticket_starred($ticketId){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
	$access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
	$company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');
	$url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/ticket/'.$ticketId.'.json';
	$ch = curl_init($url);
	$json_id=array("id"=>$ticketId,"editType"=>"star");
	$headers = array('Authorization: Bearer '.$access_token,);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
	curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($json_id));
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$headers = substr($output, 0, $header_size);
	$response = substr($output, $header_size);
	$response=json_decode($response);
	curl_close($ch);
	if(isset($response->message)){
		fn_set_notification("N",__("notice"), $response->message);
	}elseif(isset($response->error)){
		fn_set_notification("W",__("warning"), $response->error);
	}
	return true;
}

/**
* Update the priority of the ticket
*
* @param array $ticketId - ticket id
* @param array $priorityValue - priority id
*
* @return boolean true
*/
function fn_uvdesk_update_ticket_priority($ticketId = 0, $priorityValue = 1){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
	$access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
	$company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');
    // $priorityValue = 3; //1|2|3|4 for Low|medium|High|Urgent
    $url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/ticket/'.$ticketId.'.json';
	$ch = curl_init($url);
	$json_id=array("id"=>$ticketId,"editType"=>"priority","value"=> $priorityValue);
	$headers = array('Authorization: Bearer '.$access_token,);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
	curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($json_id));
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$headers = substr($output, 0, $header_size);
	$response = substr($output, $header_size);
	$response = json_decode($response);
	curl_close($ch);
	if(isset($response->message)){
		fn_set_notification("N",__("notice"), $response->message);
	}elseif(isset($response->error)){
		fn_set_notification("W",__("warning"), $response->error);
	}
	return true;
}

/**
* Update the status of the ticket
*
* @param array $ticketId - ticket id
* @param array $statusValue - status id
*
* @return boolean true
*/
function fn_uvdesk_update_ticket_status($ticketId, $statusValue){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
	$access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
	$company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');
    // $statusValue = 5; //1|2|3|4|5|6 for open|pending|resolved|closed|Spam|Answered repectively
    $url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/ticket/'.$ticketId.'.json';
	$ch = curl_init($url);
	$json_id=array("id"=>$ticketId,"editType"=>"status","value"=> $statusValue);
	$headers = array('Authorization: Bearer '.$access_token,);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
	curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($json_id));
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$headers = substr($output, 0, $header_size);
	$response = substr($output, $header_size);
	$response = json_decode($response);	
	curl_close($ch);
	if(isset($response->message)){
		fn_set_notification("N",__("notice"), $response->message);
	}elseif(isset($response->error)){
		fn_set_notification("W",__("warning"), $response->error);
	}
	return true;
}

/**
* Update the type of the ticket
*
* @param array $ticketId - ticket id
* @param array $typeValue - type id
*
* @return boolean true
*/
function fn_uvdesk_update_ticket_type($ticketId, $typeValue){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
	$access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
	$company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');
    $url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/ticket/'.$ticketId.'.json';
	$ch = curl_init($url);
	$json_id=array("id"=>$ticketId,"editType"=>"type","value"=> $typeValue);
	$headers = array('Authorization: Bearer '.$access_token,);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
	curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($json_id));
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$headers = substr($output, 0, $header_size);
	$response = substr($output, $header_size);
	$response = json_decode($response);	
	curl_close($ch);
	if(isset($response->message)){
		fn_set_notification("N",__("notice"), $response->message);
	}elseif(isset($response->error)){
		fn_set_notification("W",__("warning"), $response->error);
	}
	return true;
}

/**
* Get member by email
*
* @param array $email - agent email
*
* @return object response
*/
function fn_uvdesk_get_member_by_email($email){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
	$access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
	$company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');
	$url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/members.json?search='.$email;
	$ch = curl_init($url);
	$headers = array('Authorization: Bearer '.$access_token,);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$headers = substr($output, 0, $header_size);
	$response = substr($output, $header_size);
	curl_close($ch);
	return $response;
}

/**
* Get member by id
*
* @param array $memberId - agent id
*
* @return object response
*/
function fn_get_member_details($memberId){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
	$access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
	$company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');
	$url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/member/'.$memberId.'.json';
	$ch = curl_init($url);
	$headers = array('Authorization: Bearer '.$access_token,);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$headers = substr($output, 0, $header_size);
	$response = substr($output, $header_size);
	curl_close($ch);
	return $response;
}

/**
* Get types to create new ticket
*
*
* @return object response
*/
function fn_uvdesk_getTicketTypes(){    
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
    $access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
    $company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');
    $url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/ticket-types.json';
    $ch = curl_init($url);

    $headers = array(
        'Authorization: Bearer '.$access_token,
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $info = curl_getinfo($ch);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($output, 0, $header_size);
    $response = substr($output, $header_size);
    curl_close($ch);
    return $response;
}

/**
* Generate random password for new user
*
* @param array $length - length of the password
*
* @return string password
*/
function fn_uvdesk_random_password( $length = 8 ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
	$password = substr( str_shuffle( $chars ), 0, $length );
	return $password;
}

/**
* Add a collaboration by a specific ticket by customer
*
* @return object response
*/
function fn_uvdesk_addcollaborators(){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
	$access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
	$company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');
	$url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/ticket/'.$_REQUEST['ticket_id'].'/collaborator.json';
	$ch = curl_init($url);

	$json_id=array(
				'email' => $_REQUEST['email']
			);
	$headers = array('Authorization: Bearer '.$access_token,);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($json_id));
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$headers = substr($output, 0, $header_size);
	$response = substr($output, $header_size);
	$err = curl_error($ch);
	curl_close($ch);
	$response = json_decode($response);
	if(isset($response->message)){
		fn_set_notification("N",__("notice"), $response->message);
		return $response->collaborator->id;
	}elseif(isset($response->error)){
		fn_set_notification("W",__("warning"), $response->error);
	}
	return true;
}

/**
* Remove collaboration from the ticket
*
* @return object response
*/
function fn_uvdesk_removeCollaborators(){
	$lang_code = 'en';
	if(defined(DESCR_SL)){
		$lang_code = DESCR_SL;
	}
    $access_token = Registry::get('addons.cscart_uvdesk.uvdesk_access_token');
    $company_domain = Registry::get('addons.cscart_uvdesk.uvdesk_comany_domain');

    $url = 'https://'.$company_domain.'.uvdesk.com/'.$lang_code.'/api/ticket/'.$_REQUEST['ticket_id'].'/collaborator.json';
	$ch = curl_init($url);
	$json_data=array(
		'collaboratorId' => $_REQUEST['colab_id'],
	);
	$headers = array('Authorization: Bearer '.$access_token,);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($json_data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$headers = substr($output, 0, $header_size);
	$response = substr($output, $header_size);
	$response = json_decode($response);
	$err = curl_error($ch);
	curl_close($ch);
	if(isset($response->message)){
		fn_set_notification("N",__("notice"), $response->message);
	}elseif(isset($response->error)){
		fn_set_notification("W",__("warning"), $response->error);
	}
	return true;
}

/**
* Build the url
*
* @param array $dispatch - controller and mode
* @param array $query_params - extra params
*
* @return string result
*/
function fn_uvdesk_buildUrn($dispatch, array $query_params = array())
{
    if (is_array($dispatch)) {
        $dispatch = implode('.', array_filter($dispatch));
    }
    $result = $dispatch;
    if ($query_params) {
        $result .= '?' . http_build_query($query_params);
    }
    return $result;
}
	
/**
* Build the url
*
* @param array $user_id - user id of the customer
* @param array $ttl 
*
* @return string result
*/
function fn_uvdesk_get_user_auth_token($user_id, $ttl = 604800)
{
	$ekeys = fn_get_ekeys(array(
		'object_id' => $user_id,
		'object_type' => 'U',
		'ttl' => TIME
	));

	if ($ekeys) {
		$ekey = reset($ekeys);
		$token = $ekey['ekey'];
		$expiry_time = $ekey['ttl'];
	} else {
		$token = fn_generate_ekey($user_id, 'U', $ttl);
		$expiry_time = time() + $ttl;
	}

	return array($token, $expiry_time);
}

/**
* Run at the time addon install
*
*/
function fn_uvdesk_install(){
	$data = array(
		'param_5'=> 1,
		'parent_id'=> 0,
		'descr' => 'Create Ticket',
    	'position' => 85,
		'param' => 'uvdesk_dashboard.customer_create_ticket',
		
	);
	fn_uvdesk_update_static_data($data,0,'A');
}

/**
* Function to create the item in quick link
*
* @param array $data - contain quick link data
* @param int $param_id - 0
* @param char $section - A
*
* @return param_id generated new param id
*/
function fn_uvdesk_update_static_data($data, $param_id, $section, $lang_code = DESCR_SL)
{
    $current_id_path = '';
    $schema = fn_get_schema('static_data', 'schema');
    $section_data = $schema[$section];

    if (!empty($section_data['has_localization'])) {
        $data['localization'] = empty($data['localization']) ? '' : fn_implode_localizations($data['localization']);
    }

    if (!empty($data['megabox'])) { // parse megabox value
        foreach ($data['megabox']['type'] as $p => $v) {
            if (!empty($v)) {
                $data[$p] = $v . ':' . intval($data[$p][$v]) . ':' . $data['megabox']['use_item'][$p];
            } else {
                $data[$p] = '';
            }
        }
    }

    $condition = db_quote('param_id = ?i', $param_id);

    fn_set_hook('update_static_data', $data, $param_id, $condition, $section, $lang_code);

    if (!empty($param_id)) {
        $current_id_path = db_get_field("SELECT id_path FROM ?:static_data WHERE $condition");
        db_query("UPDATE ?:static_data SET ?u WHERE param_id = ?i", $data, $param_id);
        db_query('UPDATE ?:static_data_descriptions SET ?u WHERE param_id = ?i AND lang_code = ?s', $data, $param_id, $lang_code);
    } else {
        $data['section'] = $section;

        $param_id = $data['param_id'] = db_query("INSERT INTO ?:static_data ?e", $data);
        foreach (fn_get_translation_languages() as $data['lang_code'] => $_v) {
            db_query('REPLACE INTO ?:static_data_descriptions ?e', $data);
        }
    }

    // Generate ID path
    if (isset($data['parent_id'])) {
        if (!empty($data['parent_id'])) {
            $new_id_path = db_get_field("SELECT id_path FROM ?:static_data WHERE param_id = ?i", $data['parent_id']);
            $new_id_path .= '/' . $param_id;
        } else {
            $new_id_path = $param_id;
        }

        if (!empty($current_id_path) && $current_id_path != $new_id_path) {
            db_query("UPDATE ?:static_data SET id_path = CONCAT(?s, SUBSTRING(id_path, ?i)) WHERE id_path LIKE ?l", "$new_id_path/", strlen($current_id_path . '/') + 1, "$current_id_path/%");
        }
        db_query("UPDATE ?:static_data SET id_path = ?s WHERE param_id = ?i", $new_id_path, $param_id);
    }

    if (!empty($section_data['icon'])) {
        fn_attach_image_pairs('static_data_icon', $section_data['icon']['type'], $param_id, $lang_code);
    }

    return $param_id;
}