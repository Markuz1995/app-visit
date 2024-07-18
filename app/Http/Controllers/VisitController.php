<?php

namespace App\Http\Controllers;

use App\Constants\General;
use App\Http\Requests\VisitRequest;
use App\Models\Visit;
use Inertia\Inertia;

class VisitController extends Controller
{
    public function index()
    {
        $visits = Visit::paginate(General::ROW_PER_PAGE);
        return Inertia::render('Visit/Index', ['visits' => $visits]);
    }

    public function create()
    {
        return Inertia::render('Visit/Create');
    }

    public function store(VisitRequest $request)
    {
        $visit = new Visit($request->all());
        $visit->save();
        return redirect()->route('visits.index');
    }

    public function edit(Visit $visit)
    {
        return Inertia::render('Visit/Create', ['visit' => $visit, 'isUpdating' => true]);
    }

    public function update(VisitRequest $request, Visit $visit)
    {
        $visit->update($request->all());
        return redirect()->route('visits.index');
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();
        return redirect()->back();
    }
}
