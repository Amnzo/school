<?php

/*
|--------------------------------------------------------------------------
| Powered by EasySchool Free v2.0
|--------------------------------------------------------------------------
|
| EasySchool Free v2.0 is School management system 
| The modification or sale of this copy is not permitted. 
| Any attempt to change or delete programming rights Expose yourself to judicial follow-up.
| www.dabach.net
| dabach.net@gmail.com
|
*/



// ------> language
Route::get('/lang', ['uses'=>'HomeController@language']);

// ------> sitemap
Route::get('/sitemap.xml', 'HomeController@sitemap');


Route::group(['before'=>'closed'], function(){
	
	// ------> home
	Route::get('/', ['as'=>'home', 'uses'=>'HomeController@showWelcome']);

	
});

Route::get('logout', ['as'=>'users.logout', 'uses'=>'UserController@logout']);

//--------> if users in auth redirect to home
Route::group(['before'=>'user_in_auth'], function(){



		// ------> login
		Route::get('login', ['as'=>'users.login', 'uses'=>'UserController@login']);
		Route::post('check', ['as'=>'users.check', 'uses'=>'UserController@check']);

		// ------> password
		Route::get('password/reset', ['as'=>'remind_users_reset', 'uses'=>'PasswordController@remind']);
		Route::post('password/reset', ['as'=>'remind_password_request', 'uses'=>'PasswordController@request']);
		Route::get('password/reset/{token}', ['as'=>'remind_password_reset', 'uses'=>'PasswordController@reset']);
		Route::post('password/reset/{token}', ['as'=>'remind_password_update', 'uses'=>'PasswordController@update']);

});




Route::group(['before'=>'db_connected'], function(){
	Route::get('install', ['as'=>'install', 'uses'=>'HomeController@install']);
	Route::get('install/step2', ['as'=>'install_s2', 'uses'=>'HomeController@install_s2']);
});
Route::post('install/step2', ['as'=>'install_s2_db', 'uses'=>'HomeController@install_s2_db']);
Route::group(['before'=>'installed'], function(){
	Route::get('install/step3', ['as'=>'install_s3', 'uses'=>'HomeController@install_s3']);
	Route::post('install/step3', ['as'=>'install_s3_db', 'uses'=>'HomeController@install_s3_db']);
});
Route::get('install/step4', ['as'=>'install_s4', 'uses'=>'HomeController@install_s4']);




// ------> closing mode
Route::get('close', ['as'=>'close', 'uses'=>'HomeController@close']);


//--> only users can access
Route::group(['before'=>'auth'], function(){

	Route::post('/p-{id}/comment/store', ['as'=>'comment_store', 'uses'=>'ArticlesController@comment_store']);
	Route::post('/comment/{id}/delete', ['as'=>'comment_delete', 'uses'=>'ArticlesController@comment_delete']);


	Route::get('/ajax-class',function () {

		$class_id = Input::get('class_id');
		$classes = DB::table('users')->where('class_id','>',0)->where('class_id','=',$class_id)->lists('id', 'fullname');
		return Response::json($classes);
	});



});



