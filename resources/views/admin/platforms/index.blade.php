@extends('lti1p3::templates.dashboard')

@section('content')
  <h3 class="fw-normal text-uppercase mb-4">{{trans('lti1p3::lti1p3.platform_title')}}</h3>
  <div class="d-flex mb-4">
    <a href="{{route('lti1p3.platforms.create')}}" type="button" class="btn btn-secondary btn-sm d-flex align-content-center">
      <span class="material-icons me-2">add</span>
      <span>{{trans('lti1p3::lti1p3._new')}}</span>
    </a>
  </div>
  <div class="table-responsive bg-white rounded p-3">
    <h2 class="h6 mb-4">{{trans('lti1p3::lti1p3.platform_availables_title')}}</h2>
    @if(count($platforms) > 0)
      <table class="table caption-top">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">Name</th>
            <th scope="col">{{trans('lti1p3::lti1p3.platform_deployments_count_label')}}</th>
            <th scope="col">{{trans('lti1p3::lti1p3.platform_deployment_id_autoregister_label')}}</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($platforms as $platform)
          <tr>
            <td class="align-middle">{{$platform->id}}</td>
            <td class="align-middle">{{$platform->local_name}}</td>
            <td class="align-middle">{{$platform->deployments_count}}</td>
            <td class="align-middle">
              {{
                $platform->deployment_id_autoregister ? 
                trans('lti1p3::lti1p3.auto_register_deployments_enable') : 
                trans('lti1p3::lti1p3.auto_register_deployments_disable')
              }}
            </td>
            <td class="align-middle">
              <div class="btn-group dropstart unselectable">
                <span class="material-icons btn-more-actions" data-bs-toggle="dropdown" aria-expanded="false">more_horiz</span>
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item" href="#">
                          <span class="material-icons me-2">settings</span>
                          {{trans('lti1p3::lti1p3._config')}}
                      </a>
                  </li>
                  <li>
                      <a class="dropdown-item" href="{{route('lti1p3.deployments.index', ['platform_id' => $platform->id])}}">
                          <span class="material-icons me-2">app_registration</span>
                          {{trans('lti1p3::lti1p3.platform_manage_deployments')}}
                      </a>
                  </li>
                  <li>
                      <a class="dropdown-item" onclick="return removePlatform(event, 
                          '{{trans('lti1p3::lti1p3.platform_confirm_delete', ['name' => $platform->local_name])}}')">
                          <span class="material-icons me-2">delete</span>
                          {{trans('lti1p3::lti1p3._delete')}}
                          <form action="{{route('lti1p3.platforms.destroy', [$platform->id])}}" method="POST">
                            @csrf
                            @method('delete')
                          </form>
                      </a>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <div class="d-flex align-content-center my-4 alert alert-info">
        <span class="material-icons me-3">info</span>
        <span>{{trans('lti1p3::lti1p3.platform_empty')}}</span>
      </div>
    @endif
@endsection
@push('body')
<script>
function removePlatform(event, message){
  event.preventDefault();
  let remove = confirm(message)
  if(remove){
    let form = event.target.querySelector('form');
    form.submit();
  }
}
</script>
@endpush