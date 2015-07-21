<div class="shr-lesson shr-lesson-{{$lesson->id}}">
    <div class="row lesson-data">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <div class="lesson-name"><span><em></em></span>Lesson {{ $lesson->order }}</div>
            <div class="preview-thumb">

            </div>
            <label class="default-button large-button upload-button">
                <span>Upload new</span>
                <input type="file" hidden=""/>
            </label>
            <a href="#" class="remove-video">Remove video</a>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <div>
                <input type="text" class="lesson-title" placeholder="Enter lesson title" value="{{ $lesson->name }}" >
            </div>
            <div>
                <h6>DESCRIPTION
                    <span class="lead">360 Characters left</span>
                </h6>
                <textarea placeholder="Enter short lesson description...">{{ $lesson->description }}</textarea>
            </div>
            <div>
                <h6>NOTES
                    <span class="lead">360 Characters left</span>
                </h6>
                <textarea placeholder="Add notes..."></textarea>
            </div>
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 switch-buttons">
                    <div class="">
                        <h6>Individual sale <span class="tip" data-toggle="tooltip" data-placement="top" title="Some tips here">?</span></h6>
                        <label class="switch">
                            <input type="checkbox" class="switch-input">
                            <span class="switch-label" data-on="Yes" data-off="No"></span>
                            <span class="switch-handle"></span>
                        </label>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 switch-buttons inactive">
                    <div class="">
                        <h6>Free Preview <span class="tip" data-toggle="tooltip" data-placement="top" title="Some tips here">?</span></h6>
                        <label class="switch">
                            <input type="checkbox" class="switch-input">
                            <span class="switch-label" data-on="Yes" data-off="No"></span>
                            <span class="switch-handle"></span>
                        </label>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 inactive">
                    <div class="clearfix">
                        <h6>Lesson Price <span class="tip" data-toggle="tooltip" data-placement="top" title="Some tips here">?</span></h6>
                        <div class="value-unit-two">
                            <span class="unit">¥</span>
                            <input type="text" class="value">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--    <div class="row file-upload-row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <i class="fa fa-cloud-upload"></i>
            <p class="regular-paragraph">
                Drag & Drop<br> files to upload
            </p>
            <label class="default-button large-button upload-button">
                <i class="fa fa-paperclip"></i>
                <span>Select</span>
                <input type="file" hidden=""/>
            </label>
        </div>                    
    </div>-->
    <div class="row file-upload-row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <i class="fa fa-cloud-upload"></i>
            <p class="regular-paragraph">
                Drag & Drop<br> files to upload
            </p>
            <label class="default-button large-button upload-button">
                <i class="fa fa-paperclip"></i>
                <span>Select</span>
                <input type="file" hidden=""/>
            </label>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 uploaded-files">
            <h6>Files to accompany lesson</h6>
            <ul>
                @foreach( $lesson->blocks()->where('type','file')->get() as $file )
                    <li>
                        
                        <a href="#" class="file-name">
                            @if( strpos( $file->mime, 'image')!== false )
                                <i class="fa fa-file-image-o"></i> 
                            @elseif( strpos( $file->mime, 'pdf' ) !== false )
                                <i class="fa fa-file-pdf-o"></i> 
                            @else
                                <i class='fa fa-file-text'></i>
                            @endif
                            
                            {{ $file->name }}
                        </a>  
                        <span class="file-size">4mb</span>
                        
                        {{ Form::open(array('action' => ['BlocksController@destroy', $file->lesson->id, $file->id], 'method' => 'delete', 
                                    'class' => 'delete-file ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#uploaded-file-'.$file->id )) }}
                                <button type="submit" class="btn btn-danger btn-mini delete-button" data-message="{{ trans('crud/labels.you-sure-want-delete') }}">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                        {{ Form::close() }}
                        
                        <!--<a href="#" class="delete-file"><i class="fa fa-trash-o"></i></a>-->
                        <a href="{{ action('ClassroomController@resource', PseudoCrypt::hash($file->id) ) }}" target="_blank" class="upload-new-file">
                            <i class="fa fa-download"></i>
                        </a>
                    </li>
                @endforeach
                
            </ul>
        </div>                    
    </div>
    <div class="row footer-buttons">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a href="#" class="green-button large-button">Save changes</a>
            <a href="#" class="default-button large-button">Cancel</a>
            <a href="#" class="delete-lesson right"><i class="fa fa-trash-o"></i> Delete this lesson</a>
        </div>
    </div>
</div>