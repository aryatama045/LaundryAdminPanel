@php
$server  = request()->server('HTTP_SEC_CH_UA_PLATFORM');
@endphp
<!doctype html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @php
        $websetting = App\Models\WebSetting::first();
    @endphp
    <link rel="icon" type="image/png" href="{{ $websetting?->websiteFaviconPath ?? asset('web/favIcon.png') }}">
    <title>{{ $websetting->title ?? config('app.name') }}</title>
    <!-- Fonts -->

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('web/css/all.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('web/css/bootstrap.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('web/css/select2.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('web/css/custom.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('web/css/datatables.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('web/css/toastr.min.css') }}" type="text/css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/css/swiper.min.css">
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0"
    />
    <style>
        .slider-wrapper {
        position: relative;
        }

        .slider-wrapper .slide-button {
        position: absolute;
        top: 50%;
        outline: none;
        border: none;
        height: 50px;
        width: 50px;
        z-index: 5;
        color: #fff;
        display: flex;
        cursor: pointer;
        font-size: 2.2rem;
        background: #000;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transform: translateY(-50%);
        }

        .slider-wrapper .slide-button:hover {
        background: #404040;
        }

        .slider-wrapper .slide-button#prev-slide {
        left: -25px;
        display: none;
        }

        .slider-wrapper .slide-button#next-slide {
        right: -25px;
        }

        .slider-wrapper .image-list {
        display: grid;
        grid-template-columns: repeat(10, 1fr);
        gap: 18px;
        font-size: 0;
        list-style: none;
        margin-bottom: 30px;
        overflow-x: auto;
        scrollbar-width: none;
        }

        .slider-wrapper .image-list::-webkit-scrollbar {
        display: none;
        }

        .slider-wrapper .image-list .image-item {
        width: 350px;
        height: 350px;
        object-fit: cover;
        }

        .container .slider-scrollbar {
        height: 24px;
        width: 100%;
        display: flex;
        align-items: center;
        }

        .slider-scrollbar .scrollbar-track {
        background: #ccc;
        width: 100%;
        height: 2px;
        display: flex;
        align-items: center;
        border-radius: 4px;
        position: relative;
        }

        .slider-scrollbar:hover .scrollbar-track {
        height: 4px;
        }

        .slider-scrollbar .scrollbar-thumb {
        position: absolute;
        background: #000;
        top: 0;
        bottom: 0;
        width: 50%;
        height: 100%;
        cursor: grab;
        border-radius: inherit;
        }

        .slider-scrollbar .scrollbar-thumb:active {
        cursor: grabbing;
        height: 8px;
        top: -2px;
        }

        .slider-scrollbar .scrollbar-thumb::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: -10px;
        bottom: -10px;
        }

        /* Styles for mobile and tablets */
        @media only screen and (max-width: 1023px) {
            .slider-wrapper .slide-button {
                display: none !important;
            }

            .slider-wrapper .image-list {
                gap: 10px;
                margin-bottom: 15px;
                scroll-snap-type: x mandatory;
            }

            .slider-wrapper .image-list .image-item {
                width: 280px;
                height: 380px;
            }

            .slider-scrollbar .scrollbar-thumb {
                width: 20%;
            }
        }
    </style>
</head>

<body>