//--> only admin can access here
Route::group(['before'=>'admin'], function(){
	
	Route::get('admin', ['as'=>'panel.admin', 'uses'=>'AdminController@index']);

	

	// -------> students
	Route::get('admin/students', ['as'=>'admin_students', 'uses'=>'StudentsController@all_students']);
	Route::get('admin/students/new', ['as'=>'create_student', 'uses'=>'StudentsController@create']);
	Route::post('admin/students/new', ['as'=>'store_student', 'uses'=>'StudentsController@store']);
	Route::get('admin/student/{id}/profile', ['as'=>'profile_student', 'uses'=>'StudentsController@profile']);
	Route::get('admin/student/{id}/edit', ['as'=>'student_edit', 'uses'=>'StudentsController@edit']);
	Route::post('admin/student/{id}/edit', ['as'=>'update_student', 'uses'=>'StudentsController@update']);
	Route::post('admin/student/{id}/edit_pass', ['as'=>'update_password_student', 'uses'=>'StudentsController@update_password']);
	Route::get('admin/student/{id}/delete', ['as'=>'student_delete', 'uses'=>'StudentsController@destroy']);

	


	// -------> teachers
	Route::get('admin/teachers', ['as'=>'admin_teachers', 'uses'=>'TeachersController@all_teachers']);
	Route::get('admin/teachers/new', ['as'=>'create_teacher', 'uses'=>'TeachersController@create']);
	Route::post('admin/teachers/new', ['as'=>'store_teacher', 'uses'=>'TeachersController@store']);
	Route::get('admin/teacher/{id}/profile', ['as'=>'profile_teacher', 'uses'=>'TeachersController@profile']);
	Route::get('admin/teacher/{id}/edit', ['as'=>'teacher_edit', 'uses'=>'TeachersController@edit']);
	Route::post('admin/teacher/{id}/edit', ['as'=>'update_teacher', 'uses'=>'TeachersController@update']);
	Route::post('admin/teacher/{id}/edit_pass', ['as'=>'update_password_teacher', 'uses'=>'TeachersController@update_password']);
	Route::get('admin/teacher/{id}/delete', ['as'=>'teacher_delete', 'uses'=>'TeachersController@destroy']);


	// -------> classes
	Route::get('admin/classes', ['as'=>'admin_classes', 'uses'=>'ClassesController@index']);
	Route::post('admin/classes/new', ['as'=>'store_class', 'uses'=>'ClassesController@store']);
	Route::get('admin/class/{id}/delete', ['as'=>'class_delete', 'uses'=>'ClassesController@destroy']);
	Route::post('admin/classes/{id}/update', ['as'=>'class_update', 'uses'=>'ClassesController@update']);



	// -------> subjects
	Route::get('admin/subjects', ['as'=>'admin_subjects', 'uses'=>'SubjectsController@index']);
	Route::post('admin/subjects/new', ['as'=>'store_subject', 'uses'=>'SubjectsController@store']);
	Route::get('admin/subject/{id}/delete', ['as'=>'subject_delete', 'uses'=>'SubjectsController@destroy']);
	Route::post('admin/subject/{id}/update', ['as'=>'subject_update', 'uses'=>'SubjectsController@update']);



	// -------> settings
	Route::get('admin/settings', ['as'=>'admin_settings', 'uses'=>'AdminController@settings']);
	Route::post('admin/settings/update', ['as'=>'settings_update', 'uses'=>'AdminController@settings_update']);
	Route::post('admin/settings/admin', ['as'=>'update_admin', 'uses'=>'AdminController@update_admin']);
	Route::post('admin/settings/admin/password', ['as'=>'admin_password', 'uses'=>'AdminController@admin_password']);


	


});

//--> only student can access here
Route::group(['before'=>'student'], function(){



	Route::get('students', ['as'=>'student_panel', 'uses'=>'StudentsController@index']);	
	Route::get('students/subjects', ['as'=>'student_subjects', 'uses'=>'StudentsController@subjects']);	
	Route::get('students/teachers', ['as'=>'student_teachers', 'uses'=>'StudentsController@teachers']);	
	


	Route::get('students/exams', ['as'=>'student_exams', 'uses'=>'StudentsController@exams']);
	Route::get('students/marks', ['as'=>'student_marks', 'uses'=>'StudentsController@marks']);

	Route::get('students/profile', ['as'=>'student_edit_profile', 'uses'=>'StudentsController@edit_profile']);
	Route::post('students/profile', ['as'=>'student_update_profile', 'uses'=>'StudentsController@update_profile']);
	Route::post('students/profile/password', ['as'=>'student_update_password', 'uses'=>'StudentsController@student_update_password']);


});

//--> only teacher can access here
Route::group(['before'=>'teacher'], function(){

	

	Route::get('teachers', ['as'=>'teacher_panel', 'uses'=>'TeachersController@index']);
	Route::get('teachers/subjects', ['as'=>'teacher_subjects', 'uses'=>'TeachersController@subjects']);

	Route::get('teachers/students', ['as'=>'teacher_students', 'uses'=>'TeachersController@find_students']);
	Route::get('teachers/student/{id}/profile', ['as'=>'teacher_p_student', 'uses'=>'TeachersController@student_profile']);
	


	Route::get('teachers/exams', ['as'=>'teacher_exams', 'uses'=>'TeachersController@exams']);
	Route::post('teachers/exams/new', ['as'=>'teacher_store_exam', 'uses'=>'TeachersController@exam_store']);
	Route::get('admin/exams/{id}/delete', ['as'=>'exam_delete', 'uses'=>'TeachersController@exam_destroy']);

	Route::get('teachers/marks', ['as'=>'teacher_marks', 'uses'=>'TeachersController@marks']);
	Route::post('teachers/marks/new', ['as'=>'teacher_store_mark', 'uses'=>'TeachersController@mark_store']);
	Route::get('admin/marks/{id}/delete', ['as'=>'mark_delete', 'uses'=>'TeachersController@mark_destroy']);


	Route::get('teachers/profile', ['as'=>'teacher_edit_profile', 'uses'=>'TeachersController@edit_profile']);
	Route::post('teachers/profile', ['as'=>'teacher_update_profile', 'uses'=>'TeachersController@update_profile']);
	Route::post('teachers/profile/password', ['as'=>'teacher_update_password', 'uses'=>'TeachersController@teacher_update_password']);




});







