<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function store(OrderStoreRequest $request)
    {
        $new_order = (new OrderService())->makeOrder($request->all());

        return response(['status' => 'success']);
    }
}
