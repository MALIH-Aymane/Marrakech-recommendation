<div class="col-md-6 col-lg-4">

    <div class="card attraction-card h-100 shadow-sm">

        {{-- Images --}}

        @if($attraction->images->count())

            <div id="carousel{{ $attraction->id }}"
                 class="carousel slide"
                 data-bs-ride="carousel">

                <div class="carousel-inner">

                    @foreach($attraction->images as $image)

                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">

                            <img

                                src="{{ asset('storage/'.$image->image) }}"

                                class="d-block w-100 attraction-image"

                                alt="{{ $attraction->attraction }}">

                        </div>

                    @endforeach

                </div>

                @if($attraction->images->count()>1)

                    <button
                        class="carousel-control-prev"
                        type="button"
                        data-bs-target="#carousel{{ $attraction->id }}"
                        data-bs-slide="prev">

                        <span class="carousel-control-prev-icon"></span>

                    </button>

                    <button
                        class="carousel-control-next"
                        type="button"
                        data-bs-target="#carousel{{ $attraction->id }}"
                        data-bs-slide="next">

                        <span class="carousel-control-next-icon"></span>

                    </button>

                @endif

            </div>

        @endif

        <div class="card-body d-flex flex-column">

            <h4 class="fw-bold mb-2">

                {{ $attraction->attraction }}

            </h4>

            <div class="mb-3">

                <span class="badge rounded-pill bg-warning text-dark">

                    {{ __('attractions.types.'.$attraction->type) }}

                </span>

                @if(isset($attraction->similarity))

                    <span class="badge bg-success ms-2">

                        🎯 {{ number_format($attraction->similarity*100,1) }}%

                    </span>

                @endif

            </div>

            <p class="text-muted flex-grow-1">

                {{ \Illuminate\Support\Str::limit(strip_tags($attraction->details),120) }}

            </p>

            <a

                href="{{ route('attractions.show',$attraction->id) }}"

                class="btn btn-warning rounded-pill mt-3">

                <i class="bi bi-eye-fill"></i>

                {{ __('attractions.details') }}

            </a>

        </div>

    </div>

</div>
