@extends('lti1p3::templates.app')

@section('header')
    @include('lti1p3::templates.navbar')
@endsection

@section('content')
<div class="navbar-height-spacing"></div>
<div class="mt-3 p-3 row">
  @if($platforms->isEmpty())
    <div class="col-md-8 offset-md-2 bg-white border p-5">
      <h3 class="text-center">
        {{trans('lti1p3::strings.platform_not_found')}}
      </h3>
      <div class="d-flex justify-content-center pt-2">
        <a href="{{route('lti1p3.platforms.create')}}" class="btn btn-outline-primary">
          {{trans('lti1p3::strings.platform_add_new_button')}}
        </a>
      </div>
    </div>
  @endif

  @foreach($platforms as $platform)
    <article class="col-md-8 offset-md-2 bg-white border p-3 mb-3 pb-1">
      <header class="d-flex justify-content-between align-items-center">
        <h5 class="font-weight-bold p-0 m-0 d-flex align-items-center">
          @php
            $bubble = $platform->wasLaunched() ? 'bubble-enable' : 'bubble-disable';
          @endphp
          <i class="material-icons {{$bubble}}">circle</i>
          <span class="px-2">{{$platform->record_name}}</span>
        </h5>
        <span>
            <form action="{{route('lti1p3.platforms.destroy', [$platform->id])}}" method="post">
              @method('delete')
              @csrf
              <button type="submit" class="p-0 m-0 bg-white border-0"
                onclick="return confirm(
                  '{{trans('lti1p3::strings.platform_confirm_delete', 
                    ['name' => $platform->record_name])}}')">
                <i class="material-icons">delete</i>
              </button>
            </form>
        </span>
      </header>
      <hr>
      <table>
        <tr>
          <th class="font-weight-normal">
            {{trans('lti1p3::strings.platform_issuer_id_label')}}:
          </th>
          <td class="font-weight-light">{{$platform->issuer_id}}</td>
        </tr>
        <tr>
          <th class="font-weight-normal">
            {{trans('lti1p3::strings.platform_client_id_label')}}:
          </th>
          <td class="font-weight-light">
            {{$platform->client_id}}
          </td>
        </tr>
        <tr>
          <th class="font-weight-normal">
            {{trans('lti1p3::strings.platform_deployment_id_label')}}:
          </th>
          <td class="font-weight-light">
            {{$platform->deployment_id}}
          </td>
        </tr>
        <tr>
          <th class="font-weight-normal">
            {{trans('lti1p3::strings.platform_authorization_url_label')}}:
          </th>
          <td class="font-weight-light">
            {{$platform->authorization_url}}
          </td>
        </tr>
        <tr>
          <th class="font-weight-normal">
            {{trans('lti1p3::strings.platform_authentication_url_label')}}:
          </th>
          <td class="font-weight-light">
            {{$platform->authentication_url}}
          </td>
        </tr>
        <tr>
          <th class="font-weight-normal">
            {{trans('lti1p3::strings.platform_json_webkey_url_label')}}:
          </th>
          <td class="font-weight-light">
            {{$platform->json_webkey_url}}
          </td>
        </tr>
        <tr>
          <th class="font-weight-normal">
            {{trans('lti1p3::strings.platform_signature_method_label')}}:
          </th>
          <td class="font-weight-light">
            {{$platform->signature_method}}
          </td>
        </tr>
      </table>
      <footer>
        <span class="text-caption font-italic d-flex justify-content-end pt-2">
          Creado el: {{$platform->created_at}}
        </span>
      </footer>
    </article>
  @endforeach
</div>
@endsection