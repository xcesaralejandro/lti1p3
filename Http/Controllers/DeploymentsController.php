<?php 
namespace xcesaralejandro\lti1p3\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use xcesaralejandro\lti1p3\Http\Requests\NewDeploymentRequest;
use App\Models\LtiDeployment;
use App\Models\LtiPlatform;

class DeploymentsController {

    public function index(int $platform_id) : View {
        $platforms = LtiPlatform::with('deployments')->findOrFail($platform_id);
        return View('lti1p3::admin.deployments.index')->with(['platform' => $platforms]);
    }

    public function create() : mixed {
        return redirect()->back();
    }

    public function store(int $platform_id, NewDeploymentRequest $request){
        $platform = LtiPlatform::findOrFail($platform_id);
        $record = $request->only(['lti_id', 'target_link_uri']);
        $record['lti1p3_platform_id'] = $platform->id;
        LtiDeployment::create($record);
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
        $deployment = LtiDeployment::findOrFail($deployment_id);
        $deployment->delete();
        return redirect()->route('lti1p3.deployments.index', ['platform_id' => $platform_id]);
    }
}