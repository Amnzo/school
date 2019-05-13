<?php

class AdminController extends BaseController {

	protected $rules = [

			'email'=>'email',
			'pagination'=>'integer',
			'payment_tax'=>'integer',
			'news'=>'max:400'

	];


	public function index()
	{	
		$students = User::where('is_student', true)->get();
		$teachers = User::where('is_teacher', true)->get();
		$parents = User::where('is_parent', true)->get();
		$articles = Article::all();
		$allclasses = TheClass::all();

		return View::make('users.index', compact('students', 'teachers', 'parents', 'articles', 'allclasses'));
	}






	public function settings()
	{	
		$control = Control::find(1);
		$user_id = Auth::user()->id;
		$user = User::find($user_id);

		return View::make('admin.settings', compact('control', 'user'));
	}

	public function settings_update()
	{	

		$control = Control::find(1);
		
		$inputs = Input::all();

			$validation = Validator::make($inputs, $this->rules); 

			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);

			} else {

				$control->school_name = e($inputs['school_name']);
				$control->email = e($inputs['email']);
				$control->phone = e($inputs['phone']);
				$control->address = e($inputs['address']);

				$control->facebook = e($inputs['facebook']);
				$control->twitter = e($inputs['twitter']);
				$control->youtube = e($inputs['youtube']);
				$control->google_plus = e($inputs['google_plus']);

				$control->paginate = e($inputs['pagination']);

				$control->description = e($inputs['description']);
				$control->keywords = e($inputs['keywords']);
				$control->news = e($inputs['news']);

				$control->closing_msg = e($inputs['closing_msg']);
				$control->close_site = e($inputs['close_site']);

				$control->marquee_rtl = e($inputs['marquee_rtl']);
				
				
				$control->save();


				$path = Session::get('language');
				return Redirect::back()->withSuccess(Lang::get($path.'.Modified_successfully'));
			}
	}





	public function update_admin()
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
						unlink(public_path()."/uploads/profiles/".$user->image);
					}
					
					$image = Input::file('image');

					$destinationPath = 'uploads/profiles';

					$filename = $image->getClientOriginalName();
					$filename = strtolower($filename);
					$filename = str_ireplace(' ', '_', $filename);
					$filename = round(microtime(true)).'_'. $filename;

					$upload_success = $image->move($destinationPath, $filename);

		
					$user->email = e($inputs['email']);
					$user->image = $filename;


				} else {
					$user->email = e($inputs['email']);
				}

				
				$user->save();

				$path = Session::get('language');
				return Redirect::back()->withSuccess(Lang::get($path.'.Modified_successfully'));


		}

	}


	public function admin_password()
	{
		
		$path = Session::get('language');

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

				return Redirect::back()->withSuccess(Lang::get($path.'.Information_modified'));
				
			} 

			else {
				
				return Redirect::back()->withError(Lang::get($path.'.password_error'));
				
			}


		}

		
	}


/*-------------- pages -------------------*/
	
	protected $page_rules = [

			'name'=>'required|max:25',
			'content'=>'required'

	];

	protected function make_slug($string = null, $separator = "-") {
	    if (is_null($string)) {
	        return "";
	    }

	    $string = trim($string);
	    $string = mb_strtolower($string, "UTF-8");;
	    $string = preg_replace("/[^a-z0-9_\s-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/u", "", $string);
	    $string = preg_replace("/[\s-]+/", " ", $string);
	    $string = preg_replace("/[\s_]/", $separator, $string);

	    return $string;
	}



	public function pages()
	{	
		$pages = Page::orderBy('id', 'desc')->paginate(15);

		return View::make('admin.pages', compact('pages'));
	}



	public function page_create()
	{	
		return View::make('admin.new_page');
	}



	public function page_store()
	{	
			$inputs = Input::all();

			$validation = Validator::make($inputs, $this->page_rules);

			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);
			} 

			else {
		
					$page = Page::create([

					'name'=>e($inputs['name']),
					'slug'=>$this->make_slug($inputs['name']),
					'content'=>e($inputs['content'])
					
					]);

				$page->save();

				$path = Session::get('language');
				return Redirect::back()->with('success', Lang::get($path.'.success_added'));

			}
	}


	public function page_edit($id)
	{
		$page = Page::find($id);

		if ($page !== null) {
			return View::make('admin.update_page', compact('page'));
		} else {
			return Redirect::back('admin_pages');
		}

	}


	public function page_update($id)
	{	
		$page = Page::find($id);

		if ($page !== null) {
			
			$inputs = Input::all();

			$validation = Validator::make($inputs, $this->page_rules);

			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);
			} 

			else {

				$page->name = e($inputs['name']);
				$page->slug = $this->make_slug($inputs['name']);
				$page->content = e($inputs['content']);
				$page->save();

				$path = Session::get('language');
				return Redirect::back()->withSuccess(Lang::get($path.'.Modified_successfully'));

			}


		} else {
			return Redirect::back('admin_pages');
		}
	}

	public function page_destroy($id)
	{	
		$page = Page::find($id);
		$page->delete();

		$path = Session::get('language');
		return Redirect::back()->with('success', Lang::get($path.'.Deleted_successfully'));
	}




	



}
