<div class="modal fade" id="videos-acrhive-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{trans('video.myVideos')}}</h4>
            </div>
            <div class="modal-body clearfix">

                <div id="modal-body-videos">
                    <div class="row">
                        <div class="form-group">
                            <input type="text" name="videoFilter" id="videoFilter" placeholder="Filter" class="form-control">
                            <button id="btnGoFilterVideo">Go</button>
                        </div>
                    </div>

                    <div class="video-list-container">

                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('crud/labels.close')}}</button>
                <button type="button" class="btn btn-primary disabled" id="btn-use-video">{{trans('video.useVideo')}}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->