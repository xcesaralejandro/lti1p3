@extends('lti1p3::templates.app')
@section('content')
    <h1 class="text-center">LTI 1.3</h1>
    <h6 class="text-center">Launched as Resource Link Request</h6>
    <hr/>
    <div class="container">
      <table>
        <tr>
          <th class="font-weight-normal">Title</th>
          <td class="font-weight-light">{{$title}}</td>
        </tr>
        <tr>
          <th class="font-weight-normal">Description:</th>
          <td class="font-weight-light">{{$description}}</td>
        </tr>
        <tr>
          <th class="font-weight-normal">Custom data:</th>
          <td class="font-weight-light">{{$custom}}</td>
        </tr>
        <tr>
          <th class="font-weight-normal">Instance id (Local):</th>
          <td class="font-weight-light">{{$lti1p3_instance->id}}</td>
        </tr>
        <tr>
          <th class="font-weight-normal">User id:</th>
          <td class="font-weight-light">{{$lti1p3_instance->user->id}}</td>
        </tr>
        <tr>
          <th class="font-weight-normal">User lti id:</th>
          <td class="font-weight-light">{{$lti1p3_instance->user->lti_id}}</td>
        </tr>
        <tr>
          <th class="font-weight-normal">User:</th>
          <td class="font-weight-light">{{$lti1p3_instance->user->name}}</td>
        </tr>
      </table>
      <br />
      <br />
      <p class="caption">Here you have all the data of the instance, only that I was lazy to render everything.</p>
    </div>
@endsection