<div class="modal fade" id="videos-archive-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{trans('video.choose_file')}}</h4>
            </div>
            <div class="row no-margin">
                <div class="form-group no-margin search-wrap clearfix">
                    <div class="filter-wrap col-xs-8 col-sm-10 col-md-10 col-lg-10">
                        <input type="text" name="videoFilter" id="videoFilter" placeholder="Search file name ..." class="form-control">
                        <button id="btnGoFilterVideo"><i class="wa-search"></i></button>
                    </div>
                    <div class="toggle-menus block text-right inline-block col-xs-4 col-sm-2 col-md-2 col-lg-2">
                        <a href="#" class="menu menu-1"><i class="fa fa-th"></i></a>
                        <a href="#" class="menu menu-2"><i class="fa fa-th-list"></i></a>
                    </div>
                </div>
            </div>
            <div class="modal-body no-padding clearfix">

                <div id="modal-body-videos">

                    <div class="video-list-container">
                        <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="default-button large-button" data-dismiss="modal">{{trans('crud/labels.close')}}</button>
                <button type="button" class="blue-button large-button disabled" id="btn-use-video">{{trans('video.choose')}}</button>
                <button type="button" class="btn btn-danger disabled" id="btn-delete-video">{{trans('crud/labels.delete')}}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="ajax-loader-wrapper" class="hidden">
    <div align="center" class="margin-top-15"><img src="{{url('images/ajax-loader.gif')}}" alt=""/></div>
</div>