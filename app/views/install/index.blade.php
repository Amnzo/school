@extends('layouts.install_master')

@section('title') EasySchool Free v2.0 @stop

@section('content')
<div class="col-md-8 col-md-offset-2">

<div class="steps">
            <div class="col-md-3 text-center item item">
               <i class="fa fa-plug"></i>
            </div>

            <div class="col-md-3 text-center item item_noset">
               <i class="fa fa-database"></i>
            </div>

            <div class="col-md-3 text-center item item_noset">
               <i class="fa fa-cogs"></i>
            </div>

            <div class="col-md-3 text-center item item_noset">
               <i class="fa fa-check-circle"></i>
            </div>
</div>

<div class="clear"></div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">EasySchool Terms and conditions</h3>
  </div>
  <div class="panel-body">


<div class="form-group">
<div class="input-group">
<span class="input-group-addon"><i class="fa fa-info-circle"></i></span>
{{ Form::textarea('terms', '.:: Terms and conditions ::.

1 - All copyrights reserved for the EasySchool are not licensed to be copied, modified, or developed for trading. 

2 - EasySchool Free 2.0 Lifetime Scripting License is that you have the right to use the licensed script for ever, and you are not entitled to sell or trade it.

3 - Technical Support Service is a service provided only for Pro versions to support script and solve problems or errors that are scripted.

4 - You can request additional development, special editing, or special software add-on from any other party Except the official site of the script.

5 - System works in safety and the user is responsible for protecting his / her data and passwords.

6 - Terms and conditions may change at any time.

7 - Any attempt to change or delete programming rights Expose yourself to judicial follow-up.', ['rows'=>'12', 'class'=>'form-control']) }} 
</div>
</div>


<p style="font-size: 18px;"><span class="label label-danger">CAUTION: Any attempt to change or delete programming rights Expose yourself to judicial follow-up</span></p>

<hr>


<div class="pull-right">
	<a  class="btn btn-info" href="{{ url() }}/install">I accept the terms and conditions</a>
</div>



  </div>
</div>


<span class="help-block center">Copyright &copy; 2016-2018 EasySchool v2.0 | All Rights Reserved.</span>


</div>
@stop