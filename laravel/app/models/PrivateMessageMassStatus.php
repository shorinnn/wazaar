<?php

class PrivateMessagesMassStatus extends CocoriumArdent {
	protected $fillable = [ 'private_message_id', 'recipient_id', 'status' ];
        public static $rules = [
            'private_message_id' => 'required|unique_with:private_messages_mass_statuses,recipient_id,status'
        ];
        public static $relationsData = [];
}