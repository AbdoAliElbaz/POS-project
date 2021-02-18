<?php


namespace App\Repository\Order;

use App\Http\Requests\OrderRequest;
use App\Order;
use App\Repository\Order\OrderRepositoryInterface;
use PhpParser\Node\Expr\FuncCall;

class OrderRepository implements OrderRepositoryInterface
{
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function create($request)
    {
        $request->merge([
            'user_id' => $request->user()->id
        ]);
        // @TODO validation on calculations

        $order = $this->model::create($request->all());
        $order->products()->attach($request->get('products'));
        dd($order);
        return ($order);
       
    }
}
