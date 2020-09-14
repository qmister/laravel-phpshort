<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateDomainRequest;
use App\Http\Requests\API\UpdateDomainRequest;
use App\Http\Resources\DomainResource;
use App\Domain;
use App\Traits\DomainTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    use DomainTrait;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $search = $request->input('search');
        $sort = ($request->input('sort') == 'asc' ? 'asc' : 'desc');

        return DomainResource::collection(Domain::where('user_id', $user->id)
            ->when($search, function($query) use ($search) {
                return $query->searchName($search);
            })
            ->orderBy('id', $sort)
            ->paginate(10)
            ->appends(['search' => $search, 'sort' => $request->input('sort')]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateDomainRequest $request
     * @return DomainResource|\Illuminate\Http\JsonResponse
     */
    public function store(CreateDomainRequest $request)
    {
        $created = $this->domainCreate($request);

        if ($created) {
            return DomainResource::make($created);
        }

        return response()->json([
            'message' => 'Resource not found.',
            'status' => 404
        ], 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return DomainResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = Auth::user();

        $link = Domain::where([['id', '=', $id], ['user_id', $user->id]])->first();

        if ($link) {
            return DomainResource::make($link);
        }

        return response()->json([
            'message' => 'Resource not found.',
            'status' => 404
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDomainRequest $request
     * @param int $id
     * @return DomainResource
     */
    public function update(UpdateDomainRequest $request, $id)
    {
        $user = Auth::user();

        $domain = Domain::where([['id', '=', $id], ['user_id', '=', $user->id]])->firstOrFail();

        $updated = $this->domainUpdate($request, $domain);

        if ($updated) {
            return DomainResource::make($updated);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $domain = Domain::where([['id', '=', $id], ['user_id', '=', $user->id]])->first();

        if ($domain) {
            $domain->delete();

            return response()->json([
                'id' => $domain->id,
                'object' => 'domain',
                'deleted' => true,
                'status' => 200
            ], 200);
        }

        return response()->json([
            'message' => 'Resource not found.',
            'status' => 404
        ], 404);
    }
}
