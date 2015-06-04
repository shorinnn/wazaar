<?php namespace Delivered\Helpers;

use Delivered\EmailRequest;
use Delivered\Events\EmailWasDispatched;

class EmailDispatcher {

    public function sendFromRequest(EmailRequest $emailRequest)
    {
        if ($emailRequest){
            $templateInterface = app()->make('Delivered\Repositories\Template\TemplateInterface');

            $template = $templateInterface->find($emailRequest->templateId);

            if ($template){
                $messageBody = $template->body;

                if (count($emailRequest->bodyVariables) > 0){
                    foreach($emailRequest->bodyVariables as $placeholder => $value){
                        $messageBody = str_replace('@' . $placeholder .'@',$value, $messageBody);
                    }
                }

                $receiverEmail = $emailRequest->user->email;

                $result = \Mail::send('emails.body', compact('messageBody'), function ($message) use($template, $receiverEmail) {
                    $message->from($template->fromAddress, $template->fromName);
                    $message->subject($template->subject);
                    $message->to($receiverEmail);
                });

                event(new EmailWasDispatched($emailRequest,$result->json()[0]));
            }


        }
    }
}