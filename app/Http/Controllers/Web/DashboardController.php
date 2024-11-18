<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerGaransis;
use App\Models\CustomerKlaims;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ServiceRepository;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        $garansi = CustomerGaransis::all();
        $klaim = CustomerKlaims::all();

        $services = (new ServiceRepository())->getAll();
        $products = (new ProductRepository())->getAll();
        $income = (new OrderRepository())->getByStatus('Delivered')->sum('amount');

        $revenues = (new OrderRepository())->getRevenueReport();

        $confirmOrder = (new OrderRepository())->getByStatus('Order confirmed')->count();
        $completeOrder = (new OrderRepository())->getByStatus('Delivered')->count();
        $pendingOrder = (new OrderRepository())->getByStatus('Pending')->count();
        $onPregressOrder = (new OrderRepository())->getByStatus('Processing')->count();
        $cancelledOrder = (new OrderRepository())->getByStatus('Cancelled')->count();


        return view('dashboard.index', compact(
            'customers', 'services', 'products', 'revenues', 'income', 'confirmOrder', 'completeOrder', 'pendingOrder', 'onPregressOrder', 'cancelledOrder'
        ));
    }
}
