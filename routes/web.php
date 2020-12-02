<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//search
Route::get('search', 'SearchController@index')->name('Search');
Route::any('search', 'SearchController@action');

// Authentication

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('/password_recovery_email_input', 'Auth\LoginController@password_recovery_email_input')->name('Password Recovery');
Route::post('/password_recovery_code_input', 'Auth\LoginController@password_recovery_code_input')->name('password_recovery_code_input');
Route::post('/password_recovery_new_pass', 'Auth\LoginController@password_recovery_new_pass')->name('password_recovery_new_pass');
Route::post('password_update','Auth\LoginController@password_update')->name('password_update');


//User
Route::get('/user/{id}','UserController@show')->name('Profile');
Route::get('/edit_user/{id}', 'UserController@edit')->name('Edit_Profile')->middleware(['ProfileOwner']);
Route::patch('/edit_user_action/{id}', 'UserController@update')->name('user.update')->middleware(['ProfileOwner']);
Route::delete('/delete_user/{id}', 'UserController@delete')->name('user.delete')->middleware(['ProfileOwner']);
Route::post('/user/{id}/deleteInvitations','UserController@deleteInvitations')->name('user.deleteInvitations')->middleware(['ProfileOwner']);
Route::post('/user/{id}/deleteNotifications','UserController@deleteNotifications')->name('user.deleteNotifications')->middleware(['ProfileOwner']);
Route::post('/banUser','UserController@ban')->middleware(['Admin']);
Route::post('/deleteUser','UserController@delete')->name('deleteUser')->middleware(['Admin']);


//MAIN PAGES
Route::get('/FAQ','WebController@faq')->name('FAQ');
Route::get('/About','WebController@about')->name('About');
Route::get('/categories','WebController@categories')->name('categories');
Route::get('/create_event','WebController@create_event')->name('create_event');
Route::get('/event/{id}','WebController@event')->name('Event')->middleware(['PrivateEvent']); 
Route::get('/event/{id}/edit','EventController@edit_event')->name('Edit_Event')->middleware(['EventManager']);
Route::get('/event/{id}/ticket','WebController@event_ticket')->name('Ticket')->middleware(['Attendee']);
Route::get('/','WebController@showEvents')->name('Home');




//ACTIONS
Route::post('/create_event','EventController@store');
Route::post('/comment','CommentController@store')->name('comment');
Route::patch('/event/{id}/edit', 'EventController@update')->name('event.update')->middleware(['EventManager']);
Route::delete('/event/{id}/delete_comment/{comment_id}','CommentController@delete')->name('comment.delete')->middleware(['Commenter']);
Route::post('/event/{id}/make_poll','PollController@store')->name('make_poll')->middleware(['PrivateEvent']); 
Route::delete('/event/{id}/delete_poll/{poll_id}','PollController@delete')->name('poll.delete')->middleware(['PollMaker']);
Route::post('/event/{id}/attend','EventController@attend')->name('attend_event')->middleware(['PrivateEvent']); 
Route::post('/event/{id}/remove_attendant','EventController@leave')->name('remove_attendant')->middleware(['EventManager']);
Route::post('/event/{id}/leave','EventController@leave')->name('leave_event')->middleware(['PrivateEvent']); 
Route::delete('/event/{id}/delete','EventController@delete')->name('event.delete')->middleware(['EventManager']);
Route::post('/event/{id}/add_image','EventController@addImage')->name('add_image')->middleware(['EventManager']);
Route::post('/event/{id}/remove_images','EventController@removeImages')->name('reset_images')->middleware(['EventManager']);


//ADMIN 
Route::get('/admin_user_list','AdminController@admin_user_list')->name('User_List')->middleware(['Admin']);
Route::get('/admin_event_list','AdminController@admin_event_list')->name('Event_List')->middleware(['Admin']);
Route::get('/admin_comment_list','AdminController@admin_comment_list')->name('Reports')->middleware(['Admin']);
Route::delete('/admin_user_list/delete/{report_id}','AdminController@delete_report')->name('report.delete')->middleware(['Admin']);
Route::delete('/admin_event_list/delete/{report_id}','AdminController@delete_report')->name('report.delete')->middleware(['Admin']);



////

///PAYPAL
// route for processing payment
Route::post('paypal', 'PaymentController@payWithpaypal');
// route for check status of the payment
Route::get('status', 'PaymentController@getPaymentStatus');

///AJAX
Route::post('/searchAJAX','SearchController@searchAJAX');
Route::post('/invite','WebController@invite');
Route::post('/report','WebController@report');
Route::post('/vote', 'PollController@vote');