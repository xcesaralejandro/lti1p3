@extends('lti1p3::templates.app')

@section('header')
    @include('lti1p3::templates.navbar')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2 bg-white border p-3">
            <h5 class="text-center">{{trans('lti1p3::strings.deployment_add_title', ['platform_name' => $platform->local_name])}}</h5>
            <form action="{{route('lti1p3.deployments.store', ['platform_id' => $platform->id])}}" method="post" class="mt-3">
                @csrf
                <div class="row no-gutters">
                    <div class="mt-2 col-12 col-lg-5">
                        <div class="form-outline mx-1">
                            <input type="text" id="lti_id" name="lti_id" class="form-control" 
                            required/>
                        <label class="form-label" for="lti_id">
                            {{trans('lti1p3::strings.deployment_id_label')}}
                        </label>
                        </div>
                    </div>
                    <div class="mt-2 col-12 col-lg-2">
                        <input type="submit" class="btn btn-outline-primary" 
                            value="{{trans('lti1p3::strings.save_button')}}"/>
                    </div>
                </div>
                @if($errors->any())
                <div class="alert alert-danger mt-3 py-1" role="alert">
                    {{trans('lti1p3::strings.deployment_creation_failed')}}
                </div>
                @endif
            </form>
        </div>

        @forelse($platform->deployments as $deployment)
        <div class="col-md-8 offset-md-2 bg-white border p-3 mt-3 deployment-card">
            <div class="row no-gutters">
                <div class="col-10">
                    <table>
                        <tr>
                            <th class="font-weight-normal">
                              {{trans('lti1p3::strings.deployment_id_label')}}:
                            </th>
                            <td class="font-weight-light">{{$deployment->lti_id}}</td>
                        </tr>
                        <tr>
                          <th class="font-weight-normal">
                            {{trans('lti1p3::strings.creation_method_label')}}:
                          </th>
                          <td class="font-weight-light">{{$deployment->creation_method}}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-2 d-flex justify-content-end">
                    <span class="icon-button">
                        <form action="{{route('lti1p3.deployments.destroy', ['platform_id' => $platform->id, 'deployment' => $deployment->id])}}" method="post">
                          @method('delete')
                          @csrf
                          <button type="submit" class="p-0 m-0 bg-white border-0"
                            onclick="return confirm(
                              '{{trans('lti1p3::strings.deployment_confirm_delete', 
                                ['id' => $deployment->lti_id])}}')">
                            <i class="material-icons">delete</i>
                          </button>
                        </form>
                    </span>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <span class="font-italic">{{trans('lti1p3::strings.created_at_label', ['date' => $deployment->created_at])}}</span>
            </div>
        </div>
        @empty
        @endforelse
    </div>
</div>
@endsection