<?php

class TeachersController extends BaseController {


	protected $rules = [

			'fullname'=>'required',
			'username'=>'required|min:3|unique:users',
			'email'=>'email|unique:users',
			'password'=>'required|min:4',
			'password_confirm'=>'required|same:password',
			'image'=>'image|max:1000'

	];

	public function index()
	{	
		return View::make('users.index');
	}

	
	public function all_teachers()
	{	
		
		$inputs = Input::all();
		$text_query = e(Input::get('q'));

		if (!empty($text_query)) {
	
			$teachers = User::where('is_teacher', true);

			if(Input::has('q')) {
				$teachers->where('fullname', 'like', '%' .$text_query. '%');
			}

			$teachers = $teachers->paginate(15);

			return View::make('admin.teachers', compact('teachers'), [ 'teachers' => $teachers->appends(Input::except('page')) ]);
		} 

		else {
			$teachers = User::where('is_teacher', true)->orderBy('fullname', 'asc')->paginate(15);
			return View::make('admin.teachers', compact('teachers'));
		}
	}



	public function profile($id)
	{
		$user = User::find($id);
		if ($user !== null) {
			return View::make('admin.user_profile', compact('user'));
		} else {
			return Redirect::route('admin_teachers');
		}
	}



	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.new_teacher');
		
	}


	public function store()
	{
			$inputs = Input::all();

			$validation = Validator::make($inputs, $this->rules); 

			if ($validation->fails()) {

				return Redirect::back()->withInput()->withErrors($validation);

			} else {

				if (Input::hasFile('image')) {

					$image = Input::file('image');

					$destinationPath = 'uploads/profiles/teachers';

					$filename = $image->getClientOriginalName();
					$filename = strtolower($filename);
					$filename = str_ireplace(' ', '_', $filename);
					$filename = round(microtime(true)).'_'. $filename;

					$upload_success = $image->move($destinationPath, $filename);

					$user = User::create([
						
						'is_teacher' => 1,

						'fullname' => e(Input::get('fullname')),
						'gender' => e(Input::get('gender')),
						'username' => e(Input::get('username')),
						'password' => Hash::make(e(Input::get('password'))),

						'address' => e(Input::get('address')),
						'email' => e(Input::get('email')),
						'phone' => e(Input::get('phone')),
						'image' => $filename

					]);

				} else {

					$user = User::create([

						'is_teacher' => 1,

						'fullname' => e(Input::get('fullname')),
						'gender' => e(Input::get('gender')),
						'username' => e(Input::get('username')),
						'password' => Hash::make(e(Input::get('password'))),

						'address' => e(Input::get('address')),
						'email' => e(Input::get('email')),
						'phone' => e(Input::get('phone'))
					]);

				}

				
				$user->save();

				$path = Session::get('language');
				return Redirect::back()->with('success', Lang::get($path.'.success_added'));
			}
	}



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);
		if ($user !== null) {
			return View::make('admin.update_teacher', compact('user'));
		} else {
			return Redirect::route('admin_teachers');
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = User::find($id);
		if ($user !== null) {

			$inputs = Input::all();

			$validation = Validator::make($inputs, ['image'=>'image']);  

			if ($validation->fails()) {

				return Redirect::back()->withInput()->withErrors($validation);

			} else {
			
			if (Input::hasFile('image')) {

					// delete old image
					if (!empty($user->image)) {
						unlink(public_path()."/uploads/profiles/teachers/".$user->image);
					}
					
					$image = Input::file('image');

					$destinationPath = 'uploads/profiles/teachers';

					$filename = $image->getClientOriginalName();
					$filename = strtolower($filename);
					$filename = str_ireplace(' ', '_', $filename);
					$filename = round(microtime(true)).'_'. $filename;

					$upload_success = $image->move($destinationPath, $filename);

					$user->fullname = e($inputs['fullname']);
					$user->gender = e($inputs['gender']);
					
					$user->address = e($inputs['address']);
					$user->email = e($inputs['email']);
					$user->phone = e($inputs['phone']);
					$user->image = $filename;


				} else {

					$user->fullname = e($inputs['fullname']);
					$user->gender = e($inputs['gender']);

					$user->address = e($inputs['address']);
					$user->email = e($inputs['email']);
					$user->phone = e($inputs['phone']);

				}

				
				$user->save();

				$path = Session::get('language');
				return Redirect::back()->withSuccess(Lang::get($path.'.Modified_successfully'));

			}


		} else {
			return Redirect::route('admin_teachers');
		}
	}


	
	public function update_password($id)
	{
		$user = User::find($id);
		if ($user !== null) {

			$inputs = Input::all();
			
			$user->password = Hash::make(e(Input::get('password')));
			$user->save();

			$path = Session::get('language');
			return Redirect::back()->withSuccess(Lang::get($path.'.Modified_successfully'));

		} else {
			return Redirect::route('admin_teachers');
		}
	}


	public function destroy($id)
	{
		$user = User::find($id);

		if ($user !== null) {

			// delete comments
			$comments = Comment::where('user_id', $user->id)->delete();

			

			// delete exams
			$exams = Exam::where('teacher_id', $user->id)->delete();

			// delete lessons
			$lessons = Lesson::where('teacher_id', $user->id)->delete();
			

			// delete marks
			$marks = Marks::where('teacher_id', $user->id)->delete();

			// remove form subjects
			$subjects = Subject::where('teacher_id', $user->id)->get();
			foreach ($subjects as $subject) {
				$subject->teacher_id = 0;
				$subject->save();
			}


			// delete image
	        if (!empty($user->image)) {
	            unlink(public_path()."/uploads/profiles/teachers/".$user->image);
	        }

			$user->delete();

			$path = Session::get('language');
			return Redirect::back()->with('success', Lang::get($path.'.Deleted_successfully'));

		} 

		else {
			return Redirect::back();
		}
	}



	/*--------------------------------------------------------------------------*/


	public function subjects()
	{	
		
		$user_id = Auth::user()->id;

		$subjects = Subject::where('teacher_id', $user_id)->orderBy('id', 'desc')->paginate(15);

		return View::make('teachers.subjects', compact('subjects'));
	}


	public function find_students()
	{	
		$inputs = Input::all();
		$text_query = e(Input::get('q'));

		if (!empty($text_query)) {
	
			$students = User::where('is_student', true);

			if(Input::has('q')) {
				$students->where('fullname', 'like', '%' .$text_query. '%')->orWhere('registration_num', $text_query);
			}

			$students = $students->paginate(15);

			return View::make('teachers.students', compact('students'), [ 'students' => $students->appends(Input::except('page')) ]);
		} 

		else {
			return View::make('teachers.students');
		}
	}


	public function student_profile($id)
	{	
		$user = User::find($id);
		if ($user !== null) {
			return View::make('teachers.user_profile', compact('user'));
		} else {
			return Redirect::route('teacher_students');
		}
		
	}

	public function parent_profile($id)
	{	
		$user = User::find($id);
		if ($user !== null) {
			return View::make('teachers.user_profile', compact('user'));
		} else {
			return Redirect::route('teacher_students');
		}
		
	}


	public function exams()
	{
		$user_id = Auth::user()->id;

		$exams = Exam::where('teacher_id', $user_id)->orderBy('id', 'desc')->paginate(15);
		
		$subjects = $subjects = Subject::where('teacher_id', $user_id)->get();

		$classes_array = array();

		foreach ($subjects as $subject) {
			$classes_array[] = $subject->class_id;
		}

		$classes = TheClass::whereIn('id', $classes_array)->get();

		return View::make('teachers.exams', compact('exams', 'classes', 'subjects'));
	}



	public function exam_store()
	{
		$user_id = Auth::user()->id;

		if (Request::ajax()){

			$inputs = Input::all();
			$validation = Validator::make($inputs, ['class_id'=>'required', 'subject_id'=>'required', 'exam_date'=>'required']);
			if ($validation->fails()) {
				return 'false';
			} 

			else {
	
				$exam = Exam::create([

					'teacher_id' => $user_id,
					'class_id' => e($inputs['class_id']),
					'subject_id' => e($inputs['subject_id']),
					'exam_date' => e($inputs['exam_date']),
					'exam_time' => e($inputs['exam_time'])

				]);

				return 'true';
			}

        }
	}


	public function exam_destroy($id)
	{
		$exam = Exam::find($id);

		$exam->delete();

		$path = Session::get('language');
		return Redirect::back()->with('success', Lang::get($path.'.Deleted_successfully'));
	}




	public function marks()
	{
		$user_id = Auth::user()->id;

		$marks = Marks::where('teacher_id', $user_id)->orderBy('id', 'desc')->paginate(15);
		
		$subjects = $subjects = Subject::where('teacher_id', $user_id)->get();

		$classes_array = array();

		foreach ($subjects as $subject) {
			$classes_array[] = $subject->class_id;
		}

		$classes = TheClass::whereIn('id', $classes_array)->get();

		return View::make('teachers.marks', compact('classes', 'subjects', 'marks'));
	}



	public function mark_store()
	{
		

		if (Request::ajax()){

			$inputs = Input::all();
			
		

			$validation = Validator::make($inputs, ['subject_id'=>'required', 'class_id'=>'required', 'student_id'=>'required', 'mark'=>'required']);

			if ($validation->fails()) {
				return 'false';
			} 

			else {

				$user_id = Auth::user()->id;

				$mark = Marks::create([

					'teacher_id' => $user_id,
					'class_id' => e($inputs['class_id']),
					'subject_id' => e($inputs['subject_id']),
					'student_id' => e($inputs['student_id']),
					'mark' => e($inputs['mark']),
					'note' => e($inputs['note'])

				]);

				return 'true';
			}

			


        }
	}


	public function mark_destroy($id)
	{
		$mark = Marks::find($id);

		$mark->delete();

		$path = Session::get('language');
		return Redirect::back()->with('success', Lang::get($path.'.Deleted_successfully'));
	}




	/*------------------------------------------------------------------*/

	public function edit_profile()
	{
		$user_id = Auth::user()->id;

		$user = User::find($user_id);

		return View::make('teachers.edit_profile', compact('user'));

		
	}


	public function update_profile()
	{

		$user_id = Auth::user()->id;
		
		$user = User::find($user_id);

		$inputs = Input::all();
		
		$validation = Validator::make($inputs, ['email'=>'email', 'image'=>'image']);

		if ($validation->fails()) {

			return Redirect::back()->withErrors($validation);

		} else {

			
				if (Input::hasFile('image')) {

					// delete old image
					if (!empty($user->image)) {
						unlink(public_path()."/uploads/profiles/teachers/".$user->image);
					}
					
					$image = Input::file('image');

					$destinationPath = 'uploads/profiles/teachers';

					$filename = $image->getClientOriginalName();
					$filename = strtolower($filename);
					$filename = str_ireplace(' ', '_', $filename);
					$filename = round(microtime(true)).'_'. $filename;

					$upload_success = $image->move($destinationPath, $filename);

					$user->address = e($inputs['address']);
					$user->email = e($inputs['email']);
					$user->phone = e($inputs['phone']);
					$user->image = $filename;


				} else {

					$user->address = e($inputs['address']);
					$user->email = e($inputs['email']);
					$user->phone = e($inputs['phone']);

				}

				
				$user->save();

				$path = Session::get('language');
				return Redirect::back()->withSuccess(Lang::get($path.'.Information_modified'));


		}

		
	}



	public function teacher_update_password()
	{

		$user_id = Auth::user()->id;
		
		$user = User::find($user_id);

		$inputs = Input::all();

		$validation = Validator::make($inputs, ['old_password'=>'required', 'password'=>'required|min:4', 'password_confirm'=>'required|same:password']);


		if ($validation->fails()) {

			return Redirect::back()->withErrors($validation);

		} else {

			$old_password = Input::get('old_password');

			if (Hash::check($old_password, $user->password)) {
				
				$user->password = Hash::make($inputs['password']);
				$user->save();

				$path = Session::get('language');
				return Redirect::back()->withSuccess(Lang::get($path.'.Information_modified'));
				
			} 

			else {
				
				$path = Session::get('language');
				return Redirect::back()->withError(Lang::get($path.'.password_error'));
				
			}


		}

		
	}

	/*-------------------------------------------------*/














}
