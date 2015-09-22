<?php

class PicksController extends \BaseController {

	public function hotPicks()
	{
		return View::make('administration.picks.hot_picks');
	}

	public function wazaarPicks()
	{
		return View::make('administration.picks.wazaar_picks');
	}

	public function loadPicks($type)
	{

		switch($type){
			case 'hot-picks':
				$courses = DB::table('hot_pick_courses')
						->join('courses', 'hot_pick_courses.course_id', '=', 'courses.id')
						->select('courses.name', 'hot_pick_courses.id', 'hot_pick_courses.order')
						->orderBy('hot_pick_courses.order', 'asc')
						->get();
			break;

			case 'wazaar-picks':
				$courses = DB::table('wazaar_pick_courses')
						->join('courses', 'wazaar_pick_courses.course_id', '=', 'courses.id')
						->select('courses.name', 'wazaar_pick_courses.id', 'wazaar_pick_courses.order')
						->orderBy('wazaar_pick_courses.order', 'asc')
						->get();
			break;
		}
		return View::make('administration.picks.listings',  compact('courses', 'type'));
	}

	public function loadCourses($type)
	{
		$data = Request::all();

		switch($type){
			case 'hot-picks':
				$count_selected_courses = DB::table('hot_pick_courses')->count();
				if($count_selected_courses >= 1 ){
					$courses = DB::table('courses')
							->join('hot_pick_courses', 'courses.id', '!=', 'hot_pick_courses.course_id')
							->select('courses.id', 'courses.name')
							->where('courses.name', 'like', '%'.$data['q'].'%')
							->orderBy('hot_pick_courses.order', 'asc')
							->get();
				} else {
					$courses = DB::table('courses')
							->leftJoin('hot_pick_courses', 'courses.id', '!=', 'hot_pick_courses.course_id')
							->select('courses.id', 'courses.name')
							->where('courses.name', 'like', '%'.$data['q'].'%')
							->orderBy('hot_pick_courses.order', 'asc')
							->get();
				}
			break;

			case 'wazaar-picks':
				$count_selected_courses = DB::table('wazaar_pick_courses')->count();
				if($count_selected_courses >= 1 ){
					$courses = DB::table('courses')
							->join('wazaar_pick_courses', 'courses.id', '!=', 'wazaar_pick_courses.course_id')
							->select('courses.id', 'courses.name')
							->where('courses.name', 'like', '%'.$data['q'].'%')
							->orderBy('wazaar_pick_courses.order', 'asc')
							->get();
				} else {
					$courses = DB::table('courses')
							->leftJoin('wazaar_pick_courses', 'courses.id', '!=', 'wazaar_pick_courses.course_id')
							->select('courses.id', 'courses.name')
							->where('courses.name', 'like', '%'.$data['q'].'%')
							->orderBy('wazaar_pick_courses.order', 'asc')
							->get();
				}
			break;
		}

		$output = array();

		$items = array();

		if(count($courses) >= 1){
			foreach($courses as $i => $course){
				$items[$i]['id'] = $course->id;
				$items[$i]['text'] = $course->name;
			}
		}

		$output['items'] = $items;
		echo json_encode($output);
	}

	public function addPicks($type)
	{
		$data = Request::all();

		switch($type){
			case 'hot-picks':
				foreach($data['ids'] as $id){
					$new_order = HotPicks::getLatestOrder();
					$new_data['course_id'] = $id;
					$new_data['order'] = $new_order;

					HotPicks::create($new_data);
				}
			break;

			case 'wazaar-picks':
				foreach($data['ids'] as $id){
					$new_order = WazaarPicks::getLatestOrder();
					$new_data['course_id'] = $id;
					$new_data['order'] = $new_order;

					WazaarPicks::create($new_data);
				}
			break;
		}

		return 'true';
	}

	public function deletePicks($type)
	{
		$data = Request::all();

		switch($type){
			case 'hot-picks':
				foreach($data['cids'] as $id){
					HotPicks::where('id', $id)->delete();
				}
				HotPicks::reorderAll();
			break;

			case 'wazaar-picks':
				foreach($data['cids'] as $id){
					WazaarPicks::where('id', $id)->delete();
				}
				WazaarPicks::reorderAll();
			break;
		}

		return 'true';
	}

	public function orderPicks($type)
	{

		$data = Request::all();

		switch($type){
			case 'hot-picks':
				HotPicks::updateOrder($data['order']);
			break;

			case 'wazaar-picks':
				WazaarPicks::updateOrder($data['order']);
			break;
		}

		return 'true';
	}
}
