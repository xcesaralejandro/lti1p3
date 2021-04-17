<?php 
namespace xcesaralejandro\lti1p3\Http\Controllers;

use Illuminate\Http\Request;
use xcesaralejandro\lti1p3\Http\Requests\NewPlatformRequest;
use xcesaralejandro\lti1p3\Models\Platform;

class PlatformsController {

    public function index(){
        return View('lti1p3::admin.platforms.index')->with([
            'platforms' => Platform::all()
        ]);
    }

    public function create()
    {
        return View('lti1p3::admin.platforms.create');
    }

    public function store(NewPlatformRequest $request)
    {
        Platform::create($request->all());
        return View('lti1p3::admin.platforms.create')
        ->with(['wasCreated' => true]);
    }

    public function show($id)
    {
        return redirect()->back();
    }

    public function edit($id)
    {
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        return redirect()->back();
    }

    public function destroy($id)
    {
        Platform::destroy($id);
        return redirect()->back();
    }
}