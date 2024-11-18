<!DOCTYPE html>
<html lang="en">
<head>
    <title> Mail</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Tomorrow&display=swap" rel="stylesheet">
    <style>
        .float-left{

        }
        .float-right{
            float: right; margin-top: 8px;
        }
        @media screen and (max-width: 600px){

        }
    </style>
</head>

<body style="background-color: #F5F5F5;font-family: 'Josefin Sans', sans-serif;">

    <div class="card" style="max-width: 736px; background: #fff; margin: 12px auto;padding: 12px">
        <div style="text-align: center">
            <img src="{{ $setting->websit_logo_path ?? asset('web/app_icon.png') }}" width="200px">
        </div>
        <h3 style="font-size: 30px; margin-top: 24px;">Thanks for your klaim!</h3>
        <p style="font-size: 16px; line-height: 24px; margin: 0; color: #1C1917">Hello {{ $order->customer->name }}</p>
        <p style="font-size: 16px; line-height: 24px;margin: 0; color:#57534E;">Great news! We have received your klaim. Check the website to status of your klaim.</p>
        <br>
        <p style="font-size: 16px; line-height: 24px;margin: 0; color:#57534E;">Confirmation of your klaim details are shown below:</p>
        <div style="margin-top: 30px">
            <h4 style="font-size: 18px;color: #1C1917;">Schedule and Location</h4>
            <div style="background-color: #DCA11215;padding: 16px;font-size: 12px;border-bottom: 1px solid #DCA112;">
                <div style="clear: both;display: table; width: 100%;">
                    <div class="float-left" style="float: left; margin-top: 8px;">
                        <p style="margin: 0;font-size: 14px;">Pick-up</p>
                        <div style="margin-top: 8px; font-size: 12px;display: flex; align-items: center;">
                            <img src="https://img.icons8.com/material-outlined/24/000000/calendar--v2.png" style="height: 16px; margin-right: 1px;"/>
                            {{  $order->pick_date  }}
                        </div>

                        <div style="margin-top: 8px;font-size: 12px;display: flex; align-items: center;">
                            <img src="https://img.icons8.com/ios-glyphs/30/000000/time--v1.png" style="height: 16px;margin-right: 1px;"/>
                            {{ $order->getTime(substr($order->pick_hour, 0, 2)) }}
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div style="margin-top: 40px">
            <div style="background: #F5F5F4;padding: 16px 8px 16px 16px;">
                <span>Klaims Summary</span>
            </div>
            <div style="padding: 0 8px;border-bottom: 1px solid #E7E5E4;font-size: 12px;margin-top: 8px;">
                <div style=" margin: 8px 0;;display: table; width: 100%;;display: table; width: 100%;">
                    <span style="color: #57534E; float: left;"> ID</span>
                    <span style="color: #1C1917;float: right;">#{{ $order->order_code }}</span>
                </div>
                <div style=" margin: 8px 0;;display: table; width: 100%;">
                    <span style="color: #57534E; float: left;">Date</span>
                    <span style="color: #1C1917;float: right;">{{ $order->created_at->format('M d, Y') }}</span>
                </div>
                <div style=" margin: 8px 0;;display: table; width: 100%;">
                    <span style="color: #57534E; float: left;">Name</span>
                    <span style="color: #1C1917;float: right;">{{ $order->customer->name }}</span>
                </div>
                <div style=" margin: 8px 0;;display: table; width: 100%;">
                    <span style="color: #57534E; float: left;">Phone Number</span>
                    <span style="color: #1C1917;float: right;">{{ $order->customer->user->mobile }}</span>
                </div>
                <div style=" margin: 8px 0;;display: table; width: 100%;">
                    <span style="color: #57534E; float: left;">Payment Method</span>
                    <span style="color: #1C1917;float: right;">{{ $order->payment_status }}</span>
                </div>
            </div>

            <div style="padding: 0 8px;border-bottom: 1px solid #57534E;font-size: 12px;">
                <div style=" margin: 8px 0;;display: table; width: 100%;">
                    @php
                        $quantity = 0;
                        foreach($order->products as $product){
                            $quantity += $product->pivot->quantity;
                        }
                    @endphp
                    <span style="color: #57534E; float: left;">Quantity ({{ $order->products->count() }} Items)</span>
                    <span style="color: #1C1917;float: right;">{{ $quantity }}</span>
                </div>
                <div style=" margin: 8px 0;;display: table; width: 100%;">
                    <span style="color: #57534E; float: left;">Sub Total</span>
                    <span style="color: #1C1917;float: right;">{{ currencyPosition($order->amount) }}</span>
                </div>
                <div style=" margin: 8px 0;;display: table; width: 100%;">
                    <span style="color: #57534E; float: left;">Pick-up and Delivery Charge</span>
                    <span style="color: #1C1917;float: right;">{{ currencyPosition($delivery_charge) }}</span>
                </div>
                <div style=" margin: 8px 0;;display: table; width: 100%;">
                    <span style="color: #57534E; float: left;">Discount</span>
                    <span style="color: #EF4444; float: right;">-{{ currencyPosition($order->discount) }}</</span>
                </div>
            </div>

            <div style=" padding: 16px 8px; display: block;">
                <span style="color: #1C1917;float: left;font-size: 14px;">Paid Amount</span>
                <span style="color: #1C1917;float: right;font-size: 14px;">{{ currencyPosition($order->total_amount) }}</span>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="http://laundry.razinsoft.com/my-order/{{ $order->id }}" target="_blank" style="width: 240px; padding: 16px 0;color: #fff; margin: auto; background: #00B894;text-decoration: none; font-size: 16px;border-radius: 4px; display: block">
                View My Order
                </a>
            </div>

        </div>
    </div>
    <footer style="width: 280px; margin: 16px auto; font-size: 12px;color: #57534E;line-height: 16px;">
        <span>
            Need help with anything? Mail us: Info@suryametalindoparts.com ©@php echo date('Y');@endphp
        </span>
    </footer>

</body>
</html>
