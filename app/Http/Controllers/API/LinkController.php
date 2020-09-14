<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLinkRequest;
use App\Http\Requests\API\UpdateLinkRequest;
use App\Http\Resources\LinkResource;
use App\Link;
use App\Traits\LinkTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    use LinkTrait;

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
        $space = $request->input('space');
        $domain = $request->input('domain');
        $status = $request->input('status');
        $by = $request->input('by');

        if ($request->input('sort') == 'min') {
            $sort = ['clicks', 'asc'];
        } elseif ($request->input('sort') == 'max') {
            $sort = ['clicks', 'desc'];
        } elseif ($request->input('sort') == 'asc') {
            $sort = ['id', 'asc'];
        } else {
            $sort = ['id', 'desc'];
        }

        return LinkResource::collection(Link::where('user_id', $user->id)
            ->when($domain, function($query) use ($domain) {
                return $query->searchDomain($domain);
            })
            ->when($space, function($query) use ($space) {
                return $query->searchSpace($space);
            })
            ->when($status, function($query) use ($status) {
                if($status == 1) {
                    return $query->searchActive();
                } elseif($status == 2) {
                    return $query->searchExpired();
                } else {
                    return $query->searchDisabled();
                }
            })
            ->when($search, function($query) use ($search, $by) {
                if($by == 'url') {
                    return $query->searchUrl($search);

                } elseif ($by == 'alias') {
                    return $query->searchAlias($search);
                }
                return $query->searchTitle($search);
            })
            ->orderBy($sort[0], $sort[1])
            ->paginate(10)
            ->appends(['search' => $search, 'domain' => $domain, 'space' => $space, 'by' => $by, 'sort' => $request->input('sort')]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateLinkRequest $request
     * @return LinkResource|\Illuminate\Http\JsonResponse
     */
    public function store(CreateLinkRequest $request)
    {
        if (!$request->input('multi_link')) {
            $created = $this->linkCreate($request);

            if ($created) {
                return LinkResource::make($created);
            }
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
     * @return LinkResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = Auth::user();

        $link = Link::where([['id', '=', $id], ['user_id', $user->id]])->first();

        if ($link) {
            return LinkResource::make($link);
        }

        return response()->json([
            'message' => 'Resource not found.',
            'status' => 404
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLinkRequest $request
     * @param $id
     * @return LinkResource
     */
    public function update(UpdateLinkRequest $request, $id)
    {
        $user = Auth::user();

        $link = Link::where([['id', '=', $id], ['user_id', '=', $user->id]])->firstOrFail();

        $updated = $this->linkUpdate($request, $link);

        if ($updated) {
            return LinkResource::make($updated);
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

        $link = Link::where([['id', '=', $id], ['user_id', '=', $user->id]])->first();

        if ($link) {
            $link->delete();

            return response()->json([
                'id' => $link->id,
                'object' => 'link',
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
