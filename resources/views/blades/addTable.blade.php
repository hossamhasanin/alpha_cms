@extends('layouts.app')

@section('content')
<script type="text/javascript">
  function remove_it(e) {
    var field_num = $(e).attr("num");
    $(".field-"+field_num).remove();
  }
</script>
<section class="content">

  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Quick Example</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {{ Form::open(["route" => "add_field"]) }}
          <div class="box-body">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
              {{ Form::text("module_name" , "" , ["class" => "form-control" , "placeholder" => "Table name"]) }}
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Icon</label>
              <input class="icp demo form-control" name="icon" type="text">
            </div>
            <hr>
            <div id="fields">
              <div class="row">

                  <div class="col-xs-3 col-md-3">
                    <input class="form-control" placeholder="Field Name" name="field_name[]" type="text">
                  </div>
                  <div class="col-xs-2 col-md-2">
                    <select class="form-control" name="field_type[]">
                        <option>chose</option>
                        <option value="float">Float</option>
                        <option value="dateTime">DateTime</option>
                        <option value="integer">Integer</option>
                        <option value="longText">LongText</option>
                        <option value="mediumText">MediumText</option>
                        <option value="string">Varchare</option>
                        <option value="text">Text</option>
                    </select>
                  </div>
                  <div class="col-xs-3 col-md-3">
                    <input class="form-control" placeholder="Label Name" name="label_name[]" type="text">
                  </div>
                  <div class="col-xs-2 col-md-2">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="nullable[]">
                        Nullable
                      </label>
                    </div>
                  </div>
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

    $("#add_field").click(function () {
        i += 1
        var field = "<div class='row field-"+ i +"'><div class='col-xs-3 col-md-3'><input class='form-control' placeholder='Field Name' name='field_name["+ i +"]' type='text'></div><div class='col-xs-2 col-md-2'><select class='form-control' name='fild_type["+ i +"]'><option>chose</option><option value='float'>Float</option><option value='dateTime'>DateTime</option><option value='integer'>Integer</option><option value='longText'>LongText</option><option value='mediumText'>MediumText</option><option value='string'>Varchare</option<option value='text'>Text</option></select></div><div class='col-xs-3 col-md-3'><input class='form-control' placeholder='Label Name' name='label_name[]' type='text'></div><div class='col-xs-1 col-md-1'><div class='checkbox'><label><input type='checkbox' name='nullable["+ i +"]'>Nullable</label></div></div><div class='col-xs-2 col-md-2'><div class='btn btn-danger remove_field pull-right' onclick='remove_it(this)' num= "+ i +">Remove</div></div></div>"
        $("#fields").append(field);
    });

    $('.demo').iconpicker();

});
</script>

@endsection
