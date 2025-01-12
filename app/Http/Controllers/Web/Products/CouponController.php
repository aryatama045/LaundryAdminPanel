<?php

namespace App\Http\Controllers\Web\Products;

use App\Models\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use Illuminate\Http\Request;

use App\Models\NotificationManage;
use App\Models\WebSetting;
use App\Repositories\CouponRepository;
use App\Repositories\DeviceKeyRepository;
use App\Services\NotificationServices;
use Carbon\Carbon;

use Illuminate\Support\Str;
use App\Import\BarangImport;
// use App\Export\BarangExport;
use Illuminate\Support\Facades\Input;
use File;
use Redirect;
use Excel;
use DB;
use PDF;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = (new CouponRepository())->getAll();

        return view('coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('coupon.create');
    }

    public function store(CouponRequest $request)
    {
        (new CouponRepository())->storeByRequest($request);

        return redirect()->route('coupon.index')->with('success', 'Code is added successfully.');
    }

    public function edit(Coupon $coupon)
    {
        return view('coupon.edit', compact('coupon'));
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        (new CouponRepository())->updateByRequest($request, $coupon);

        return redirect()->route('coupon.index')->with('success', 'Coupon is updated successfully.');
    }

    public function delete(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('coupon.index')->with('success', 'Coupon deleted successfully');
    }

    public function Imports(Request $request)
    {

        $file   = $request->file('import_data');

        $array= Excel::toArray(new BarangImport, $file);

        $data = [];
        foreach($array as $key => $val){

            foreach ($val as $key2 => $val2){

                $code_data        = Coupon::firstOrNew(['code'=>$val2['code'] ]);

                $code_data->code  = $val2['code'];

                $code_data->save();

            }

        }

        return redirect()->route('coupon.index')->with('success', 'Coupon is imported successfully.');
        // return redirect('admin/barang')->with('create_message', 'Product imported successfully');
    }
}
