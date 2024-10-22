<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>

        body {
            height: 100%;
            padding: 25px !important;
            margin: 0;
            position: relative;
            font-family: "HelveticaNeue-CondensedBold", "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
            font-size: 12px;
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
        td, th {
            border: 1px solid #999;
            padding: 0.5rem;
            text-align: left;
        }
        h4{
            margin: 5px 0:
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
        .footer-content {
            padding: 20px;
            font-size: x-small;
        }
        .clearfix {
            overflow: auto;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .text-center { text-align: center; }
        .w-50 {
            width: 50%;
        }
        .w-25 {
            width: 25%;
        }
        .w-20 {
            width: 20%;
        }
        .w-12 {
            width: 12%;
        }
        .border-bottom{
            border-bottom: 1px solid rgb(90, 90, 90);
            width: 100%;
            font-style: italic
        }
        .p-0{padding: 0}
        .m-0{margin: 0}
        .ml-2{margin-left: 1em}
        .ml-1{margin-left: .5em}
        .mr-4{margin-right: 2em}
        .mb-4{margin-bottom: 2em}
        .mt-1{margin-top: .5em}

        .pt-1{padding-top: .5em}
        .pt-2{padding-top: 1em}
        .py-2{padding: 0 1.5em}
        .pt-4{padding-top: 2em}
        .pt-5{padding-top: 2.5em}
        .pb-2{padding-bottom: 1em}
        .pb-3{padding-bottom: 1.5em}
        .pdf-logo{
            width: 90px;
            height: 70px
        }
        .card{
            /* float: left; */
            border: 1px solid #dddddd;
            border-radius: 10px;
            margin: 10px;
        }
    </style>
    <title>Order Labels</title>
  </head>
  <body>
        <div>
            <table>
            @foreach ($labels as $items)
                <tr>
                    @foreach ( $items as  $item)
                    <td style="border: 0;">
                        <div>
                            <div class="card text-dark m-3 py-2">
                                <h4>Name: {{ $item['name'] }}</h4>
                                <h4>Order Id: #{{ $item['code'] }}</h4>
                                <h4>Date: {{ $item['date'] }}</h4>
                                <h4>Title: {{ $item['title'] }}</h4>
                                <h4>Item: {{ $item['label'] }}</h4>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </table>
        </div>
  </body>
</html>
