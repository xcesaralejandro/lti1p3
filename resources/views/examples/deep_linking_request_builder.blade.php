@extends('lti1p3::templates.app')
@section('content')
    <h1 class="text-center">LTI 1.3</h1>
    <h6 class="text-center">Deep Linking Creator</h6>
    <hr/>
    <p class="caption">This varies a bit depending on the type of DeepLinking resource that you want to resolve. In this case the return message will be a launch link, this can be useful to pre-configure some resource of the tool or create a custom resource. To simulate the creation of a local resource fill in the fields.</p>
    <div class="row">
      <form action="{{route('deep_linking.example')}}" method="post" class="mb-5">
        @addinstance($instance_id)
        <div class="form-outline mb-2">
          <input type="text" id="title" name="title" class="form-control form-control bg-white" required/>
          <label class="form-label" for="title">Resource title</label>
        </div>
        <div class="form-outline mb-2">
          <input type="text" id="description" name="description" class="form-control form-control bg-white" required/>
          <label class="form-label" for="description">Resource description</label>
        </div>
        <div class="form-outline mb-2">
          <input type="text" id="custom" name="custom" class="form-control form-control bg-white" required/>
          <label class="form-label" for="custom">Custom value for simulate personalized resource</label>
        </div>
        <input type="submit" value="Create Resource" class="btn btn-primary"/>
      </form>
    </div>
@endsection