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
 */
 
$en = array(
	'notification:add:myself' => 'Add notification to myself',
	'ossn:notifications:notification:message:tomyself' => 'This is a notification message to myself',
	'notification:message:failed' => 'An attempt to create a notification message failed',
	'notification:message:dummy:failed' => 'Dummy user can\'t send notification to himself. Try with another user or change "__notificationsample_dummy_guid__" variable into components\\NotificationSample\\ossn_com.php file',
	
);
ossn_register_languages('en', $en);