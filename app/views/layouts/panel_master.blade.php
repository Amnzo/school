<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="icon" href="{{ url() }}/images/favicon.png" />
    <title>@yield('title')</title>
    {{ HTML::style('css/bootstrap.css') }}
    {{ HTML::style('css/bootstrap-theme.min.css') }}
    {{ HTML::style('fonts/font-awesome/css/font-awesome.css') }}
    {{ HTML::script('js/jquery-1.11.3.min.js') }}

    @if(Session::get('language') == 'ar')
      {{ HTML::style('css/bootstrap-rtl.min.css') }}
      {{ HTML::style('css/rtl.css') }}
    @endif

    {{ HTML::style('css/style.css') }}
   
  </head>

<body>

<?php $path = Session::get('language'); ?>

  <div class="navbar navbar-default panel-nav">
      
        <div class="container-fluid">
          
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>      
                <span class="icon-bar"></span>  
                <span class="icon-bar"></span>  
                <span class="icon-bar"></span>          
              </button> 
              <a href="{{ URL::route('home') }}">{{ HTML::image('images/logo.png', '', ['class'=>'img-responsive img-logo', 'width'=>'210px']) }}</a>
             </div>

            <div class="collapse navbar-collapse">   

              @if(Session::get('language') == 'ar') 
              <ul class="navbar-left"> @else <ul class="navbar-right"> @endif                
              
                <li class="dropdown">
                  <a href="#" class="btn btn-default btn-sm" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Lang::get($path.'.language') }} <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="{{ URL::to('/lang?set=ar') }}">{{ Lang::get($path.'.arabic') }}</a></li>
                    <li><a href="{{ URL::to('/lang?set=fr') }}">{{ Lang::get($path.'.francais') }}</a></li>
                    <li><a href="{{ URL::to('/lang?set=en') }}">{{ Lang::get($path.'.english') }}</a></li>
                  </ul>
                </li>
                <li><a class="btn btn-danger btn-sm" href="{{ URL::route('users.logout') }}" style="font-size:12px;">{{ Lang::get($path.'.logout') }} <i class="glyphicon glyphicon-log-out"></i></a></li>
              </ul>

            </div>


        </div>

    </div>


<div class="clear"></div>

<div class="container-fluid">
@yield('content')
</div>




     
     {{ HTML::script('js/bootstrap.min.js') }}
     {{ HTML::script('js/validator/validator.js') }}
</body>
</html>
