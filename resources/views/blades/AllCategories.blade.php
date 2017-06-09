@extends("layouts.app")

@section("content")

	<section class="content">
		<div class="row">
			<div class="col-md-12">
			@if (session()->has("cat_success"))
                    <div class="alert alert-success"><h3>{{ session()->get("table_success") }}</h3></div>
            @endif
				<div class="box">
					<div class="box-header">
						<h3 class="box-title"> All Categories</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<tr>
								<th>id</th>
								<th>Name</th>
								<th>Slug</th>
								<th>Parent</th>
								<th>Description</th>
								<th>Icon</th>
								<th>Created at</th>
								<th>Controll</th>
							</tr>
							@foreach($cats as $cat)
								<tr>
									<td>{{ $cat->id }}</td>
									<td>{{ $cat->cat_name }}</td>
									<td>{{ $cat->cat_slug }}</td>
									<td>{{ $cat->parent }}</td>
									<td>{{ substr($cat->description , 0 , 10) }}{{ strlen($cat->description) > 10 ? "...." : "" }}</td>
									<td><i class="fa {{ $cat->icon }}"></i></td>
									<td>{{ date("M j, Y" , strtotime($cat->created_ats)) }}</td>
									<td><div class="btn btn-warning"><i class="fa fa-pencil-square-o"></i> Edit</div> <div class="btn btn-danger"><i class="fa fa-times"></i> Delete</div></td>
								</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

@stop