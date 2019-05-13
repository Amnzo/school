@extends('layouts.panel_master')
<?php $path = Session::get('language'); ?>

@section('title') {{ Lang::get($path.'.teachers') }} @stop

@section('content')



<div class="panel panel-default panel-main">
  <div class="panel-body">
    
  <ol class="breadcrumb">
    <li><a href="{{ URL::route('student_panel') }}">{{ Lang::get($path.'.Home') }}</a></li>
    <li class="active">{{ Lang::get($path.'.teachers') }}</li>
  </ol>
  

@if (count($teachers) >= 1)

<div class="clear"></div><hr>


    <div class="table-responsive">
      <table class="table table table-striped table-bordered">
        <thead>
          <tr class="tr">
            <th>#</th>
            <th>{{ Lang::get($path.'.fullname') }}</th>   
          </tr>
        </thead>
        <tbody>



@foreach($teachers as $teacher)

          <tr class="tr-body">

            <td>
            @if(!empty($teacher->image))
            <?php echo HTML::image('uploads/profiles/teachers/'.$teacher->image.'', '', ['class'=>'img-circle', 'width'=>'60px','height'=>'60px']) ?>
            @else
            {{ HTML::image('uploads/profiles/teacher.jpg', '', ['class'=>'img-circle', 'width'=>'60px','height'=>'60px']) }}
            @endif
            </td>

            <td>{{ $teacher->fullname }}</td>


            

          </tr>
@endforeach 

        </tbody>
      </table>
    </div><!-- /.table-responsive -->

    <div class="clear"></div>
    <div class="center">
        {{ $teachers->links() }}
    </div>

@endif

  </div>
</div>



@stop