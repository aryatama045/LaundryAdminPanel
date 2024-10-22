<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        .bg-gray {
            background: gray;
            color: #fff;
        }

        .text-default {
            color: #00B894;
        }

        .bg-default {
            background: #00B894;
        }

        body {
            margin: 0;
            position: relative;
            font-family: "HelveticaNeue-CondensedBold", "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
            font-size: 14px;
        }

        .container {
            padding: 25px !important;
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        @page {
            size: A4;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 0.5rem;
            text-align: left;
            font-size: 14px;
            border: 1px solid rgba(0, 0, 0, 0.07);
        }

        img {
            max-width: 100%;
            max-height: 100%;
        }

        footer {
            position: absolute;
            top: 20%;
            left: 10px;
            transform: rotate(90deg);
            transform-origin: 3% 0% 0;
            width: 100%;
            height: 40px;
        }

        h4 {
            margin: 5px 0
        }

        .header {
            width: 100%;
            height: 28px;
            position: relative;
            background-color: #00B894;
            margin-top: 25px;
        }

        .header .logo {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 25px;
            background: #fff;
            width: 120px;
            height: 40px;
            text-align: center;
        }

        .header .logo img {
            max-width: 98%;
        }

        h1,
        h2 {
            font-weight: bold;
            margin: 0;
        }

        .float-left {
            float: left;
        }

        .address_line {
            height: 80px;
            padding: 5px 0;
        }

        h4 {
            font-weight: normal !important;
            font-size: 14px;
        }

        .w-60 {
            width: 60%
        }

        .w-70 {
            width: 70%
        }

        .w-10 {
            width: 10%
        }

        .w-15 {
            width: 15%
        }

        .w-20 {
            width: 20%
        }

        .footer {
            width: 100%;
            position: absolute;
            bottom: 0;
        }

        .contact {
            position: absolute;
            right: 25%;
            top: 50px
        }

        .footer-bottom {
            border-top: 2px solid rgba(0, 0, 0, 0.07);
            position: relative;
            height: 40px;
        }

        .footer-bottom .message {
            position: absolute;
            left: 25px;
            padding: 10px 0;
        }

        .footer-bottom .author {
            position: absolute;
            top: -2px;
            right: 25px;
            border-top: 2px solid #000;
            padding: 10px 0;
        }

        .footer-bottom .signature {
            position: absolute;
            right: 32px;
            top: -50px;
        }

        .footer-bottom .signature img {
            height: 50px;
        }
    </style>
    <title>#{{ $order->prefix . $order->order_code }} - invioce</title>
</head>

<body>
    @php
        $websetting = App\Models\WebSetting::first();
        $currency = $websetting->currency ?? config('enums.currency');

        $freeDelivery = $deliveryCost ? $deliveryCost->fee_cost : 00;
        $deliveryCharge = $deliveryCost ? $deliveryCost->cost : 00;
    @endphp

    <div class="header">
        @if (app()->environment('local'))
            <div class="logo">
                <img src="./web/logo.png" alt="">
            </div>
        @else
            <div class="logo">
                <img src="{{ $webSetting?->website_logo_path }}" alt="">
            </div>
        @endif
    </div>

    <div class="container">

        <div style="overflow: hidden; height: 30px;">
            <div style="float: right; width: 30%;" >
                <h1 class="text-default">Invoice</h1>
            </div>
        </div>

        <h4 style="font-weight: normal !important"> Customer: {{ $order->customer->user->name }}</h4>
        <div class="address_line">
            <div class="w-70 float-left">
                <h4>Area: {{ $order->address->area }}</h4>
                <h4>Road: {{ $order->address->road_no }}, House: {{ $order->address->house_no }}, Flat:
                    {{ $order->address->flat_no }} </h4>
                <h4>Phone | Fax: {{ $order->customer->user->mobile }}</h4>
            </div>
            <div class="w-10 float-left">
                <h4 class="text-default">RECEIPT #</h4>
                <h4 class="text-default">DATE:</h4>
            </div>
            <div class="w-20 float-left" style="padding-left: 12px">
                <h4>{{ $order->prefix . $order->order_code }}</h4>
                <h4>{{ $order->created_at->format('F d, Y') }}</h4>
            </div>
        </div>

        <div style="padding: 10px 0">
            <h4><strong>Pickup Date :</strong>
                <span class="badge text-dark">
                    {{ Carbon\Carbon::parse($order->pick_date)->format('M d, Y') }}
                </span>
            </h4>
            <h4><strong>Delivery Date :</strong>
                <span class="badge text-dark">
                    {{ Carbon\Carbon::parse($order->delivery_date)->format('M d, Y') }}
                </span>
            </h4>
        </div>

        <table class="table">
            <thead>
                <tr class="bg-default">
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th style="text-align: right;min-width:100px">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>{{ currencyPosition($product->discount_price ?? $product->price) }}</td>
                        <td style="text-align: right">
                            {{ currencyPosition($product->pivot->quantity * ($product->discount_price ? $product->discount_price : $product->price)) }}
                        </td>
                    </tr>
                @endforeach
                @if ($order->additionals->count())
                    <tr>
                        <td colspan="4" style="border: none"></td>
                    </tr>
                    <tr class="bg-gray">
                        <th style="background: #fff; border:none"><strong style="color: #000">Total Items:
                                {{ $quantity }} Pieces</strong></th>
                        <th colspan="2">ADDITIONAL ITEMS</th>
                        <th style="text-align: right">AMOUNT ({{ $currency }})</th>
                    </tr>
                    @foreach ($order->additionals as $additional)
                        <tr>
                            <td style="background: none; border:none"></td>
                            <td colspan="2">{{ $additional->title }}</td>
                            <td style="text-align: right; background: #ddd">{{ $additional->price }}</td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    @if (!$order->additionals->count())
                        <td style="border:none"><strong style="color: #000">Total Items: {{ $quantity }}
                                Pieces</strong></td>
                    @endif
                    <td colspan="{{ $order->additionals->count() ? 3 : 2 }}" style="text-align: right;border: 0;">
                        <strong>SUBTOTAL</strong>
                    </td>
                    <td style="text-align: right; background: rgba(0, 0, 0, 0.07);">
                        <strong>{{ currencyPosition($order->amount) }}</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;border: 0;">
                        <strong>DELIVERY CHARGE</strong>
                    </td>
                    <td style="text-align: right">
                        {{ currencyPosition($order->delivery_charge) }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;border: 0;">
                        <strong>TOTAL</strong>
                    </td>
                    <td style="text-align: right; background: rgba(0, 0, 0, 0.07);">
                        {{ currencyPosition($order->total_amount) }}</td>
                </tr>

                @if ($order->discount)
                    <tr>
                        <td colspan="3" style="text-align: right;border: 0;">
                            <strong>COUPON DISCOUNT</strong>
                        </td>

                        <td style="text-align: right; color:red;">
                            -{{ currencyPosition(round($order->discount, 2)) }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <td colspan="3" style="text-align: right;border: 0;">
                        <strong>TOTAL PAYABLE</strong>
                    </td>
                    <td style="color:#000;text-align: right; background: #ddd;">
                        <strong>{{ currencyPosition($order->total_amount) }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>

        <h4 style="margin-top: 20px"><strong>Delivery Note:</strong> {{ $order->address->delivery_note }}</h4>
        <p style="font-weight: 700">{{ $order->instruction }}</p>
    </div>
    <div class="footer">
        <div style="padding: 10px 25px">
            <div class="address">
                <strong>{{ $webSetting?->name ?? config('app.name') }}</strong> <br>
                Address: <strong>{{ $webSetting?->address }}</strong> <br>
                City: <strong>{{ $webSetting?->city }}</strong> <br>
            </div>
            <div class="contact">
                Mobile: <strong>{{ $webSetting?->mobile }}</strong>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="message text-default">Thank you for your business</div>
            <div class="author">Authorised sign</div>
            @if (app()->environment('local'))
                <div class="signature">
                    <img src="./web/signature.png">
                </div>
            @else
                <div class="signature">
                    <img src="{{ $webSetting?->signature_path }}">
                </div>
            @endif
        </div>
    </div>
</body>

</html>
