<?php 

class mbot {

	public $sender_id;
	public $sender_name;
	public $message;
	public $token = "";

	function __construct($token="") {
		
		if ($token == "") {
			echo "[Mbot] Please provide mbot __construct function with a facebook api token.";
			die();
		}

		$message_object = json_decode(file_get_contents("php://input"), true);

		$msg_obj = $message_object['entry'][0]['messaging'][0];
		
		$this->token = $token;

		$this->sender_id = $msg_obj['sender']['id'];
		$this->message = $msg_obj['message']['text'];
		$this->sender_name = $this->getConstructSenderName();

	}

	function getConstructSenderName() {
		$url = "https://graph.facebook.com/v2.6/1392413924165254?fields=first_name,last_name&access_token={$this->token}";
		$data = json_decode(file_get_contents($url), true);
		return $data['first_name'] . " " . $data['last_name'];
	}

	function callBack($function) {
		$result = call_user_func_array($function, ["message" => $this->message, "sender_id" => $this->sender_id, "sender_name" => $this->sender_name]);
		$this->sendMessage($result);
		return true;
	}

	function getMessage() {
		return $this->message;
	}

	function getSenderName() {
		return $this->sender_name;
	}


	function getSender() {
		return $this->sender_id;
	}

	function sendMessage($message="") {

		$url = "https://graph.facebook.com/v2.6/me/messages?access_token={$this->token}";

		$data = [
			"recipient" => ["id" => $this->sender_id],
			"message" => ["text" => $message]
		];


		$options = [
			"http" => [
				"method" => "POST",
				"content" => json_encode($data),
				"header" => "Content-Type: application/json\n"
			]
		];

		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);

	}

}