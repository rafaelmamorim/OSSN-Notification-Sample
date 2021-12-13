# OSSN-Notification-Sample

This component sent a notification message to logged in user. This component is created for better understanding of OSSN notification system. The idea is send a notification alert to logged user and click in the message open user profile. 

I following instructions from https://www.opensource-socialnetwork.org/discussion/view/2967/how-to-send-notifications-to-users-using-ossnnotifications-class?offset=1 as starting point.
 
## How to use

By definition of the notification system, isn't allowed to user create a self notification. So, to make this function running properly, it's necessary to create a dummy user and change "__notificationsample_dummy_guid__" value into ossn_com.php. I will keep in 1, but you need to change. Or test with another user account. Otherwise, OSSN show an error message.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[OSSN](http://www.opensource-socialnetwork.org/licence)