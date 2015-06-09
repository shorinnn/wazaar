<?php namespace Delivered\Handlers\Events;

use Delivered\Events\EmailWasDispatched;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class CreateEmailHistory
{

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
     * @param  EmailWasDispatched $event
     * @return void
     */
    public function handle(EmailWasDispatched $event)
    {
        $emailHistory = app()->make('Delivered\Repositories\EmailHistory\EmailHistoryInterface');
        $history      = [
            'emailRequestId'       => $event->emailRequest->id,
            'mandrillReferenceId'  => $event->mandrillResponse['_id'],
            'mandrillStatus'       => $event->mandrillResponse['status'],
            'mandrillRejectReason' => $event->mandrillResponse['reject_reason']
        ];

        $emailHistory->create($history);
    }

}
