<?php

namespace App\Http\Controllers\API\Admin\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::all()->count();
        $services = (new ServiceRepository())->getAll()->count();
        $products = (new ProductRepository())->getAll()->count();
        $income = (new OrderRepository())->getByStatus('Delivered')->sum('amount');
        $todayOrders = (new OrderRepository())->getByTodays()->count();
        return $this->json('dashboard Details',[
            'customers' => $customers,
            'services' => $services,
            'products' => $products,
            'income' => $income,
            'todayOrders' => $todayOrders
        ]);
    }

    public function status()
    {
        $statusArray =  array();
        
        foreach (config('enums.order_status') as $key => $value) {
           array_push($statusArray,['lable' => $key,'value' => $value]);
        }

        return $this->json('Order status list',[
            'status' => $statusArray
        ]);
    }

    
}
