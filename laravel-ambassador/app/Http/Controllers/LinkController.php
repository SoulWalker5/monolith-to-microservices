<?php

namespace App\Http\Controllers;

use App\Http\Resources\LinkResource;
use App\Jobs\LinkCreated;
use App\Models\Link;
use App\Models\LinkProduct;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public function __construct(public readonly UserService $userService)
    {
    }

    public function index($id)
    {
        $links = Link::with('orders')->where('user_id', $id)->get();

        return LinkResource::collection($links);
    }

    public function store(Request $request)
    {
        $user = $this->userService->get('user');

        $link = Link::create([
            'user_id' => $user['id'],
            'code' => Str::random(6)
        ]);

        $linkProducts = [];

        foreach ($request->input('products') as $product_id) {
            $linkProducts[] = LinkProduct::create([
                'link_id' => $link->id,
                'product_id' => $product_id
            ]);
        }

        LinkCreated::dispatch($link->toArray() + ['linkProducts' => $linkProducts])
            ->onQueue(config('kafka.topics.checkout'));

        return $link;
    }
}
