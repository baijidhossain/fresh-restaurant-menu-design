<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\CodeResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\CodeCollection;
use App\Http\Requests\Admin\CodeStoreRequest;
use App\Http\Requests\Admin\CodeUpdateRequest;

class CodeController extends Controller
{
    public function index(Request $request): CodeCollection
    {
        $this->authorize('view-any', Code::class);

        $search = $request->get('search', '');

        $codes = Code::search($search)
            ->latest()
            ->paginate();

        return new CodeCollection($codes);
    }

    public function store(CodeStoreRequest $request): CodeResource
    {
        $this->authorize('create', Code::class);

        $validated = $request->validated();

        $code = Code::create($validated);

        return new CodeResource($code);
    }

    public function show(Request $request, Code $code): CodeResource
    {
        $this->authorize('view', $code);

        return new CodeResource($code);
    }

    public function update(CodeUpdateRequest $request, Code $code): CodeResource
    {
        $this->authorize('update', $code);

        $validated = $request->validated();

        $code->update($validated);

        return new CodeResource($code);
    }

    public function destroy(Request $request, Code $code): Response
    {
        $this->authorize('delete', $code);

        $code->delete();

        return response()->noContent();
    }
}
