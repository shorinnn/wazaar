<?php namespace Delivered\Handlers\Events;

use Delivered\EmailRequest;
use Delivered\Events\EmailRequestWasMade;

use Delivered\Helpers\EmailDispatcher;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class ProcessEmailRequest {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  EmailRequestWasMade  $event
	 * @return void
	 */
	public function handle(EmailRequestWasMade $event)
	{
        $emailDispatcher = new EmailDispatcher();

        if ($event->emailRequest){
            if ($event->emailRequest->requestType == EmailRequest::TYPE_IMMEDIATE){
                $emailDispatcher->sendFromRequest($event->emailRequest);
            }
        }
	}

}
