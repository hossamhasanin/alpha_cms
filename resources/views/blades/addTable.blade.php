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
              <label for="exampleInputPassword1">Label Names</label>
              {{ Form::text("labels_name" , "" , ["class" => "form-control" , "placeholder" => "Table name"]) }}
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Icon</label>
              {{ Form::text("icon" , "" , ["class" => "form-control" , "placeholder" => "Table name"]) }}
            </div>
            <hr>
            <div id="fields">
              <div class="row">

                  <div class="col-xs-3 col-md-3">
                    <input class="form-control" placeholder="Field Name" type="text">
                  </div>
                  <div class="col-xs-3 col-md-3">
                    <select class="form-control" name="fild_type[]">
                        <option value="type">Type</option>
                        <option value="type2">Type2</option>
                    </select>
                  </div>
                  <div class="col-xs-3 col-md-3">
                    <input class="form-control" placeholder="Label Name" type="text">
                  </div>
                  <div class="col-xs-3 col-md-3">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="nullable[]">
                        Nullable
                      </label>
                    </div>
                  </div>
                  <!-- <div class="col-xs-3 col-md-3">
                    <div class="btn btn-danger" id="remove_field">Remove</div>
                  </div> -->
            </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                <div class="btn btn-success" id="add_field">Add Field</div>
              </div>
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

<script type="text/javascript">
 $(document).ready(function(){
   var i = 0;
   var field = "<div class='row'><div class='col-xs-3 col-md-3'><input class='form-control' placeholder='Field Name' type='text'></div><div class='col-xs-3 col-md-3'><select class='form-control' name='fild_type[]'><option value='type'>Type</option><option value='type2'>Type2</option></select></div><div class='col-xs-3 col-md-3'><input class='form-control' placeholder='Label Name' type='text'></div><div class='col-xs-3 col-md-3'><div class='checkbox'><label><input type='checkbox' name='nullable[]'>Nullable</label></div></div></div>"
    $("#add_field").click(function () {
        $("#fields").append(field);
    });
});
</script>

@endsection
