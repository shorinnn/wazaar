<?php namespace Delivered\Events;

use Delivered\Events\Event;

use Illuminate\Queue\SerializesModels;

use Delivered\EmailRequest;
class EmailRequestWasMade extends Event {

	use SerializesModels;

	public $emailRequest;

	public function __construct(EmailRequest $emailRequest)
	{
		$this->emailRequest = $emailRequest;
	}

}
