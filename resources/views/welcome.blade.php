@extends('lti1p3::templates.app')
@section('content')
    <h1 class="text-center mt-5">LTI 1.3 - Current instance</h1>
    <hr/>
    @php
    $cards = [
      'User' => $instance->user->toArray(),
      'Resource' => $instance->resourceLink->toArray(),
      'Context' => $instance->context->toArray(),
      'Platform' => $instance->platform->toArray()];
    @endphp
    <div class="row">
      @foreach($cards as $name => $card)
        <article class="col-md-10 offset-md-1 bg-white border p-3 mb-3 pb-1">
          <header class="d-flex justify-content-between align-items-center">
            <h5 class="font-weight-bold p-0 m-0 d-flex text-center">
              {{$name}}
            </h5>
          </header>
          <hr>
          <table>
            @foreach($card as $key => $value)
            <tr>
              <th class="font-weight-normal">
                {{$key}}:
              </th>
              <td class="font-weight-light">{{$value}}</td>
            </tr>
            @endforeach
          </table>
          <footer>
            <span class="text-caption font-italic d-flex justify-content-end pt-2">
              Creado el: {{$instance->platform->created_at}}
            </span>
          </footer>
        </article>
      @endforeach
    </div>
@endsection