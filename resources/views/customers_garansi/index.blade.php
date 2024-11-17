@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center py-2 justify-content-between">
                        <h2 class="card-title m-0">{{ __('All'). ' '.__('Garansi') }}</h2>

                        @role('root')
                        @can('customer.create')
                        <a href="{{ route('garansi.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> {{ __('New'). ' '.__(' Garansi') }}
                        </a>
                        @endcan
                        @endrole
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped {{ session()->get('local') }}" id="myTable">
                                <thead>
                                    <tr>
                                        @role('root')
                                        <th scope="col">{{ __('Name') }}</th>
                                        @endrole
                                        <th scope="col">{{ __('No. Nota') }}</th>
                                        <th scope="col">{{ __('Waktu & Tgl. Pemasangan') }}</th>
                                        <th scope="col">{{ __('Masa Berlaku') }}</th>
                                        @canany(['customer.show', 'customer.edit'])
                                        <th scope="col">{{ __('Action') }}</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($garansis))
                                    @foreach ($garansis as $garansi)
                                        <tr>
                                            @role('root')
                                            <td>{{ $garansi->user->name }}</td>
                                            @endrole
                                            <td>
                                                {{ $garansi->no_nota }} <br>
                                                <small> Tgl nota : {{ date('d-m-Y', strtotime($garansi->tanggal_nota)) }} </small>
                                            </td>
                                            <td>
                                                Waktu : {{ date('H:i:s',strtotime($garansi->waktu_pemasangan)) }} <br>
                                                <small> Tgl pemasangan : {{ date('d-m-Y', strtotime($garansi->tanggal_pemasangan)) }} </small>
                                            </td>
                                            <td>
                                                @php
                                                    $dateExp = strtotime('+90 days', strtotime($garansi->tanggal_pemasangan));
                                                    $dateExps = date('d-m-Y', $dateExp);


                                                    $paymentDate = now();
                                                    $paymentDate = date('Y-m-d', strtotime($paymentDate));
                                                    //echo $paymentDate; // echos today!
                                                    $contractDateBegin = date('Y-m-d', strtotime($garansi->tanggal_pemasangan));
                                                    $contractDateEnd = date('Y-m-d', strtotime($dateExps));

                                                    if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                                                            $berlaku_s ='<span class="badge badge-success"> Berlaku : '.now()->diffInDays($dateExps).' Hari </span> <br>';
                                                    }else{
                                                        if($paymentDate <= $contractDateEnd){

                                                            $berlaku_s ='<span class="badge badge-success"> Berlaku : '.now()->diffInDays($dateExps).' Hari </span> <br>';
                                                        }else{
                                                            $berlaku_s ='<span class="badge badge-danger"> Berlaku : Expired </span> <br>';
                                                        }

                                                    }
                                                @endphp

                                                {!! $berlaku_s !!}
                                                <small> Sampai : {{ $dateExps }} </small>

                                            </td>

                                            <td>
                                                <a href="{{ route('garansi.show', $garansi->id) }}"
                                                    class="btn btn-primary py-1 px-2">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                @role('root')
                                                    <a href="{{ route('garansi.edit', $garansi->id) }}"
                                                        class="btn btn-info py-1 px-2">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <a href="{{ route('garansi.delete', $garansi->id) }}"
                                                        class="btn btn-danger py-1 px-2 delete-confirm" >
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endrole
                                            </td>

                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container m-4 pt-6">

        @php
            $banner = \App\Models\Banner::get();
        @endphp
        <div class="slider-wrapper">
            <button id="prev-slide" class="slide-button material-symbols-rounded">
                chevron_left
            </button>
            <ul class="image-list">
                @foreach ($banner as $banners )
    
                @php
                $get_media = DB::table('media')->where('id', $banners ->thumbnail_id)->first();
                @endphp
    
                <img class="image-item"  src="{{ Storage::url($get_media->path);  }}" alt="img-1" />
                @endforeach
            </ul>
            <button id="next-slide" class="slide-button material-symbols-rounded">
                chevron_right
            </button>
        </div>
        <div class="slider-scrollbar">
            <div class="scrollbar-track">
                <div class="scrollbar-thumb"></div>
            </div>
        </div>
    
    </div>
    
    <style>
        td {
            padding: 5px 10px !important;
        }
    </style>
@endsection
@push('scripts')
    <script>
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
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        });
    </script>
    <script>
        const initSlider = () => {
            const imageList = document.querySelector(".slider-wrapper .image-list");
            const slideButtons = document.querySelectorAll(".slider-wrapper .slide-button");
            const sliderScrollbar = document.querySelector(".container .slider-scrollbar");
            const scrollbarThumb = sliderScrollbar.querySelector(".scrollbar-thumb");
            const maxScrollLeft = imageList.scrollWidth - imageList.clientWidth;
            
            // Handle scrollbar thumb drag
            scrollbarThumb.addEventListener("mousedown", (e) => {
                const startX = e.clientX;
                const thumbPosition = scrollbarThumb.offsetLeft;
                const maxThumbPosition = sliderScrollbar.getBoundingClientRect().width - scrollbarThumb.offsetWidth;
                
                // Update thumb position on mouse move
                const handleMouseMove = (e) => {
                    const deltaX = e.clientX - startX;
                    const newThumbPosition = thumbPosition + deltaX;

                    // Ensure the scrollbar thumb stays within bounds
                    const boundedPosition = Math.max(0, Math.min(maxThumbPosition, newThumbPosition));
                    const scrollPosition = (boundedPosition / maxThumbPosition) * maxScrollLeft;
                    
                    scrollbarThumb.style.left = `${boundedPosition}px`;
                    imageList.scrollLeft = scrollPosition;
                }

                // Remove event listeners on mouse up
                const handleMouseUp = () => {
                    document.removeEventListener("mousemove", handleMouseMove);
                    document.removeEventListener("mouseup", handleMouseUp);
                }

                // Add event listeners for drag interaction
                document.addEventListener("mousemove", handleMouseMove);
                document.addEventListener("mouseup", handleMouseUp);
            });

            // Slide images according to the slide button clicks
            slideButtons.forEach(button => {
                button.addEventListener("click", () => {
                    const direction = button.id === "prev-slide" ? -1 : 1;
                    const scrollAmount = imageList.clientWidth * direction;
                    imageList.scrollBy({ left: scrollAmount, behavior: "smooth" });
                });
            });

            // Show or hide slide buttons based on scroll position
            const handleSlideButtons = () => {
                slideButtons[0].style.display = imageList.scrollLeft <= 0 ? "none" : "flex";
                slideButtons[1].style.display = imageList.scrollLeft >= maxScrollLeft ? "none" : "flex";
            }

            // Update scrollbar thumb position based on image scroll
            const updateScrollThumbPosition = () => {
                const scrollPosition = imageList.scrollLeft;
                const thumbPosition = (scrollPosition / maxScrollLeft) * (sliderScrollbar.clientWidth - scrollbarThumb.offsetWidth);
                scrollbarThumb.style.left = `${thumbPosition}px`;
            }

            // Call these two functions when image list scrolls
            imageList.addEventListener("scroll", () => {
                updateScrollThumbPosition();
                handleSlideButtons();
            });
        }

        window.addEventListener("resize", initSlider);
        window.addEventListener("load", initSlider);
    </script>
@endpush
