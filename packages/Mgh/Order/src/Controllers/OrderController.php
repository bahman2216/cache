<?php

namespace Mgh\Order\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Mgh\Order;

class OrderController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return view('Order::dashboard');
    }

    public function create()
    {

        $products = Cache::rememberForever('products', function () {
            return \Mgh\Order\Product::pluck('name', 'id');
        });

        return view('Order::create', compact('products'));
    }

    public function store(Request $request)
    {
        $order = $this->validate($request, [
            'product_id' => 'required',
            'quantity'   => 'required|numeric',
            'color'      => 'required|string'
        ]);

        $order          = new Order\Order($request->all());
        $order->user_id = Auth::user()->id;
        $order->save();

        /*SYNC ALGOLIA INDEX*/
        /*$contact = Contact::find(1);
        $contact->name = 'New Name';
        $contact->update();*/ //  <== will trigger HTTP call to Algolia

        $this->send();

        //Order\Order::create($order);

        return back()->with('success', 'Order has been added');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = Cache::rememberForever('products', function () {
            return \Mgh\Order\Product::pluck('name', 'id');
        });

        $order = Order\Order::find($id);

        return view('Order::edit', compact('order', 'id', 'products'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order\Order::find($id);
        $this->validate(request(), [
            'product_id' => 'required',
            'quantity'   => 'required|numeric',
            'color'      => 'required|string'
        ]);
        $order->product_id = $request->get('product_id');
        $order->quantity   = $request->get('quantity');
        $order->color      = $request->get('color');
        $order->save();

        return redirect('order/list')->with('success', 'Order has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order\Order::find($id);
        $order->delete();

        return redirect('order/list')->with('success', 'Order has been  deleted');
    }

    public function show()
    {

        $orders = Cache::rememberForever('orders', function () {
            return \Mgh\Order\Order::with('product')->paginate(15);
        });

        return view('Order::show', compact('orders'));
    }

    /*
     * send notification email
     */
    public function send()
    {
        Log::info("Request Cycle with Queues Begins");
        $this->dispatch(new SendNotificationEmail());
        Log::info("Request Cycle with Queues Ends");
    }

    /*
     * search method using algolia and laravel scout
     */
    public function search()
    {
        return view('Order::search');
    }

    /*
     * search method using algolia and laravel scout
     */
    public function searchItem(Request $request)
    {
        $phrase = $request->input('phrase');
        //search in products with joined on orders
        $search = Order\Product::search($phrase)->get();
        $result = [];

        if ($search) {
            foreach ($search as $k => $item) {
                $product = $search->find($item->id)->get();
                if(count($product))
                {
                    $result[] = (object) ['name' => $item->name, 'order' => $product[$k]->name, 'product_id' => $product[$k]->id];
                }
            }
        }

        return $result;
    }

}
