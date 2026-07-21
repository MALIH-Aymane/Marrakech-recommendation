@extends('layouts.crud')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold" style="color:#8B4513;">
              🕌 {{ __('attractions.title') }}
            </h2>

            <p class="text-muted">
             {{ __('attractions.subtitle') }}
            </p>
        </div>

        @role('Admin')
           <a href="{{ route('attractions.create') }}" class="btn btn-success">
              <i class="bi bi-plus-circle"></i>
               {{ __('attractions.add') }}
          </a>
        @endrole

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif
   <div class="mb-4 d-flex gap-2">

    <a href="{{ route('attractions.index') }}"
       class="btn {{ request('type') == 'activities' ? 'btn-outline-warning' : 'btn-warning' }}">

        🏛️ {{ __('attractions.all') }}

    </a>

    <a href="{{ route('attractions.index', ['type' => 'activities']) }}"
       class="btn {{ request('type') == 'activities' ? 'btn-warning' : 'btn-outline-warning' }}">

        🎯 {{ __('attractions.activities') }}

    </a>

</div>
    <div class="card shadow border-0 rounded-4">

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead style="background:#A0522D;color:white;">

    <tr>
        <th style="width:120px;">{{ __('attractions.photo') }}</th>

        <th style="width:240px;">
            {{ __('attractions.name') }}
        </th>

        <th style="width:90px;">
            {{ __('attractions.rating') }}
        </th>

        <th style="width:160px;">
            {{ __('attractions.type') }}
        </th>

        <th>
              {{ __('attractions.description') }}
        </th>

        <th style="width:140px;" class="text-center">
            {{ __('attractions.actions') }}
        </th>
    </tr>

    </thead>

                    <tbody>

                    @forelse($attractions as $attraction)

                        <tr>

        <td width="120">

            @if($attraction->photo)

                <img
                    src="{{ asset('storage/'.$attraction->photo) }}"
                    width="100"
                    height="70"
                    class="rounded shadow-sm"
                    style="object-fit:cover;">

            @else

                <span class="text-muted">

                  {{ __('attractions.no_image') }}
                </span>

            @endif

        </td>

        <td style="max-width:240px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">

        <strong title="{{ $attraction->attraction }}">

            {{ \Illuminate\Support\Str::limit($attraction->attraction, 25) }}

        </strong>

    </td>

        <td style="white-space: nowrap; width:90px;">

        ⭐ {{ number_format($attraction->rate,1) }}

    </td>

       <td style="width:160px;" class="align-middle">

        <span class="badge bg-warning text-dark">

            {{ $attraction->type }}

        </span>

    </td>

        <td width="350">

            {{ Str::limit(strip_tags($attraction->details),120) }}

        </td>

        <td style="width:140px;" class="text-center">

        <div class="d-flex justify-content-center align-items-center gap-2">

            <a href="{{ route('attractions.show',$attraction->id) }}"
       class="btn btn-info btn-sm">
        <i class="bi bi-eye-fill"></i>
    </a>

    @role('Admin')

    <a href="{{ route('attractions.edit',$attraction->id) }}"
       class="btn btn-warning btn-sm">
        <i class="bi bi-pencil-fill"></i>
    </a>

    <form action="{{ route('attractions.destroy',$attraction->id) }}"
          method="POST"
          class="d-inline">

        @csrf
        @method('DELETE')

        <button
           onclick="return confirm('{{ __('attractions.delete_confirm') }}')"
            class="btn btn-danger btn-sm">

            <i class="bi bi-trash-fill"></i>

        </button>

    </form>

    @endrole

        </div>

    </td>

    </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center py-4">

                              {{ __('attractions.empty') }}

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>
            </div>

                </div>

    </div>

    <div class="d-flex justify-content-center mt-4 mb-3">
        {{ $attractions->links() }}
    </div>

</div>

@endsection