@extends('lti1p3::templates.dashboard')

@section('content')
    <h3 class="fw-normal text-uppercase mb-4">{{$platform->local_name}}</h3>
    <div class="row">
        <div class="col-lg-8 bg-white border rounded p-3">
            <h2 class="h6 mb-4">{{trans('lti1p3::lti1p3.deployment_add_title', ['platform_name' => $platform->local_name])}}</h2>
            <form action="{{route('lti1p3.deployments.store', ['platform_id' => $platform->id])}}" method="post" class="mt-3">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="lti_id" name="lti_id" />
                    <label for="lti_id">{{trans('lti1p3::lti1p3.deployment_id_label')}}</label>
                </div>
                @if($errors->any())
                <div class="alert alert-danger mt-3 py-1" role="alert">
                    {{trans('lti1p3::lti1p3.deployment_creation_failed')}}
                </div>
                @endif
                <input type="submit" class="btn btn-primary btn-sm" value="{{trans('lti1p3::lti1p3.save_button')}}"/>
            </form>
        </div>
        <div class="col-lg-8 bg-white border rounded p-3 mt-3">
            <h2 class="h6 mb-4">{{trans('lti1p3::lti1p3.deployment_availables_title', ['platform_name' => $platform->local_name])}}</h2>
            @if (count($platform->deployments) > 0)
            <table class="table caption-top">
                <thead>
                  <tr>
                    <th scope="col">id</th>
                    <th scope="col">deployment id</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($platform->deployments as $deployment)
                  <tr>
                    <td class="align-middle">{{$deployment->id}}</td>
                    <td class="align-middle">{{$deployment->lti_id}}</td>
                    <td class="align-middle">
                        <div class="btn-group dropstart unselectable">
                            <span class="material-icons btn-more-actions" data-bs-toggle="dropdown" aria-expanded="false">more_horiz</span>
                            <ul class="dropdown-menu">
                               <li>
                                    <a class="dropdown-item" onclick="return removeDeployment(event, 
                                        '{{trans('lti1p3::lti1p3.deployment_confirm_delete', ['id' => $deployment->id])}}')">
                                        <span class="material-icons me-2">delete</span>
                                        {{trans('lti1p3::lti1p3._delete')}}
                                        <form action="{{route('lti1p3.deployments.destroy', ['platform_id' => $platform->id, 'deployment' => $deployment->id])}}" method="post">
                                            @method('delete')
                                            @csrf
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
                <div class="d-flex align-content-center mb-4 alert alert-info">
                <span class="material-icons me-3">info</span>
                <span>{{trans('lti1p3::lti1p3.deployment_empty')}}</span>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('body')
<script>
function removeDeployment(event, message){
  event.preventDefault();
  let remove = confirm(message)
  if(remove){
    let form = event.target.querySelector('form');
    form.submit();
  }
}
</script>
@endpush