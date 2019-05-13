@extends('layouts.panel_master')

<?php $path = Session::get('language'); ?>

@section('title') {{ $lesson->title }} @stop

@section('content')


<div class="panel panel-default panel-main">
  <div class="panel-body">
    
  <ol class="breadcrumb">
    <li><a href="{{ URL::route('teacher_panel') }}">{{ Lang::get($path.'.Home') }}</a></li>
    <li><a href="{{ URL::route('teacher_lessons') }}">{{ Lang::get($path.'.lessons') }}</a></li>
    <li class="active">{{ $lesson->title }}</li>
  </ol>
  <div class="clear"></div><hr>


        {{ Form::open(['route'=>['update_lesson', $lesson->id], 'files'=>'true', 'class'=>'col-md-10 col-md-offset-1', 'id'=>'myForm', 'data-toggle'=>'validator'])  }}

       

@if(Session::has('error'))
<div class="alert alert-danger center alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>{{ Session::get('error') }}</strong>
</div>
@endif

@if(Session::has('success'))
<div class="alert alert-success center alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>{{ Session::get('success') }}</strong>
</div>
@endif

<div class="clear"></div>

      
              <div class="form-group">
                <label class="control-label">{{ Lang::get($path.'.title') }} : </label>
                <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                {{ Form::text('title', $lesson->title, ['class'=>'form-control input-lg', 'required'=>'required']) }}
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
                @if($errors->first('title'))
                  <span class="help-block red-color">{{ $errors->first('title') }}</span>
                  @endif
              </div>

              <div class="form-group">
                <label class="control-label">{{ Lang::get($path.'.subject') }} : </label>
                <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-book"></i></span>
  

                <?php $check_subject = Subject::find($lesson->subject_id);

                      $user_id = Auth::user()->id;
                      $subjects_array= Subject::where('teacher_id', $user_id)->lists('name', 'id');  
                ?>
                      @if($check_subject !== null)
                        {{ Form::select('subject_id', array($check_subject->id => $check_subject->name) + $subjects_array + [' ' => '-- null --'], '', ['class'=>'form-control input-lg']) }}
                      @else
                        {{ Form::select('subject_id', array('' => 'select') + $subjects_array, '', ['class'=>'form-control input-lg']) }}
                      @endif


                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>


              <div class="form-group">
                  <label class="control-label">{{ Lang::get($path.'.class') }}  : </label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-blackboard"></i></span>

                    <?php $check_class = TheClass::find($lesson->class_id); ?>

                      @if($check_class !== null)
                        {{ Form::select('class_id', array($check_class->id => $check_class->name) + $classes + [' ' => '-- null --'], '', ['class'=>'form-control input-lg']) }}
                      @else
                        {{ Form::select('class_id', array('' => 'select') + $classes, '', ['class'=>'form-control input-lg']) }}
                      @endif

                  </div>
              </div>

              <div class="form-group">
                <label class="control-label">{{ Lang::get($path.'.content') }}  : </label>
          
                  {{ Form::textarea('content', $lesson->content, ['id'=>'elm1', 'class'=>'form-control', 'rows'=>'6']) }}
             
                @if($errors->first('content'))
                  <span class="help-block red-color">{{ $errors->first('content') }}</span>
                  @endif
              </div>

              <div class="form-group">
                  <label class="control-label">{{ Lang::get($path.'.Attached_File') }} : </label>
                  {{ Form::file('file', ['class'=>'btn btn-default', 'id'=>'file']) }}

                    @if($errors->first('file'))
                      <span class="help-block red-color">{{ $errors->first('file') }}</span>
                    @endif

                    <span class="help-block">Permitted files : doc, docx, ppt, pptx, pdf</span>
              </div>

              <div class="form-group">

                @if(!empty($lesson->jointe))
                  <p class="bg-warning" style="padding: 8px;"><a style="color: #c55; text-decoration: none;" href="{{ url() }}/uploads/lessons/{{ $lesson->jointe }}"><i class="glyphicon glyphicon-paperclip"></i> {{ $lesson->jointe }}</a></p>
                @endif
              </div><br>




            <div class="form-group">
              {{ Form::submit( Lang::get($path.'.save_change') , ['class'=>'btn btn-info btn-block input-lg']) }} 
            </div>


              {{ Form::close() }}

  
  </div>
</div>

<script type="text/javascript">
  $('#myForm').validator();
</script>



{{ HTML::script('js/tinymce/tinymce.min.js') }}

<script>
  tinymce.init({

    relative_urls : false,
    remove_script_host : false,
    convert_urls : true,

    selector: "textarea#elm1",
    theme: "modern",

    plugins: [
      "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
      "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
      "save table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker codesample"
    ],
    content_css: "css/development.css",
    add_unload_trigger: false,
    autosave_ask_before_unload: false,

    toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
    toolbar2: "cut copy paste pastetext | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media help code | insertdatetime preview | forecolor backcolor",
    toolbar3: "table | emoticons",
    
    menubar: false,
    toolbar_items_size: 'small',

    style_formats: [
      {title: 'Bold text', inline: 'b'},
      {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
      {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
      {title: 'Example 1', inline: 'span', classes: 'example1'},
      {title: 'Example 2', inline: 'span', classes: 'example2'},
      {title: 'Table styles'},
      {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ],

    templates: [
      {title: 'My template 1', description: 'Some fancy template 1', content: 'My html'},
      {title: 'My template 2', description: 'Some fancy template 2', url: 'development.html'}
    ],

        spellchecker_callback: function(method, data, success) {
      if (method == "spellcheck") {
        var words = data.match(this.getWordCharPattern());
        var suggestions = {};

        for (var i = 0; i < words.length; i++) {
          suggestions[words[i]] = ["First", "second"];
        }

        success({words: suggestions, dictionary: true});
      }

      if (method == "addToDictionary") {
        success();
      }
    }
  });

 
</script>



@stop