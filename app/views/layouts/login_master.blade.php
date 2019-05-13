<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('metaTages')
    <link rel="icon" href="{{ url() }}/images/favicon.png" />
    <title>@yield('title')</title>
    {{ HTML::style('css/bootstrap.css') }}
    {{ HTML::style('css/bootstrap-theme.min.css') }}
    {{ HTML::style('fonts/font-awesome/css/font-awesome.css') }}
    {{ HTML::style('css/style.css') }}
    {{ HTML::script('js/jquery-1.11.3.min.js') }}

    @if(Session::get('language') == 'ar')
      {{ HTML::style('css/bootstrap-rtl.min.css') }}
      {{ HTML::style('css/rtl.css') }}
    @endif
   
  </head>

<body style="background: #f2f2f2 url('{{ url() }}/images/bg.png');">

<?php $control = Control::find(1); ?>
<?php $path = Session::get('language'); ?>
<div class="top-bar navbar">
<div class="container-fluid">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      
    </div> 

    <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1" aria-expanded="false">
        
        @if(Session::get('language') == 'ar') 
        <ul class="nav navbar-nav contact-info navbar-right"> @else <ul class="nav navbar-nav contact-info navbar-left"> @endif
        
          <li><i class="fa fa-envelope"></i> {{ $control->email }} | </li>
          <li><i class="glyphicon glyphicon-phone"></i> {{ $control->phone }}</li>
        </ul>


        @if(Session::get('language') == 'ar') 
        <ul class="nav navbar-nav navbar-left"> @else <ul class="nav navbar-nav navbar-right"> @endif
        
          @if (Auth::check()) 
            @if(Auth::user()->is_admin)
              <li class="center"><a href="{{ URL::route('panel.admin') }}"><span class="fa fa-dashboard "></span> {{ Lang::get($path.'.Control_Panel') }}</a></li>
              <li class="center"><a href="{{ URL::route('users.logout') }}"><span class="glyphicon glyphicon-log-out"></span>  {{ Lang::get($path.'.logout') }}</a></li>
            @endif
            @if(Auth::user()->is_student)
              <li class="center"><a href="{{ URL::route('student_panel') }}"><span class="fa fa-dashboard "></span> {{ Lang::get($path.'.Control_Panel') }}</a></li>
              <li class="center"><a href="{{ URL::route('users.logout') }}"><span class="glyphicon glyphicon-log-out"></span>  {{ Lang::get($path.'.logout') }}</a></li>
            @endif
            @if(Auth::user()->is_teacher)
              <li class="center"><a href="{{ URL::route('teacher_panel') }}"><span class="fa fa-dashboard "></span> {{ Lang::get($path.'.Control_Panel') }}</a></li>
              <li class="center"><a href="{{ URL::route('users.logout') }}"><span class="glyphicon glyphicon-log-out"></span>  {{ Lang::get($path.'.logout') }}</a></li>
            @endif
            @if(Auth::user()->is_parent)
             <li class="center"><a href="{{ URL::route('parent_panel') }}"><span class="fa fa-dashboard "></span> {{ Lang::get($path.'.Control_Panel') }}</a></li>
             <li class="center"><a href="{{ URL::route('users.logout') }}"><span class="glyphicon glyphicon-log-out"></span>  {{ Lang::get($path.'.logout') }}</a></li>
            @endif
          @else 
            <li class="center"><a href="{{ URL::route('users.login') }}"><span class="glyphicon glyphicon-lock"></span> {{ Lang::get($path.'.login') }}</a></li>

            <li class="center"><a data-toggle="modal" data-target="#LgModal" href="#"><span class="glyphicon glyphicon-globe"></span> {{ Lang::get($path.'.language') }}</a></li>
            
          @endif

        </ul>

        

    </div>
 

<style type="text/css">
  
.modal-lang ul { list-style: none; }  
.modal-lang ul li { display: inline; margin: 5px; }  

</style>

<!-- Modal -->
<div class="modal fade" id="LgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body modal-lang">
        <ul>
          <li><a href="{{ URL::to('/lang?set=ar') }}">{{ HTML::image('images/arabic.png', '', [ 'width'=>'48px']) }}</a></li>
          <li><a href="{{ URL::to('/lang?set=fr') }}">{{ HTML::image('images/francais.png', '', [ 'width'=>'48px']) }}</a></li>
          <li><a href="{{ URL::to('/lang?set=en') }}">{{ HTML::image('images/english.png', '', [ 'width'=>'48px']) }}</a></li>
        </ul>
      </div>
    </div>
  </div>
</div> 

</div>
</div>

<div class="clear"></div>



<div class="clear"></div>

<div class="navbar navbar-default" style="margin-bottom: 0px;">
<div class="container-fluid"> 
 
    <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="nav navbar-nav navbar-left">
          <a href="{{ URL::route('home') }}">{{ HTML::image('images/logo.png', '', ['class'=>'img-responsive img-logo', 'width'=>'340px']) }}</a>
        </div>
    </div>

   

</div>
</div>

<div class="clear"></div>


<div class="container-fluid">

    <div class="col-md-12">
      @yield('content')
    </div>

</div>




     
     {{ HTML::script('js/bootstrap.min.js') }}
     {{ HTML::script('js/validator/validator.js') }}
</body>
</html>
