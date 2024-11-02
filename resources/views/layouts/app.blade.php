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
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@300;500&display=swap");

:root {
  --easing: cubic-bezier(0.645, 0.045, 0.355, 1);
}

html {
  color: #56688a;
  background: #fafafa;
}

.material-symbols-outlined {
  font-size: 24px;
  font-variation-settings: "FILL" 0, "wght" 200, "GRAD" 0, "opsz" 40;
  transition: transform 0.2s ease-in-out, color 0.2s ease-in-out;
}

.bottom-bar {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 56px;
  background: #ffffff;
  filter: drop-shadow(0px 0px 6px rgba(0, 0, 0, 0.1));
  display: flex;
  justify-content: center;
}

.bottom-bar__list {
  flex-basis: 32rem;
  display: flex;
  position: relative;
  cursor: pointer;
}

.bottom-bar__active-indicator {
  width: 20%;
  position: absolute;
  display: flex;
  justify-content: center;
  transform: translate(0, -0.5rem);
  pointer-events: none;
  transition: transform 0.3s var(--easing);
}

.bottom-bar__active-indicator::before {
  content: "";
  display: block;
  width: 2.5rem;
  height: 2.5rem;
  background: #d9dbf1;
  border-radius: 1.5rem;
  border: 4px solid white;
}

.bottom-bar__active-indicator.active--1::before {
  animation: Stretch 0.18s linear;
}
.bottom-bar__active-indicator.active--2::before {
  animation: Stretch2 0.2s linear;
}
.bottom-bar__active-indicator.active--3::before {
  animation: Stretch3 0.2s linear;
}
.bottom-bar__active-indicator.active--4::before {
  animation: Stretch4 0.225s linear;
}

.bottom-bar__active-indicator.active-left::before {
  transform-origin: center right;
}

.bottom-bar__active-indicator.active-right::before {
  transform-origin: center left;
}

.bottom-bar__link {
  flex: 1;
  font-size: 0.675rem;
  font-weight: 300;
  letter-spacing: 0.025rem;
  font-family: "Roboto", sans-serif;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 0.25rem;
  z-index: 2;
}

.bottom-bar__link.selected {
  font-weight: 500;
  letter-spacing: 0.0125rem;
  color: #1e2133;
}

.bottom-bar__link.selected .material-symbols-outlined {
  font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 40;
  font-size: 24px;
  transform: translateY(-0.25rem);
  transition: color 0.2s 0.1s ease-in-out, transform 0.3s var(--easing),
    font-variation-settings 0.2s 0.1s ease-in-out;
}

@keyframes Stretch {
  0% {
    transform: scale(1, 1);
  }
  50% {
    transform: scale(2.25, 0.65);
    border-radius: 1.25rem;
  }
  0% {
    transform: scale(1, 1);
  }
}

@keyframes Stretch2 {
  0% {
    transform: scale(1, 1);
  }
  50% {
    transform: scale(2.75, 0.625);
    border-radius: 1.125rem;
  }
  0% {
    transform: scale(1, 1);
  }
}

@keyframes Stretch3 {
  0% {
    transform: scale(1, 1);
  }
  50% {
    transform: scale(3.5, 0.6);
    border-radius: 1.125rem;
  }
  0% {
    transform: scale(1, 1);
  }
}

@keyframes Stretch4 {
  0% {
    transform: scale(1, 1);
  }
  50% {
    transform: scale(4.5, 0.55);
    border-radius: 1.125rem;
  }
  0% {
    transform: scale(1, 1);
  }
}

    </style>
    
    <nav hidden class="bottom-bar">
        <ul class="bottom-bar__list">
          <div class="bottom-bar__active-indicator"></div>
          <li class="bottom-bar__link selected"><span class="material-symbols-outlined">
              home
            </span>Home</i>
          <li class="bottom-bar__link"><span class="material-symbols-outlined">
              Search
            </span>Explore</li>
          <li class="bottom-bar__link"><span class="material-symbols-outlined">
              Favorite
            </span>Saved</li>
          <li class="bottom-bar__link"><span class="material-symbols-outlined">
              Notifications
            </span>Notifications</li>
          <li class="bottom-bar__link"><span class="material-symbols-outlined">
              Person
            </span>Profile</li>
        </ul>
      </nav>
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
       let list = document.querySelector(".bottom-bar__list");

let activeItemIndex = 1;

let items = list.children;

const handleClick = (index) => {
  if (index !== activeItemIndex) {
    items[activeItemIndex].classList.remove("selected");
    items[index].classList.add("selected");

    let direction;
    index - activeItemIndex > 0 ? (direction = 1) : (direction = -1);

    let magnitude = Math.abs(index - activeItemIndex);

    activeItemIndex = index;

    items[0].style.transform =
      "translate(" + (activeItemIndex - 1) * 100 + "%, -0.5rem)";

    items[0].classList.add("active--" + magnitude);
    items[0].classList.add(direction > 0 ? "active-right" : "active-left");
    console.log(items[0].classList);

    setTimeout(() => {
      items[0].classList.remove("active--" + magnitude);
      items[0].classList.remove(direction > 0 ? "active-right" : "active-left");
    }, 200);
  }
};

Object.keys(items).forEach((item, index) => {
  items[index].addEventListener("click", () => {
    handleClick(index);
  });
});

    </script>
</body>

</html>
