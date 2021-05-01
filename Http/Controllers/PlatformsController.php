<?php 
namespace xcesaralejandro\lti1p3\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use xcesaralejandro\lti1p3\Http\Requests\NewPlatformRequest;
use xcesaralejandro\lti1p3\Models\Platform;

class PlatformsController {

    public function index() : View {
        return View('lti1p3::admin.platforms.index')->with([
            'platforms' => Platform::all()
        ]);
    }

    public function create() : View {
        return View('lti1p3::admin.platforms.create');
    }

    public function store(NewPlatformRequest $request){
        Platform::create($request->all());
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