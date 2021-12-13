<?php

/**
 * notification sample
 *
 * @package   Notification sample
 * @author    Rafael Amorim <amorim@rafaelamorim.com.br>
 * @copyright (c) Rafael Amorim
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      https://www.rafaelamorim.com.br/
 *
 * Following instructions from https://www.opensource-socialnetwork.org/discussion/view/2967/how-to-send-notifications-to-users-using-ossnnotifications-class?offset=1
 * 
 * By definition of the notification system, isn't allowed to user create a 
 * self notification. So, to make this function, it's necessary to create a 
 * dummy user and change "__notificationsample_dummy_guid__" value above. 
 * I will keep in 1, but you need to change. Or test with another user account.
 * Otherwise, OSSN show an error message.
 * 
 */
 define('__notificationsample_dummy_guid__',1);
 
 function notificationsample_init(){
	
	//css
	ossn_extend_view('css/ossn.default', 'css/notificationsample');
	
	//page
	ossn_register_page('notificationsample', 'notificationsample_page');
 
	//menu
	ossn_register_sections_menu('newsfeed', array(
		'name' => 'notificationsample',
		'text' => ossn_print('notification:add:myself'),
		'url' => ossn_site_url('notificationsample/myself'),
		'parent' => 'links',
		'icon' => false
	));
	
	//hooks
    ossn_add_hook('notification:add', 'notification:message:tomyself', 'notificationsamplemyself_add_config'); 
	ossn_add_hook('notification:view', 'notification:message:tomyself', 'notificationsamplemyself_view');
	
 }
 
 function notificationsamplemyself_add_config($hook, $type, $return, $params){
	error_log("in notificationsamplemyself_add_config function");
	$params['owner_guid'] = $params['notification_owner'];
	return $params;
}

function notificationsamplemyself_view($hook, $type, $return, $params){
	$notif   = $params;
	$user    = ossn_user_by_guid($notif->poster_guid);
	$display = true;
	if(!$user){
		return false;	
	}
	switch($notif->type){
		case 'notification:message:tomyself':
		$display = true;
			$url     = ossn_site_url("u/".$user->username);
			break;
	}

	if(!$display){
			return false;
	}
	$iconURL = $user->iconURL()->small;
	return ossn_plugin_view('notifications/template/view', array(
			'iconURL'   => $iconURL,
			'guid'      => $notif->guid,
			'type'      => 'notification:message:tomyself',
			'viewed'    => $notif->viewed,
			'url'       => $url,
			'icon_type' => 'alert',
			'fullname'  => $user->fullname,
	));
}

function addNotificationSampleAnnotation($type,$subject_guid){
	
	$annotation = new \OssnAnnotation;
	
	if (empty($type) || !isset($subject_guid)) {
		return false;
	}

	$annotation->owner_guid   = ossn_loggedin_user()->guid;
	$annotation->subject_guid = $subject_guid;
	$annotation->value        = '... any ...'; //empty value result false in addAnnotation
	$annotation->type         = $type;
	
	if ($result = $annotation->addAnnotation()) {
		return $result;
	}
	return false;
	
}
 
 function notificationsample_page($pages){
		
	$notifications = new OssnNotifications();
	
	$redirect = false;
 
    if (empty($pages[0])) {
        ossn_error_page();
    }
	
	//Dummy user cant send message to himself
	if (__notificationsample_dummy_guid__ == ossn_loggedin_user()->guid){
		ossn_trigger_message(ossn_print('notification:message:dummy:failed'), 'error');
		redirect(REF); 
	}
	
	switch ($pages[0]) {
        case 'myself':
			$auxAnnotation = addNotificationSampleAnnotation('notification:message:tomyself','1');

			$who_sent_notification_guid = __notificationsample_dummy_guid__;
			$who_will_receive_notification_guid = ossn_loggedin_user()->guid;

			$subject_guid = $auxAnnotation;
			$item_guid = NULL;
			
			$auxNotifications = $notifications->add('notification:message:tomyself', $who_sent_notification_guid, $auxAnnotation, $item_guid,  $who_will_receive_notification_guid);
			
			if ($auxAnnotation && $auxNotifications){
				error_log("success!");
				$redirect = true;
			} else {
				error_log("Result of auxAnnotation is ".print_r($auxAnnotation,true));
				error_log("Result of auxNotifications is ".print_r($auxNotifications,true));
			}
			break;
		default:
			break;
	}
	if ($redirect){
		redirect('home');
	} else {
		ossn_trigger_message(ossn_print('notification:message:failed'), 'error');
		redirect(REF); 
	}
 }
 
 ossn_register_callback('ossn', 'init', 'notificationsample_init');
