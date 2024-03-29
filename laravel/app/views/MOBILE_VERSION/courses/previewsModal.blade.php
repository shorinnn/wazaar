<div class="modal fade" id="existing-previews-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('crud/labels.or_use_existing') }}</h4>
            </div>
            <div class="modal-body clearfix">

                <div id="modal-body-videos">

                    <div class="row">
                        <div class="radio-buttons clearfix">

                                @foreach($images as $img)
                                    {{ View::make('courses.preview_image')->with(compact('img')) }}
                                @endforeach

                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="btn-close-previews" class="btn btn-default" data-dismiss="modal">{{trans('crud/labels.close')}}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="ajax-loader-wrapper" class="hidden">
    <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
</div>

