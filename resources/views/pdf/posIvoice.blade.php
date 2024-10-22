<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('web/logos/fav-icon.png') }}">
    <title>Order Invoice</title>
    <meta name="description" content="">
    <link rel="stylesheet" href="{{ asset('web/css/all.min.css') }}" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <style type="text/css">
        * {
            font-size: 14px;
            line-height: 24px;
            font-family: 'Ubuntu', sans-serif;
        }

        .btn {
            padding: 7px 10px;
            text-decoration: none;
            border: none;
            display: block;
            text-align: center;
            margin: 7px;
            cursor: pointer;
        }

        .btn-info {
            background-color: #999;
            color: #FFF;
        }

        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }

        td,
        th,
        tr,
        table {
            border-collapse: collapse;
        }

        tr {
            border-bottom: 1px dotted #ddd;
        }

        td,
        th {
            padding: 7px 0;
        }

        table {
            width: 100%;
        }

        tfoot tr th:first-child {
            text-align: left;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        small {
            font-size: 11px;
        }

        @media print {
            * {
                font-size: 12px;
                line-height: 20px;
            }

            td,
            th {
                padding: 5px 0;
            }

            .hidden-print {
                display: none !important;
            }

            @page {
                margin: 1.5cm 0.5cm 0.5cm;
            }

            @page: first {
                margin-top: 0.5cm;
            }

            tbody::after {
                content: '';
                display: block;
                page-break-after: always;
                page-break-inside: avoid;
                page-break-before: avoid;
            }
        }
    </style>
</head>

<body>

    <div style="max-width:400px;margin:0 auto">
        <div class="hidden-print">
            <table>
                <tr>
                    <td>
                        <a href="{{ route('order.show', $order->id) }}" class="btn btn-info"><i
                                class="fa fa-arrow-left"></i>Back To Order</a>
                    </td>
                    <td>
                        <button onclick="window.print();" class="btn btn-primary">
                            <i class="dripicons-print"></i> Print Now
                        </button>
                    </td>
                </tr>
            </table>
            <br>
        </div>
        @php
            $freeDelivery = $deliveryCost ? $deliveryCost->fee_cost : 00;
            $deliveryCharge = $deliveryCost ? $deliveryCost->cost : 00;
        @endphp
        <div id="receipt-data">
            <div class="centered">
                <img src="{{ $websetting->websiteLogoPath ?? asset('web/logo.png') }}" height="42"
                    style="margin-top: -10px; margin-bottom: 0px;filter: brightness(0);">
                <p style="margin-top: 0; font-size: 10px; line-height: 20px;">
                    {{ $webSetting?->address }}<br>
                    <i class="fas fa-phone-alt" style="font-size:10px"></i> {{ $webSetting?->mobile }} <br>
                    <i class="fas fa-globe" style="font-size:10px"></i> {{ $webSetting?->name }}
                </p>
            </div>
            <p>
                Customer: {{ $order->customer->name }}
                <br>
                @if ($order->address)
                    House No: {{ $order->address->house_no }} / Flat: {{ $order->address->flat_no }}
                    <br>
                    Road NO: {{ $order->address->road_no }} / Block: {{ $order->address->block }}
                    <br>
                @endif
                Phone No: {{ $order->customer->user->mobile }}
                <br>
                Pick Date: {{ Carbon\Carbon::parse($order->pick_at)->format('M d, Y') }}
                @if ($order->delivery_at)
                    <br>
                    Delivery Date: {{ Carbon\Carbon::parse($order->delivery_at)->format('M d, Y') }}
                @endif
                <br>
                Order ID: <strong>{{ $order->prefix . $order->order_code }}</strong>
            </p>
            <table class="table-data">
                <tbody>
                    @foreach ($order->products as $product)
                        <tr>
                            <td style="padding-bottom: 0" colspan="2">
                                <h4 style="margin: 0">{{ $product->name }}</h4>
                                {{ $product->pivot->quantity }} x {{ currencyPosition($product->price) }}
                            </td>
                            <td style="text-align:right;vertical-align:bottom;padding-bottom: 0">
                                {{ currencyPosition($product->pivot->quantity * $product->price) }}
                            </td>
                        </tr>
                    @endforeach

                    @if ($order->additionals->count())
                        <tr>
                            <td colspan="2" style="padding:15px 0 0 0"><strong>Additional Service</strong></td>
                        </tr>
                        @foreach ($order->additionals as $additional)
                            <tr>
                                <td style="padding-bottom: 0" colspan="2">
                                    <h4 style="margin: 0">{{ $additional->title }}</h4>
                                </td>
                                <td style="text-align:right;vertical-align:bottom;padding-bottom: 0">
                                    {{ currencyPosition( $additional->price) }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    <tr>
                        <td style="padding-bottom: 0" colspan="2">
                            <h4 style="margin: 0">TOTAL</h4>
                        </td>
                        @php
                            $total = $order->amount >= $freeDelivery ? $order->amount : $order->amount + $deliveryCharge;
                        @endphp
                        <td style="text-align:right;vertical-align:bottom;padding-bottom: 0">
                            <strong>{{ currencyPosition($total) }}</strong>
                        </td>
                    </tr>

                    @if ($order->discount)
                        <tr>
                            <td style="padding-bottom: 0" colspan="2">
                                <h4 style="margin: 0">COUPON DISCOUNT</h4>
                            </td>
                            <td style="text-align:right;vertical-align:bottom;padding-bottom: 0">
                                <strong>-{{ currencyPosition(round($order->discount, 2)) }}</strong>
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td style="padding-bottom: 0" colspan="2">
                            <h4 style="margin: 0">DELIVERY COST</h4>
                        </td>
                        <td style="text-align:right;vertical-align:bottom;padding-bottom: 0">
                            <strong>{{ currencyPosition($order->delivery_charge)}}</strong>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-bottom: 0" colspan="2">
                            <h4 style="margin: 0">TOTAL PAYABLE</h4>
                        </td>
                        <td style="text-align:right;vertical-align:bottom;padding-bottom: 0">
                            <strong>{{ currencyPosition(round($order->total_amount, 1)) }}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style="margin-top: 20px">
                <tbody>
                    <tr style="background-color:#ddd;">
                        <td style="padding: 5px;width:30%">Total PCs: {{ $quantity }}</td>
                        <td style="padding: 5px;width:40%;text-align:center">Paid By: Cash</td>
                        <td style="padding: 5px;width:30%;text-align:right">Total:
                            <strong>{{ currencyPosition(round($order->total_amount, 1)) }}</strong>
                        </td>
                    </tr>
                    @if ($order->instruction)
                        <tr>
                            <td colspan="3">
                                <p>{{ $order->instruction }}</p>
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td class="centered" colspan="3">Thank you for choosing {{ $webSetting?->name }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>

    <script type="text/javascript">
        localStorage.clear();

        function auto_print() {
            window.print()
        }
        setTimeout(auto_print, 1000);
    </script>

</body>

</html>
