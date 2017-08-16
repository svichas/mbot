# mbot
PHP library for handling a messenger bot.


## Usage

```php

require 'mbot.php';

$mbot = new mbot;

//creating a callBack on a message
$mbot->callBack(function($message,$sender_id,$sender_name) {

	//callBack return will be send as a message.
	return "Thanks for sending a message ". $sender_name;
});


//getting message information.
$sender_name = $mbot->getSenderName();
$sender_id = $mbot->sender_id();
$message = $mbot->getMessage();


//sending a message
$mbot->sendMessage("Hi!");


```


