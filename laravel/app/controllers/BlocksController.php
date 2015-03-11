<?php

class BlocksController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'instructor' );
            $this->beforeFilter('csrf', ['only' => [ 'saveText', 'destroy', 'uploadFiles', 'update']]);
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
            if(!Input::hasFile('file')) return json_encode(['status'=>'error', 'errors' => '1'.trans('crud/errors.error_occurred') ]); 
            $block = new Block();
            $block->lesson_id = $lesson_id;
            $block->type = 'file';
            if( $block->upload( Input::file('file')->getRealPath() ) ){
                if($block->save()){
                    return json_encode(['status'=>'success', 'html' => View::make('courses.blocks.file')->with(compact('block'))->render() ]);
                }
                else{
                    return json_encode(['status'=>'error', 'errors' => '2'.trans('crud/errors.error_occurred') ]); 
                }
            }
            else{
                return json_encode(['status'=>'error', 'errors' => '3'.trans('crud/errors.error_occurred') ]); 
            }
        }
        
        public function destroy($lesson_id, $id){
            $block = Block::find($id);
            if($block!=null && ($block->lesson->id == $lesson_id || $block->lesson->module->course->instructor->id == Auth::user()->id ) ){
                $block->delete();
                $response = ['status' => 'success'];
                return json_encode($response);
            }
            $response = ['status' => 'error', 'errors' => trans('crud/errors.cannot_delete_object', 'Block') ];
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


        return View::make('courses.blocks.video')->with(compact('block', 'lessonId', 'video'));
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


}
