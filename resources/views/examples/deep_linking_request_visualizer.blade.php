@extends('lti1p3::templates.app')
@section('content')
    <h1 class="text-center">LTI 1.3</h1>
    <h6 class="text-center">Launched as Resource Link Request</h6>
    <hr/>
    <div class="container">
      <p>
        <b>Title:</b><span> {{$title}}</span>
      </p>
      <p>
        <b>Description:</b><span> {{$description}}</span>
      </p>
      <p>
        <b>Custom:</b><span> {{$custom}}</span>
      </p>
    </div>
@endsection