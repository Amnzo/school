@extends('layouts.panel_master')
<?php $path = Session::get('language'); ?>

@if(Auth::user()->is_admin)
  @section('title') {{ Lang::get($path.'.Control_Panel') . ' - ' . Lang::get($path.'.admin') }} @stop
@endif

@if(Auth::user()->is_student)
  @section('title') {{ Lang::get($path.'.Control_Panel') . ' - ' . Lang::get($path.'.student') }} @stop
@endif

@if(Auth::user()->is_teacher)
  @section('title') {{ Lang::get($path.'.Control_Panel') . ' - ' . Lang::get($path.'.teacher') }} @stop
@endif


@section('content')


@if(Auth::check())

<div class="panel-main">

@if(Auth::user()->is_admin)


<div class="col-md-12" id="status">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
          <div class="info-box orange-bg">
            <i class="fa fa-graduation-cap"></i><div class="clear"></div>
            <div class="count">{{ count($students) }}</div>
            <div class="title">{{ Lang::get($path.'.student') }}</div>           
          </div><!--/.info-box-->     
        </div><!--/.col-->
        
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
          <div class="info-box red-bg">
            <i class="fa fa-group"></i><div class="clear"></div>
            <div class="count">{{ count($teachers) }}</div>
            <div class="title">{{ Lang::get($path.'.teacher') }}</div>            
          </div><!--/.info-box-->     
        </div><!--/.col-->  
        
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
          <div class="info-box green-bg">
            <i class="fa fa-book"></i><div class="clear"></div>
            <div class="count">{{ count($allclasses) }}</div>
            <div class="title">{{ Lang::get($path.'.classes') }}</div>            
          </div><!--/.info-box-->     
        </div><!--/.col-->

</div>
 <div class="clear"></div><br>

<div class="row url-icons">


    <div class="col-md-3">
      <a href="{{ URL::route('admin_students') }}">
          <div class="link">
            {{ HTML::image('images/icons/student.png', '', ['width'=>'80px']) }}
            <div class="clear"></div><span>{{ Lang::get($path.'.students') }}</span>
         </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="{{ URL::route('admin_teachers') }}">
          <div class="link">
            {{ HTML::image('images/icons/1476216712_nerd.png', '', ['width'=>'80px']) }}
            <div class="clear"></div><span>{{ Lang::get($path.'.teachers') }}</span>
         </div>
      </a>
    </div>


    <div class="col-md-3">
      <a href="{{ URL::route('admin_classes') }}">
          <div class="link">
            {{ HTML::image('images/icons/class.png', '', ['width'=>'80px']) }}
            <div class="clear"></div><span>{{ Lang::get($path.'.classes') }}</span>
         </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="{{ URL::route('admin_subjects') }}">
          <div class="link">
            {{ HTML::image('images/icons/books.png', '', ['width'=>'80px']) }}
            <div class="clear"></div><span>{{ Lang::get($path.'.subjects') }}</span>
         </div>
      </a>
    </div>


    


    <div class="col-md-3">
      <a href="{{ URL::route('admin_settings') }}">
          <div class="link">
            {{ HTML::image('images/icons/1476216425_settings.png', '', ['width'=>'80px']) }}
            <div class="clear"></div><span>{{ Lang::get($path.'.settings') }}</span>
         </div>
      </a>
    </div>

   

</div>


<!--
      Powered by EasySchool Free v2.0 , 
      EasySchool Free v2.0 is School management system
      Any attempt to change or delete programming rights Expose yourself to judicial follow-up. 
      www.dabach.net
      dabach.net@gmail.com
-->

<!-- Copyrights-->
<div class="clear"></div><br><br>
<div class="row">
<div class="footer-copy center container-fluid">
  Copyright &copy; 2017 <?php echo $_SERVER['SERVER_NAME']; ?> | powered by <a href="http://www.dabach.net/easyschool">EasySchool v2.0 </a> | all rights reserved.
