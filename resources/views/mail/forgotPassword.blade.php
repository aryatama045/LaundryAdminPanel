
@php
$websetting = App\Models\WebSetting::first();
@endphp
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
            <img src="{{ $websetting->websiteLogoPath ?? asset('web/logo.png') }}" width="200px">
        </div>
        <h3 style="font-size: 30px; margin-top: 24px;">Thanks for your order!</h3>
        <p style="font-size: 16px; line-height: 24px; margin: 0; color: #1C1917">Hello {{ $user->name }}</p>
        <p style="font-size: 16px; line-height: 24px;margin: 0; color:#57534E;">Great news! We have received your order. Check your app or the website to check the status of your order.</p>
        <br>
        <p style="font-size: 16px; line-height: 24px;margin: 0; color:#57534E;">Confirmation of your order details are shown below:</p>

        <div style="margin-top: 40px">
            <div style="background: #F5F5F4;padding: 16px 8px 16px 16px;">
                <span>Order Summary</span>
            </div>
            <div style="padding: 0 8px;border-bottom: 1px solid #E7E5E4;font-size: 12px;margin-top: 8px;">
                <div style=" margin: 8px 0;;display: table; width: 100%;;display: table; width: 100%;">
                    <span style="color: #57534E; float: left;">Order ID</span>
                    <span style="color: #1C1917;float: right;">#234234</span>
                </div>
                <div style=" margin: 8px 0;;display: table; width: 100%;">
                    <span style="color: #57534E; float: left;">Date</span>
                    <span style="color: #1C1917;float: right;">123</span>
                </div>
                <div style=" margin: 8px 0;;display: table; width: 100%;">
                    <span style="color: #57534E; float: left;">Name</span>
                    <span style="color: #1C1917;float: right;">asd</span>
                </div>
                <div style=" margin: 8px 0;;display: table; width: 100%;">
                    <span style="color: #57534E; float: left;">Phone Number</span>
                    <span style="color: #1C1917;float: right;">asd</span>
                </div>
                <div style=" margin: 8px 0;;display: table; width: 100%;">
                    <span style="color: #57534E; float: left;">Payment Method</span>
                    <span style="color: #1C1917;float: right;">asd</span>
                </div>
            </div>

            <div style="padding: 0 8px;border-bottom: 1px solid #57534E;font-size: 12px;">
                <div style=" margin: 8px 0;;display: table; width: 100%;">
                    <span style="color: #57534E; float: left;">Quantity (  Items)</span>
                    <span style="color: #1C1917;float: right;">3</span>
                </div>
                <div style=" margin: 8px 0;;display: table; width: 100%;">
                    <span style="color: #57534E; float: left;">Sub Total</span>
                    <span style="color: #1C1917;float: right;">wrf</span>
                </div>
                <div style=" margin: 8px 0;;display: table; width: 100%;">
                    <span style="color: #57534E; float: left;">Discount</span>
                    <span style="color: #EF4444; float: right;">-345</</span>
                </div>
            </div>

            <div style=" padding: 16px 8px; display: block;">
                <span style="color: #1C1917;float: left;font-size: 14px;">Paid Amount</span>
                <span style="color: #1C1917;float: right;font-size: 14px;">2324234</span>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="http://laundry.razinsoft.com/my-order/1" target="_blank" style="width: 240px; padding: 16px 0;color: #fff; margin: auto; background: #00B894;text-decoration: none; font-size: 16px;border-radius: 4px; display: block">
                View My Order
                </a>
            </div>

        </div>
    </div>
    <footer style="width: 280px; margin: 16px auto; font-size: 12px;color: #57534E;line-height: 16px;">
        <span>
            Need help with anything? Whatsapps us:
        </span>
    </footer>

</body>
</html>
