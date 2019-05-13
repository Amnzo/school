@extends('layouts.panel_master')
<?php $path = Session::get('language'); ?>

@section('title') {{ Lang::get($path.'.subjects') }} @stop

@section('content')



<div class="panel panel-default panel-main">
  <div class="panel-body">
    
  <ol class="breadcrumb">
    <li><a href="{{ URL::route('student_panel') }}">{{ Lang::get($path.'.Home') }}</a></li>
    <li class="active">{{ Lang::get($path.'.subjects') }}</li>
  </ol>
  

@if (count($subjects) >= 1)

<div class="clear"></div><hr>


    <div class="table-responsive">
      <table class="table table table-striped table-bordered">
        <thead>
          <tr class="tr">
            <th>{{ Lang::get($path.'.subject') }}</th>                     
            <th>{{ Lang::get($path.'.teacher') }}</th> 
            <th>{{ Lang::get($path.'.note') }}</th>        
          </tr>
        </thead>
        <tbody>


@foreach($subjects as $subject)

          <tr class="tr-body">

            <td>{{ $subject->name }}</td>

            <td>
            @if(!empty($subject->teacher_id))
              {{ $subject->teacher->fullname }}
            @else
            -
            @endif
            </td>

            <td>{{ $subject->note }}</td>


          </tr>

@endforeach 

        </tbody>
      </table>
    </div><!-- /.table-responsive -->

    <div class="clear"></div>
    <div class="center">
        {{ $subjects->links() }}
    </div>

@endif

  </div>
</div>



@stop