{{ View::make('private_messages.partials.mass_message_form')->with( compact('course') )
                            ->withDestination("#announcements .users-comments > .clearfix") }}
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="users-comments" id='ask-teacher'>
                                            <div class="clearfix">
                                            @foreach($announcements as $announcement)
                                                {{ View::make('private_messages.conversation')->withMessage( $announcement ) }}
                                            @endforeach
                                        </div>
                                    <div class="text-center load-remote" data-target='#announcements' data-load-method="fade">
                                        {{$announcements->links()}}
                                    </div>
                                    </div>                        
                                </div>
                            </div>