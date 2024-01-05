@extends('lti1p3::templates.dashboard')

@section('content')
<div class="container">
  <div class="table-responsive">
    <table class="table caption-top">
      <h3 class="mb-4 fw-normal text-uppercase">{{trans('lti1p3::lti1p3.platform_title')}}</h3>
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
        @forelse($platforms as $platform)
        <tr>
          <td>{{$platform->id}}</td>
          <td>{{$platform->local_name}}</td>
          <td>{{$platform->deployments_count}}</td>
          <td>
            {{
              $platform->deployment_id_autoregister ? 
              trans('lti1p3::lti1p3.auto_register_deployments_enable') : 
              trans('lti1p3::lti1p3.auto_register_deployments_disable')
            }}
          </td>
          <td>
            <div class="btn-group dropstart unselectable">
              <span class="material-icons btn-collapsed-menu" data-bs-toggle="dropdown" aria-expanded="false">more_vert</span>
              <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="#">
                        {{trans('lti1p3::lti1p3._config')}}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{route('lti1p3.deployments.index', ['platform_id' => $platform->id])}}">
                        {{trans('lti1p3::lti1p3.platform_manage_deployments')}}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" onclick="return removePlatform(event, 
                        '{{trans('lti1p3::lti1p3.platform_confirm_delete', ['name' => $platform->local_name])}}')">
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
        @empty
        <p>{{trans('lti1p3::lti1p3.platform_not_found')}}</p>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
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