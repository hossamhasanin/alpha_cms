@extends('layouts.app')

@section('content')

<section class="content">

  {{ Form::open(["url" => "dashboard/add"]) }}

    {{ Form::text("name[]" , "") }}
    {{ Form::text("type[]" , "") }}

    {{ Form::submit("send") }}

  {{ Form::close() }}
</section>

@endsection
