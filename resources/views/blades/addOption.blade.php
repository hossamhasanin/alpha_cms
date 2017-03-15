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
                            </tr>
                            {{ Form::open(["route" => ["store_option" , $table_id]])  }}
                             @foreach($fields_data as $field_data)
                              <tr>
                                <td><input class="form-control f-name f_name-0" value="{{ $field_data->field_name  }}" placeholder="Field Name" name="field_name[{{ $field_data->id }}]" type="text"></td>
                                <td>
                                    <select class="form-control" name="field_type[{{ $field_data->id }}]">
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
                                            <input name="nullable[{{ $field_data->id }}]" {!! $field_data->field_nullable == 1 ? "checked" : "" !!} type="checkbox"><span></span>
                                        </label>
                                    </div>
                                </td>
                                  <td>
                                      <div>
                                          <label>
                                              <input type="checkbox" @change="chose_all({{ $field_data->id }})" id="check_all-{{ $field_data->id }}" ><span> All</span>
                                          </label>
                                      </div>
                                      <div>
                                          <label>
                                              <input type="checkbox" class="v_check-{{ $field_data->id }}" value="show"><span> show page</span>
                                          </label>
                                      </div>
                                      <div>
                                          <label>
                                              <input type="checkbox" class="v_check-{{ $field_data->id }}" value="add"><span> add page</span>
                                          </label>
                                      </div>
                                      <div>
                                          <label>
                                              <input type="checkbox" class="v_check-{{ $field_data->id }}" value="edit"><span> edit page</span>
                                          </label>
                                      </div>
                                  </td>
                                <td>
                                    <input class="form-control d_value-0" placeholder="Defualt value" value="{{ $field_data->default_value  }}" name="default_value[{{ $field_data->id }}]" type="text">
                                </td>
                            </tr>
                            @endforeach
                        </table>                            
                    </div>
                    <!-- /.box-body -->
                </div>
                  <div class="box-footer">
                    {{ Form::submit("Save" , ["class" => "btn btn-primary"]) }}
                  </div>
                 {{ Form::close() }}
            </div>
        </div>
    </section>

@endsection