<?php 
namespace xcesaralejandro\lti1p3\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use xcesaralejandro\lti1p3\Http\Requests\NewPlatformRequest;
use xcesaralejandro\lti1p3\Models\Platform;

class PlatformsController {

    public function index() : View {
        return View('lti1p3::admin.platforms.index')->with([
            'platforms' => Platform::withCount('deployments')->get(),
        ]);
    }

    public function create() : View {
        return View('lti1p3::admin.platforms.create');
    }

    public function store(NewPlatformRequest $request) : View {
        $record = $request->all();
        $record['deployment_id_autoregister'] = isset($request->deployment_id_autoregister);
        Platform::create($record);
        return View('lti1p3::admin.platforms.create')
        ->with(['wasCreated' => true]);
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

    public function destroy($id) : mixed {
        Platform::destroy($id);
        return redirect()->back();
    }
}