<?php

class ClassesController extends BaseController {



	public function index()
	{
		$classes = TheClass::orderBy('id', 'desc')->paginate(15);

		return View::make('admin.classes', compact('classes'));
	}


	public function store()
	{
		if (Request::ajax()){

	
			$inputs = Input::all();
			$validation = Validator::make($inputs, ['name'=>'required']);
			if ($validation->fails()) {
				return 'false';
			} 

			else {
	
				$class = TheClass::create([

					'name' => e($inputs['name']),
					'note' => e($inputs['note'])

				]);

				return 'true';
			}

        }
	}


	public function update($id)
	{
		if (Request::ajax()){

			$inputs = Input::all();
			$validation = Validator::make($inputs, ['name'=>'required']);
			if ($validation->fails()) {
				return 'false';
			} 

			else {
				$class = TheClass::find($id);

				$class->name = e($inputs['name']);
				$class->note = e($inputs['note']);
				$class->save();

				return 'true';
			}

        }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		
		$class = TheClass::find($id);

		if ($class !== null) {

			// remove as class from students table
			$as_class = User::where('class_id', $class->id)->get();
			foreach ($as_class as $class) {
				$class->class_id = 0;
				$class->save();
			}

			// delete all marks of this class
			$marks = Marks::where('class_id', $class->id)->get();
			foreach ($marks as $mark) {
				$mark->delete();
			}

			// remove subjects from this class
			$subjects = Subject::where('class_id', $class->id)->get();
			foreach ($subjects as $subject) {
				$subject->class_id = 0;
				$subject->save();
			}

			// delete all lessons of this class
			$lessons = Lesson::where('class_id', $class->id)->get();
			foreach ($lessons as $lesson) {
				$lesson->delete();
			}


			// delete all exams of this class
			$exams = Exam::where('class_id', $class->id)->get();
			foreach ($exams as $exam) {
				$exam->delete();
			}

			$class->delete();

			$path = Session::get('language');
			return Redirect::back()->with('success', Lang::get($path.'.Deleted_successfully'));
		} 

		else {
			return Redirect::back();
		}

		

		
	}


}