</div>
</div>
<!-- @end-Copyrights -->


@endif


@if(Auth::user()->is_student)

<div class="row url-icons">



    <div class="col-md-3">
      <a href="{{ URL::route('student_subjects') }}">
          <div class="link">
            {{ HTML::image('images/icons/books.png', '', ['width'=>'80px']) }}
            <div class="clear"></div><span>{{ Lang::get($path.'.subjects') }}</span>
         </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="{{ URL::route('student_teachers') }}">
          <div class="link">
            {{ HTML::image('images/icons/1476216712_nerd.png', '', ['width'=>'80px']) }}
            <div class="clear"></div><span>{{ Lang::get($path.'.teachers') }}</span>
         </div>
      </a>
    </div>



    <div class="col-md-3">
      <a href="{{ URL::route('student_exams') }}">
          <div class="link">
            {{ HTML::image('images/icons/1305214346_preferences-system-time.png', '', ['width'=>'80px']) }}
            <div class="clear"></div><span>{{ Lang::get($path.'.exams_times') }}</span>
         </div>
      </a>
    </div>

<?php 
$user_id = Auth::user()->id;
$student_count_marks = Marks::where('student_id', $user_id)->where('student_read_stut', 1)->get();
?>

    <div class="col-md-3">
      <a href="{{ URL::route('student_marks') }}">
          <div class="link">
            {{ HTML::image('images/icons/exam.png', '', ['width'=>'80px']) }}
            <div class="clear"></div><span>{{ Lang::get($path.'.exams_marks') }}</span>@if(count($student_count_marks) >= 1) &nbsp;&nbsp;<span class="badge red-bg">{{ count($student_count_marks) }}</span> @endif
         </div>
      </a>
    </div>

    


    <div class="col-md-3">
      <a href="{{ URL::route('student_edit_profile') }}">
          <div class="link">
            {{ HTML::image('images/icons/1476216378_user_info.png', '', ['width'=>'80px']) }}
            <div class="clear"></div><span>{{ Lang::get($path.'.edit_profile') }}</span>
         </div>
      </a>
    </div>

</div>
@endif



@if(Auth::user()->is_teacher)

<div class="row url-icons">



    <div class="col-md-3">
      <a href="{{ URL::route('teacher_subjects') }}">
          <div class="link">
            {{ HTML::image('images/icons/book.png', '', ['width'=>'80px']) }}
            <div class="clear"></div><span>{{ Lang::get($path.'.classes') }} / {{ Lang::get($path.'.subjects') }}</span>
         </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="{{ URL::route('teacher_students') }}">
          <div class="link">
            {{ HTML::image('images/icons/student.png', '', ['width'=>'80px']) }}
            <div class="clear"></div><span>{{ Lang::get($path.'.students') }}</span>
         </div>
      </a>
    </div>

    

    <div class="col-md-3">
      <a href="{{ URL::route('teacher_exams') }}">
          <div class="link">
            {{ HTML::image('images/icons/1305214346_preferences-system-time.png', '', ['width'=>'80px']) }}
            <div class="clear"></div><span>{{ Lang::get($path.'.exams_times') }}</span>
         </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="{{ URL::route('teacher_marks') }}">
          <div class="link">
            {{ HTML::image('images/icons/exam.png', '', ['width'=>'80px']) }}
            <div class="clear"></div><span>{{ Lang::get($path.'.exams_marks') }}</span>
         </div>
      </a>
    </div>


    <div class="col-md-3">
      <a href="{{ URL::route('teacher_edit_profile') }}">
          <div class="link">
            {{ HTML::image('images/icons/1476216378_user_info.png', '', ['width'=>'80px']) }}
            <div class="clear"></div><span>{{ Lang::get($path.'.edit_profile') }}</span>
         </div>
      </a>
    </div>



</div>

@endif



</div>   
@endif 



@stop