<?php 
namespace xcesaralejandro\lti1p3\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use xcesaralejandro\lti1p3\Http\Requests\NewDeploymentRequest;
use xcesaralejandro\lti1p3\Http\Requests\NewPlatformRequest;
use xcesaralejandro\lti1p3\Models\Deployment;
use xcesaralejandro\lti1p3\Models\Platform;

class DeploymentsController {

    public function index(int $platform_id) : View {
        $platforms = Platform::with('deployments')->findOrFail($platform_id);
        return View('lti1p3::admin.deployments.index')->with(['platform' => $platforms]);
    }

    public function create() : mixed {
        return redirect()->back();
    }

    public function store(int $platform_id, NewDeploymentRequest $request){
        $platform = Platform::findOrFail($platform_id);
        $record = $request->only(['lti_id', 'target_link_uri']);
        $record['platform_id'] = $platform->id;
        Deployment::create($record);
        return redirect()->route('lti1p3.deployments.index', ['platform_id' => $platform->id]);
    }

    public function show($id) : mixed {
        return redirect()->back();
    }

    public function edit($id) : mixed {
        return redirect()->back();
    }

    public function update(Request $request, $id) : mixed {
        return redirect()->back();
    }

    public function destroy(int $platform_id, int $deployment_id) : mixed {
        $deployment = Deployment::findOrFail($deployment_id);
        $deployment->delete();
        return redirect()->route('lti1p3.deployments.index', ['platform_id' => $platform_id]);
    }
}