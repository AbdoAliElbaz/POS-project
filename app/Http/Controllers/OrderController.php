<?php

namespace App\Http\Controllers;

use App\Order;
use App\Client;
use App\Http\Requests\OrderRequest;
use App\Product;
use App\Repository\Order\OrderRepositoryInterface;
use App\Repository\Order\OrderRepository;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(OrderRepositoryInterface $OrderRepository)
    {
        $this->OrderRepository = $OrderRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->query('search');
        return view('admin.order.index', [
            'orders' => Order::where('date', 'LIKE', "%{$q}%")
                ->paginate($request->query('limit', 10))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.order.create', [
            'products' => Product::all(),
            'clients' => Client::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        // $this->OrderRepository->create($request);
        $request->merge([
            'user_id' => $request->user()->id
        ]);
        // @TODO validation on calculations

        $order = Order::create($request->all());
        $order->products()->attach($request->get('products'));
        $order->save();
        
        return redirect(route('admin.orders.show' , $order));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
