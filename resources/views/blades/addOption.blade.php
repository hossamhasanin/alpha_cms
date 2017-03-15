@extends("layouts.app")

@section("content")

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add options</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered" id="fields">
                            <tr>
                                <th>Field name</th>
                                <th>Field type</th>
                                <th style="width: 40px">Nullable</th>
                                <th>Visibility</th>
                                <th>Default value</th>
                                <th>Remove</th>
                            </tr>
                            {{ Form::open(["route" => ["store_option" , $table_id]])  }}
                             @foreach($fields_data as $field_data)
                              <tr>
                                <td><input class="form-control f-name f_name-0" value="{{ $field_data->field_name  }}" placeholder="Field Name" name="field_name[]" type="text"></td>
                                <td>
                                    <select class="form-control" name="field_type[]">
                                        <option>chose</option>
                                        <option value="float" {!! $field_data->field_type == "float" ? "selected" : "" !!}>Float</option>
                                        <option value="dateTime" {!! $field_data->field_type == "dateTime" ? "selected" : "" !!}>DateTime</option>
                                        <option value="integer" {!! $field_data->field_type == "integer" ? "selected" : "" !!}>Integer</option>
                                        <option value="longText" {!! $field_data->field_type == "longText" ? "selected" : "" !!}>LongText</option>
                                        <option value="mediumText" {!! $field_data->field_type == "mediumText" ? "selected" : "" !!}>MediumText</option>
                                        <option value="string" {!! $field_data->field_type == "string" ? "selected" : "" !!}>Varchare</option>
                                        <option value="text" {!! $field_data->field_type == "text" ? "selected" : "" !!}>Text</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-slider--b checkbox-slider-md">
                                        <label>
                                            <input name="nullable[]" {!! $field_data->field_nullable == 1 ? "checked" : "" !!} type="checkbox"><span></span>
                                        </label>
                                    </div>
                                </td>
                                  <td>
                                      <div class="checkbox checkbox-slider--b checkbox-slider-md">
                                          <label>
                                              <input type="checkbox"><span></span>
                                          </label>
                                      </div>
                                  </td>
                                <td>
                                    <input class="form-control d_value-0" placeholder="Defualt value" value="{{ $field_data->default_value  }}" name="default_value[]" type="text">
                                </td>
                                <td>
                                    <h4 class="text-danger" style="font-family: 'Mada', sans-serif;">يا عزيزي لا يجب ازالة هدا الحقل</h4>
                                </td>
                            </tr>
                            @endforeach
                            {{ Form::close() }}
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>

@endsection