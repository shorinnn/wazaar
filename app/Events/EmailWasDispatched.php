<?php namespace Delivered\Events;

use Delivered\EmailRequest;
use Delivered\Events\Event;

use Illuminate\Queue\SerializesModels;

class EmailWasDispatched extends Event {

	use SerializesModels;

    public $emailRequest;
    public $mandrillResponse;

    /**
     * @param EmailRequest $emailRequest
     * @param array $mandrillResponse
     */
	public function __construct(EmailRequest $emailRequest, $mandrillResponse = [])
	{
		$this->emailRequest = $emailRequest;
        $this->mandrillResponse = $mandrillResponse;
	}
}