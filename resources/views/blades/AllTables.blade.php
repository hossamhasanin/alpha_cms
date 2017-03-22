@extends("layouts.app")

@section("content")

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">All tables</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>ID</th>
                                <th>Table</th>
                                <th>Status</th>
                                <th>Slug</th>
                                <th>Link name</th>
                                <th>Icon</th>
                                <th>Control</th>
                            </tr>
                             @foreach($all_tables as $table)
                               <tr>
                                    <td>{{ $table->id }}</td>
                                    <td>{{ $table->table }}</td>
                                    <td>{{ $table->status }}</td>
                                    <td>{{ $table->slug }}</td>
                                    <td>{{ $table->link_name }}</td>
                                    <td><i class="fa {{ $table->icon }}"></i></td>
                                    <td><div class="btn btn-warning">Edit</div> <div class="btn btn-danger">Delete</div> @if($table->table != "users") <a href="{{ route('add_option' , $table->slug) }}" class="btn btn-primary">Add Option</a> @endif </td>
                               </tr>
                            @endforeach
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>

@endsection