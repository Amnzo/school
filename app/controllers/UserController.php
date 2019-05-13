<?php

class UserController extends BaseController {

	protected $layouts = 'layouts.master';

	protected $user_rules = [

			'user_type'=>'required',
			'fullname'=>'required',
			'username'=>'required|min:3|unique:users',
			'email'=>'email|unique:users',
			'password'=>'required|min:4',
			'password_confirm'=>'required|same:password'

	];

	public function login()
	{
		return View::make('users.login');
	}

	public function logout() {

		Auth::logout();
		return Redirect::route('home');

	}


	public function check()
	{
		$inputs = Input::all();


		if (Input::get('remember')) {
			$remember = true;
		} else { $remember = false; }

		$username = e($inputs['username']);
		$password = e($inputs['password']);

		$validation = Validator::make($inputs, ['username'=>'required', 'password'=>'required']);

		if ($validation->fails()) {

			return Redirect::back()->withErrors($validation);

		} else {

			if (Auth::attempt(['username'=>$username, 'password'=>$password], $remember)) {

				Auth::attempt(['username'=>$username, 'password'=>$password], $remember);

				if (Auth::check()) {

					if(Auth::user()->is_admin) {
						return Redirect::route('panel.admin');
					}
					elseif(Auth::user()->is_student) {
						return Redirect::route('student_panel');
					}
					elseif(Auth::user()->is_teacher) {
						return Redirect::route('teacher_panel');
					}
					elseif(Auth::user()->is_parent) {
						return Redirect::route('parent_panel');
					} 
					else {
						return Redirect::route('home');
					}
					
					
				}
				
				

			} else {

				$path = Session::get('language');
				return Redirect::back()->with('error', Lang::get($path.'.username_or_password_error'));


			}
		}

	}




}
