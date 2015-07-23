<?php

class BlocksController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'instructor' );
            $this->beforeFilter('csrf', ['only' => [ 'saveText', 'uploadFileszzz', 'update']]);
        }
        
        public function text($lesson_id){
            $block = Block::firstOrCreate(['lesson_id' => $lesson_id, 'type' => 'text']);
            return View::make('courses.blocks.text')->with(compact('block'));
        }
        
        public function saveText($lesson_id, $block_id){
            $block = Block::find($block_id);
            if( $block!=null && ($block->lesson->id == $lesson_id || $block->lesson->module->course->instructor->id == Auth::user()->id ) ){
                $block->content = Input::get('content');
                $block->save();
                return json_encode(['status'=>'success']);
            }
            return json_encode(['status'=>'error', 'errors' => trans('crud/errors.error_occurred') ]);
            
        }
        
        public function files($lesson_id){
            $lesson = Lesson::find($lesson_id);
            return View::make('courses.blocks.files')->with(compact('lesson_id'))->with(compact('lesson'));
        }
        
        public function uploadFiles($lesson_id){
            // make sure the upload limit hasn't been reached
            $lesson = Lesson::find($lesson_id);
            if( $lesson->blocks()->where('type','file')->count() > Config::get('custom.maximum_lesson_files') ){
                return json_encode(['status'=>'error', 'errors' => trans('courses/general.max_upload_error') ]); 
            }
            
            $url = Block::presignedUrlFromKey( Input::get('key') );
            $mime = mimetype( $url );

//            dd($mime);
//            return json_encode(['status'=>'error', 'errors' => trans('crud/errors.error_occurred').'[2]' ]); 
            
            $block = new Block();
            $block->lesson_id = $lesson_id;
            $block->type = 'file';
            $block->key = Input::get('key');
            $block->mime = $mime;
            $block->content = Input::get('content');
            $block->name = filenameFromS3Key( $block->key );
            $block->size = '';
            if($block->save()){
                return json_encode(['status'=>'success', 'html' => View::make('courses.editor.v2.file')->withFile($block)->render() ]);
//                return json_encode(['status'=>'success', 'html' => View::make('courses.blocks.file')->with(compact('block'))->render() ]);
            }
            else{
                return json_encode(['status'=>'error', 'errors' => trans('crud/errors.error_occurred').'[2]' ]); 
            }
        }
//        public function uploadFiles($lesson_id){
//            // make sure the upload limit hasn't been reached
//            $lesson = Lesson::find($lesson_id);
//            if( $lesson->blocks()->where('type','file')->count() > Config::get('custom.maximum_lesson_files') ){
//                return json_encode(['status'=>'error', 'errors' => trans('courses/general.max_upload_error') ]); 
//            }
////            dd( Input::file() );
//            if(!Input::hasFile('file')) return json_encode(['status'=>'error', 'errors' => trans('crud/errors.error_occurred').'[1]' ]); 
//            $block = new Block();
//            $block->lesson_id = $lesson_id;
//            $block->type = 'file';
//            if( $block->upload( Input::file('file')->getRealPath() ) ){
//                if($block->save()){
//                    return json_encode(['status'=>'success', 'html' => View::make('courses.blocks.file')->with(compact('block'))->render() ]);
//                }
//                else{
//                    return json_encode(['status'=>'error', 'errors' => trans('crud/errors.error_occurred').'[2]' ]); 
//                }
//            }
//            else{
//                return json_encode(['status'=>'error', 'errors' => trans('crud/errors.error_occurred').'[3]' ]); 
//            }
//        }
        
        public function destroy($lesson_id, $id){
            $block = Block::find($id);
            if($block!=null && ($block->lesson->id == $lesson_id || $block->lesson->module->course->instructor->id == Auth::user()->id ) ){
                $block->delete();
                $response = ['status' => 'success'];
                return json_encode($response);
            }
            $response = ['status' => 'error', 'errors' => trans( ['crud/errors.cannot_delete_object' => 'Block'] ) ];
            return json_encode($response);
        }
        
        public function update($lesson_id, $id){
            $block = Block::find($id);
            if($block!=null && ($block->lesson->id == $lesson_id || $block->lesson->module->course->instructor->id == Auth::user()->id ) ){
                $name = Input::get('name');
                $block->$name = Input::get('value');
                $block->save();
                $response = ['status' => 'success'];
                return json_encode($response);
            }
            $response = ['status' => 'error', 'errors' =>  trans('crud/errors.cannot_save_object', ['object'  => 'Block' ]) ];
            return json_encode($response);
        }

     /**
     * Add Course lesson video form. Loaded via ajax
     * @param $lessonId
     */
    public function video($lessonId)
    {
        $block = Block::firstOrCreate(['lesson_id' => $lessonId, 'type' => Block::TYPE_VIDEO]);
        $video = null;
        if (is_numeric($block->content)){
            $video = Video::getByIdAndPreset($block->content);
        }

        $awsPolicySig = UploadHelper::AWSPolicyAndSignature();
        $uniqueKey = Str::random(8);
        $lesson = Lesson::find($lessonId);
        return View::make('courses.blocks.video')->with(compact('block', 'lessonId', 'video','awsPolicySig','uniqueKey','lesson'));
    }

    public function saveVideo($lessonId)
    {
        if ($lessonId AND Input::has('blockId')){
            $blockId = Input::get('blockId');
            $block = Block::find($blockId);
            $block->content = Input::get('videoId');
            $block->save();
        }
    }

    public function assignVideo($lessonId)
    {
        $block = Block::firstOrCreate(['lesson_id' => $lessonId, 'type' => Block::TYPE_VIDEO]);
        $block->content = Input::get('videoId');
        $block->save();
    }
    
    public function size($id){
        $file = Block::find($id);
        return json_encode( ['val'=> $file->size(), 'id' => $id] );
    }


}
