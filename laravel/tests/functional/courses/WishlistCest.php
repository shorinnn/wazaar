<?php 
use \FunctionalTester;

class WishlistCest{
    
    public function _before(FunctionalTester $I){
        $I->haveEnabledFilters();
    }

    public function redirectIfNotLoggedIn(FunctionalTester $I){
        $I->dontSeeAuthentication();
        $course = Course::where('name','App Development')->first();
        $I->amOnPage('/courses/'.$course->slug);
        $I->click('Add to Wishlist');
        $I->seeCurrentUrlEquals('/login');
    }
    
    public function addToWishlist(FunctionalTester $I){
        $user = Student::where('username','mac')->first();
        $course = Course::first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/courses/'.$course->slug);
        $I->dontSeeRecord('wishlist_items',['student_id' => $user->id, 'course_id' => $course->id]);
        $I->click('Add to Wishlist');
        $I->seeRecord('wishlist_items',['student_id' => $user->id, 'course_id' => $course->id]);
    }
    
    public function addToWishlistOnlyOnce(FunctionalTester $I){
        $user = Student::where('username','mac')->first();
        $course = Course::first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/courses/'.$course->slug);
        $I->dontSeeRecord('wishlist_items',['student_id' => $user->id, 'course_id' => $course->id]);
        $I->click('Add to Wishlist');
        $I->seeRecord('wishlist_items',['student_id' => $user->id, 'course_id' => $course->id]);
        $I->amOnPage('/courses/'.$course->slug);
        $I->click('Add to Wishlist');
        $item = WishlistItem::where('student_id', $user->id)->where('course_id',$course->id)->count();
        $I->assertEquals(1, $item);
    }
    
    public function viewUsersWishlist(FunctionalTester $I){
        $user = Student::where('username','mac')->first();
        $course = Course::first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/courses/'.$course->slug);
        $I->dontSeeRecord('wishlist_items',['student_id' => $user->id, 'course_id' => $course->id]);
        $I->click('Add to Wishlist');
        $I->seeRecord('wishlist_items',['student_id' => $user->id, 'course_id' => $course->id]);
        $I->logout();
        $I->amOnPage("/student/$user->email/wishlist");
        $I->see("$user->first_name $user->last_name's wishlist");
    }
    
    public function deleteWishlistItem(FunctionalTester $I){
        $user = Student::where('username','mac')->first();
        $course = Course::first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/courses/'.$course->slug);
        $I->dontSeeRecord('wishlist_items',['student_id' => $user->id, 'course_id' => $course->id]);
        $I->click('Add to Wishlist');
        $I->seeRecord('wishlist_items',['student_id' => $user->id, 'course_id' => $course->id]);
        $I->amOnPage("/student/wishlist");
        $item = WishlistItem::where('student_id', $user->id)->first();
        $I->click('delete-wishlist-item-'.$item->id);
        $I->assertEquals(0, WishlistItem::where('student_id', $user->id)->count() );
    }
    
    public function failDeletingItem(FunctionalTester $I){
        WishlistItem::Boot();
        $user = Student::where('username','mac')->first();
        $course = Course::first();
        $I->amLoggedAs($user);
        $I->seeAuthentication();
        $I->amOnPage('/courses/'.$course->slug);
        $I->dontSeeRecord('wishlist_items',['student_id' => $user->id, 'course_id' => $course->id]);
        $I->click('Add to Wishlist');
        $I->assertEquals(1, WishlistItem::count() );
        $item = WishlistItem::where('student_id', $user->id)->first();
        $I->logout();
        $user = Student::where('username', 'sorin')->first();
        $I->sendAjaxPostRequest(action('WishlistController@destroy', $item->id), ['_action' => 'DELETE', '_token' =>  csrf_token() ]);
        $I->assertEquals(1, WishlistItem::count() );        
    }
    
}