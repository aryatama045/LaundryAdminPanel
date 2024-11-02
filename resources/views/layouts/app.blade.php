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

</head>

<body>

    <div class="preload">
        <div class="flexbox">
            <div>
                <img src="{{ asset('images/loader/loader.gif') }}" alt="">
            </div>
        </div>
    </div>

    @include('layouts.partials.sidebar')

    <div class="main-content">
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

    </div>

    <style>


        body nav.tab {
        position: relative;
        display: flex;
        align-items: stretch;
        width: 23rem;
        height: 4rem;
        }
        body nav.tab.moving .icon {
        pointer-events: none;
        }
        body nav.tab[data-selected="1"] .icon:nth-child(1), body nav.tab[data-selected="2"] .icon:nth-child(2), body nav.tab[data-selected="3"] .icon:nth-child(3) {
        top: -1.5rem;
        color: #2ABA66;
        font-size: 2rem;
        transition: 0.25s 0.375s;
        pointer-events: none;
        }
        body nav.tab[data-selected="1"] .icon:nth-child(1).initialised, body nav.tab[data-selected="2"] .icon:nth-child(2).initialised, body nav.tab[data-selected="3"] .icon:nth-child(3).initialised {
        -webkit-animation: hide 0.9s forwards;
                animation: hide 0.9s forwards;
        }
        body nav.tab[data-selected="1"] .bar .middle .side:first-child, body nav.tab[data-selected="3"] .bar .middle .side:last-child {
        flex-grow: 0;
        }
        body nav.tab .icons {
        position: absolute;
        z-index: 2;
        display: flex;
        justify-content: space-around;
        width: calc(100% - 2rem);
        padding: 0 1rem;
        }
        body nav.tab .icons .icon {
        position: relative;
        top: 0rem;
        width: 4rem;
        line-height: 4rem;
        font-size: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition-delay: 0.1875s;
        }
        body nav.tab .icons .icon.initialised {
        -webkit-animation: hide2 0.375s;
                animation: hide2 0.375s;
        }
        body nav.tab .bar {
        z-index: 1;
        position: absolute;
        display: flex;
        align-items: stretch;
        filter: drop-shadow(0 0 0.5rem rgba(0, 0, 0, 0.1)) drop-shadow(0 0 0.25rem rgba(0, 0, 0, 0.1));
        width: 100%;
        height: 100%;
        }
        body nav.tab .bar .cap {
        background: white;
        width: 1rem;
        }
        body nav.tab .bar .cap:first-child {
        border-bottom-left-radius: 1rem;
        border-top-left-radius: 0.5rem;
        box-shadow: 0.25rem 0 0 white;
        }
        body nav.tab .bar .cap:last-child {
        border-bottom-right-radius: 1rem;
        border-top-right-radius: 0.5rem;
        box-shadow: -0.25rem 0 0 white;
        }
        body nav.tab .bar .middle {
        flex-grow: 1;
        position: relative;
        display: flex;
        }
        body nav.tab .bar .middle .circle {
        position: relative;
        top: -1.75rem;
        width: 7rem;
        height: 5.75rem;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='112' height='92' viewBox='0 0 112 92'%3E%3Ccircle cx='56' cy='36' r='36' fill='%23FFF'/%3E%3Cpath d='M104 35.2L104 35.2c0 26.3-20.9 48.3-47.2 48.8C29.9 84.4 8 62.8 8 36v-0.8c0-4-3.2-7.2-7.2-7.2H0v64h112V28h-0.8C107.2 28 104 31.2 104 35.2z' fill='%23FFF'/%3E%3C/svg%3E");
        }
        body nav.tab .bar .middle .side {
        flex-grow: 1;
        background: white;
        transition: 0.75s ease;
        }

        @-webkit-keyframes hide {
        0%, 100% {
            opacity: 1;
        }
        25%, 75% {
            opacity: 0;
        }
        }

        @keyframes hide {
        0%, 100% {
            opacity: 1;
        }
        25%, 75% {
            opacity: 0;
        }
        }
        @-webkit-keyframes hide2 {
        0%, 100% {
            opacity: 1;
        }
        15%, 75% {
            opacity: 0;
        }
        }
        @keyframes hide2 {
        0%, 100% {
            opacity: 1;
        }
        15%, 75% {
            opacity: 0;
        }
        }
    </style>
    
    <nav hidden class="tab" data-selected="2">
        <div class="icons">
          <div data-index="1" class="icon fad fa-home"></div>
          <div data-index="2" class="icon fal fa-plus"></div>
          <div data-index="3" class="icon fad fa-user fa-swap-opacity"></div>
        </div>
        <div class="bar">
          <div class="cap"></div>
          <div class="middle">
            <div class="side"></div>
            <div class="circle"></div>
            <div class="side"></div>
          </div>
          <div class="cap"></div>
        </div>
      </nav>
      Resources

    <script src="{{ asset('web/js/jquery.min.js') }}"></script>
    <script src="{{ asset('web/js/popper.js') }}"></script>
    <script src="{{ asset('web/js/sweet-alert.js') }}"></script>
    <script src="{{ asset('web/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('web/js/select2.min.js') }}"></script>

    <script src="{{ asset('web/js/argon.js') }}"></script>
    <script src="{{ asset('web/js/main.js') }}"></script>
    <script src="{{ asset('web/js/datatables.min.js') }}"></script>
    <script src="{{ asset('web/js/toastr.min.js') }}"></script>

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        var pusher = new Pusher("{{ config('app.pusher_key') }}", {
            cluster: "{{ config('app.pusher_cluster') }}"
        });

        var channel = pusher.subscribe('popup-channel');
        channel.bind('order-notification', function(data) {
            toastr.success(JSON.stringify(data.message))
            showNotifications()
        });
    </script>

    <script>
        const showNotifications = function() {
            var totalNumber = $('#total');

            $.ajax({
                type: 'GET',
                url: "{{ route('new.orders') }}",
                dataType: 'json',
                success: function(response) {
                    $('#total').text(response.data.orders.length)
                    $('#notification').empty()
                    $.each(response.data.orders, function(key, value) {
                        $('#notification').append(
                        "<a class='dropdown-item' href='/orders/"+ value.id+"'><div class='message'>New Order From <strong>"+value.customer.user.name+"</strong> Order ID: "+value.order_code+"</div> <div class='time'>"+value.ordered_at+"</div></a>"
                        );
                    })
                },
                error: function(e) {
                    $('#notification').empty()
                    $("#notification").html(e.responseText);
                }
            });
        }
        showNotifications()

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
        let previous = -1;
$(".icon[data-index]").click(function(){
  $(this).addClass("initialised");
  let index = $(this).attr("data-index");
  let navtab = $(this).closest("nav.tab").addClass("moving").attr("data-selected", index);
  if(previous == -1) navtab.find('.icon[data-index="2"]').addClass("initialised")
  if(previous == 1 && index == 3 || previous == 3 && index == 1) { //If going from one side to the other and middle needs to be hidden
    navtab.find('.icon[data-index="2"]').removeClass("initialised");
    setTimeout(function(){ //Because apparently this is the only way it will work
      navtab.find('.icon[data-index="2"]').addClass("initialised"); //Same animation as the other so they line up
    });
  }
  previous = index;
  setTimeout(function(){
    navtab.removeClass("moving").removeClass("hidemiddle");
  }, 750);
}); 
    </script>
</body>

</html>
