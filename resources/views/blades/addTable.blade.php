@extends('layouts.app')

@section('content')

<section class="content">

  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Quick Example</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {{ Form::open(["route" => "add"]) }}
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Table name</label>
              {{ Form::text("table_name" , "" , ["class" => "form-control" , "placeholder" => "Table name"]) }}
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Link name</label>
              {{ Form::text("link_name" , "" , ["class" => "form-control" , "placeholder" => "Table name"]) }}
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Slug name</label>
              {{ Form::text("slug" , "" , ["class" => "form-control" , "placeholder" => "Table name"]) }}
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Model name</label>
              {{ Form::text("model_name" , "" , ["class" => "form-control" , "placeholder" => "Table name"]) }}
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Icon</label>
              {{ Form::text("icon" , "" , ["class" => "form-control" , "placeholder" => "Table name"]) }}
            </div>
            <div class="form-group">
              <label for="exampleInputFile">File input</label>
              <input type="file" id="exampleInputFile">

              <p class="help-block">Example block-level help text here.</p>
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox"> Check me out
              </label>
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
          {{ Form::close() }}
      </div>
    </div>
  </div>

</section>

@endsection
