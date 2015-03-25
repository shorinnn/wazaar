<?php

class FrontpageVideosController extends \BaseController {
        
        public function __construct(){
            $this->beforeFilter('admin');
        }

	/**
	 * Display a listing of the resource.
	 * GET /frontpagevideos
	 *
	 * @return Response
	 */
	public function index()
	{
		$videos = FrontpageVideo::all();
                $courses = Course::where('publish_status','approved')->where('privacy_status','public')->orderBy('name','ASC')->get();
                return View::make('administration.frontpage_videos.index')->with( compact('videos', 'courses') );
	}


	/**
	 * Store a newly created resource in storage.
	 * POST /frontpagevideos
	 *
	 * @return Response
	 */
	public function store()
	{
            $html = '';
            $i = Input::get('i');
            $courses = Course::where('publish_status','approved')->where('privacy_status','public')->orderBy('name','ASC')->get();
            for($j = 0; $j < 9; ++$j){
                $type = ($j == 8) ? 'big' : 'small';
                $id = ($j == 0) ? ($i+1) : 0;
                $video = FrontpageVideo::create( ['course_id' => $id, 'type' => $type] );
                ++$i;
                $html .= View::make('administration.frontpage_videos.partials.video')->with( compact('video', 'i', 'courses') )->render();
                
            }
            return $html;
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /frontpagevideos/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
                FrontpageVideo::batchUpdate( Input::get('video') );
		return json_encode( ['status'=>'success'] );
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /frontpagevideos/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
            $videos = FrontpageVideo::where('id', '>=', Input::get('start') )->orderBy('id','asc')->limit(9)->get();
            foreach($videos as $vid){
                $vid->delete();
            }
	}

}