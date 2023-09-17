@extends('lti1p3::templates.app')

@section('header')
    @include('lti1p3::templates.navbar')
@endsection

@section('content')
<div class="container">
  <div class="row">
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
      <article class="col-md-8 offset-md-2 bg-white border p-3 mb-3 pb-1 platform-card">
        <header class="d-flex justify-content-between align-items-center">
          <h5 class="font-weight-bold p-0 m-0 d-flex align-items-center">
            @php
              $bubble = $platform->wasLaunched() ? 'bubble-enable' : 'bubble-disable';
            @endphp
            <i class="material-icons {{$bubble}}">circle</i>
            <span class="px-2">{{$platform->local_name}}</span>
          </h5>
          <span class="icon-button">
            <form action="{{route('lti1p3.platforms.destroy', [$platform->id])}}" method="post">
                @method('delete')
                @csrf
                <button type="submit" class="p-0 m-0 bg-white border-0"
                  onclick="return confirm(
                    '{{trans('lti1p3::strings.platform_confirm_delete', 
                      ['name' => $platform->name])}}')">
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
              {{trans('lti1p3::strings.platform_lti_advantage_token_url_label')}}:
            </th>
            <td class="font-weight-light">
              {{$platform->lti_advantage_token_url}}
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
          <tr>
            <th class="font-weight-normal">
              {{trans('lti1p3::strings.platform_deployment_id_autoregister_label')}}:
            </th>
            <td class="font-weight-light">
              {{
                $platform->deployment_id_autoregister ? 
                trans('lti1p3::strings.auto_register_deployments_enable') : 
                trans('lti1p3::strings.auto_register_deployments_disable')
              }}
            </td>
          </tr>
          <tr>
            <th class="font-weight-normal">
              {{trans('lti1p3::strings.platform_deployments_count_label')}}:
            </th>
            <td class="font-weight-light">
               {{$platform->deployments_count}}
            </td>
          </tr>
        </table>
        <footer>
          <div class="d-flex justify-content-center">
            <a href="{{route('lti1p3.deployments.index', ['lti1p3_platform_id' => $platform->id])}}" type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark">
              {{trans('lti1p3::strings.platform_add_new_deployment_button')}}
            </a>
          </div>
          <span class="text-caption font-italic d-flex justify-content-end pt-2">
            {{trans('lti1p3::strings.created_at_label', ['date' => $platform->created_at])}}
          </span>
        </footer>
      </article>
    @endforeach
  </div>
</div>
@endsection