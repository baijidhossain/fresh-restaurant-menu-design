<?php

namespace App\Http\Controllers\Admin;

use App\Models\Code;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\CodeStoreRequest;
use App\Http\Requests\Admin\CodeUpdateRequest;

class CodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Code::class);

        $search = $request->get('search', '');

        $codes = Code::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.codes.index', compact('codes', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Code::class);

        return view('admin.codes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Code::class);


        $count = $request->input('count');

        $codes = [];

        for ($i=0; $i < $count ; $i++) {

            $generate = Code::generate();


            $code = Code::create([
                'code' => $generate,
                'has_card' => 0,
            ]);

            $codes[] = $code;

        }

        return redirect()
            ->route('codes.index')
            ->withSuccess('Codes generated');
    }

     /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Code $code): View
    {
        $this->authorize('update', $code);

        return view('admin.codes.edit', compact('code'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        CodeUpdateRequest $request,
        Code $code
    ): RedirectResponse {
        $this->authorize('update', $code);

        $validated = $request->validated();

        $code->update($validated);

        return redirect()
            ->route('codes.edit', $code)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Code $code): View
    {
        $this->authorize('view', $code);

        return view('admin.codes.show', compact('code'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Code $code): RedirectResponse
    {
        $this->authorize('delete', $code);

        $code->delete();

        return redirect()
            ->route('codes.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function export()
    {
        $available = Code::select('code')->where('has_card', 0)->get();

        //generate csv

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=available-codes.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        $columns = ['Generated Links'];

        $callback = function () use ($available, $columns) {

            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);

            foreach ($available as $row) {

                $row = $row->toArray();

                $row['link'] = request()->getSchemeAndHttpHost() . '/scan/' . $row['code'];

                unset($row['code']);

                fputcsv($file, $row);

            }

            fclose($file);

        };

        return response()->stream($callback, 200, $headers);

    }

    public function qrcode()
    {
        return view('admin.qrcode.index');
    }

}