{{--
    <div class="preload">
        <div class="flexbox">
            <div>
                <img src="{{ asset('images/loader/loader.gif') }}" alt="">
            </div>
        </div>
    </div> --}}

    @include('layouts.partials.sidebar')

    <div class="main-content mb-6">
        <div class="main-header shadow-sm">
            <div hidden class="btn-group dropdown">
                <button type="button" class="notificationBell dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell Icon"></i>
                    <div id="total">0</div>
                </button>
                <div class="dropdown-menu dropdown-menu-right" id="notification">
                    <a class="dropdown-item" href="#">
                        <div class="message"></div>
                        <div class="time"></div>
                    </a>
                </div>
            </div>
        </div>

        @yield('content')

        @role('customer')
        @include('layouts.customer')
        @endrole
    </div>

    <style>

        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            will-change: transform;
            transform: translateZ(0);
            display: flex;
            height: 50px;
            box-shadow: 0 -2px 5px -2px #333;
            background-color: #fff;
        }
        .mobile-bottom-nav__item {
            flex-grow: 1;
            text-align: center;
            font-size: 12px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .mobile-bottom-nav__item--active {
            color: red;
        }
        .mobile-bottom-nav__item-content {
            display: flex;
            flex-direction: column;
        }
    </style>


    @if($server == '"Android"')
    <nav class="mobile-bottom-nav ">

        <a class="mobile-bottom-nav__item {{ request()->routeIs('root') ? 'mobile-bottom-nav__item--active' : '' }}"
            href="{{ route('root') }}">
            <div class="mobile-bottom-nav__item-content">
                <i class="material-icons">home</i>
                Home
            </div>
        </a>
        <a class="mobile-bottom-nav__item {{ request()->routeIs('garansi.*') ? 'mobile-bottom-nav__item--active' : '' }}"
            href="{{ route('garansi.index') }}" >
            <div class="mobile-bottom-nav__item-content">
                <i class="material-icons">mail</i>
                Garansi
            </div>
        </a>
        <a class="mobile-bottom-nav__item {{ request()->routeIs('klaim.*') ? 'mobile-bottom-nav__item--active' : '' }}"
            href="{{ route('klaim.index') }}">
            <div class="mobile-bottom-nav__item-content">
                <i class="material-icons">shopping_cart_checkout</i>
                Klaims
            </div>
        </a>


        <a class="mobile-bottom-nav__item"  onclick="event.preventDefault(); document.getElementById('logout').submit()"
            href="#">
            <div class="mobile-bottom-nav__item-content">
                <i class="material-icons">exit_to_app</i>
                Logout
            </div>
        </a>
        <form id="logout" action="{{ route('logout') }}" method="POST"> @csrf </form>
    </nav>
    @endif


    <script src="{{ asset('web/js/jquery.min.js') }}"></script>
    <script src="{{ asset('web/js/popper.js') }}"></script>
    <script src="{{ asset('web/js/sweet-alert.js') }}"></script>
    <script src="{{ asset('web/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('web/js/select2.min.js') }}"></script>


    <script src="{{ asset('web/js/argon.js') }}"></script>
    <script src="{{ asset('web/js/main.js') }}"></script>
    <script src="{{ asset('web/js/datatables.min.js') }}"></script>
    <script src="{{ asset('web/js/toastr.min.js') }}"></script>

    <script src="https://tympanus.net/codrops/adpacks/cda_sponsor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <!-- <script>
        var pusher = new Pusher("{{ config('app.pusher_key') }}", {
            cluster: "{{ config('app.pusher_cluster') }}"
        });

        var channel = pusher.subscribe('popup-channel');
        channel.bind('order-notification', function(data) {
            toastr.success(JSON.stringify(data.message))
            showNotifications()
        });

    </script> -->

    <script>
        // const showNotifications = function() {
        //     var totalNumber = $('#total');

        //     $.ajax({
        //         type: 'GET',
        //         url: "{{ route('new.orders') }}",
        //         dataType: 'json',
        //         success: function(response) {
        //             $('#total').text(response.data.orders.length)
        //             $('#notification').empty()
        //             $.each(response.data.orders, function(key, value) {
        //                 $('#notification').append(
        //                 "<a class='dropdown-item' href='/orders/"+ value.id+"'><div class='message'>New Order From <strong>"+value.customer.user.name+"</strong> Order ID: "+value.order_code+"</div> <div class='time'>"+value.ordered_at+"</div></a>"
        //                 );
        //             })
        //         },
        //         error: function(e) {
        //             $('#notification').empty()
        //             $("#notification").html(e.responseText);
        //         }
        //     });
        // }
        // showNotifications()

        $('.visitorMessage').click(function(e) {
            e.preventDefault()
            Swal.fire(
                'Access Denied!',
                "You don't have permission to create, update or delete because you are visitor.",
                'warning'
            )
        })
    </script>

    @if (session('visitor'))
        <script>
            Swal.fire(
                'You are visitor.',
                'Sorry, you can\'t anything create, update and delete.',
                'question'
            )
        </script>
    @endif

    @if (session('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            })
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 2000
            })
        </script>
    @endif

    @stack('scripts')

    <script>
        $('#language').change(function() {
            var url = "{{ route('change.local') }}";
            var lan = $(this).val();
            window.location.href = url + '?ln=' + lan;
        });

        const lang = '{{ session()->get('local') }}';
        if (lang === 'ar') {
            $('#myTable').DataTable({
                language: {
                    'paginate': {
                        'previous': '<i class="fas fa-angle-double-left"></i>',
                        'next': '<i class="fas fa-angle-double-right"></i>'
                    },
                    "lengthMenu": "يعرض _MENU_ إدخالات",
                    "zeroRecords": "لم يتم العثور على سجلات مطابقة",
                    "info": "إظهار _START_ إلى _END_ من أصل _TOTAL_ إدخالات",
                    "infoEmpty": "لا توجد بيانات متوفرة في الجدول",
                    "infoFiltered": "(تمت تصفيته من إجمالي _MAX_ إدخالات)",
                    "search": "يبحث:",
                }
            });
        } else {
            $('#myTable').DataTable({
                language: {
                    'paginate': {
                        'previous': '<i class="fas fa-angle-double-left"></i>',
                        'next': '<i class="fas fa-angle-double-right"></i>'
                    },
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select One",
            });
        });

        //delete confirm sweet alert
        $('.delete-confirm').on('click', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00B894',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        });
    </script>

    <script>
        var navItems = document.querySelectorAll(".mobile-bottom-nav__item");
        navItems.forEach(function(e, i) {
            e.addEventListener("click", function(e) {
                navItems.forEach(function(e2, i2) {
                    e2.classList.remove("mobile-bottom-nav__item--active");
                })
                this.classList.add("mobile-bottom-nav__item--active");
            });
        });
    </script>
</body>

</html>
