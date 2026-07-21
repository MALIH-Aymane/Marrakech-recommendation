@extends('layouts.crud')

@section('title','Historique de connexion')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold" style="color:#8B4513;">

                <i class="bi bi-clock-history"></i>
                     {{ __('login_history.title') }}

            </h2>

            <p class="text-muted">

               {{ __('login_history.subtitle') }}

            </p>

        </div>

        <a href="{{ route('profile.edit') }}"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left"></i>

            {{ __('login_history.back_profile') }}

        </a>

    </div>

    <div class="card shadow rounded-4 border-0">

        <div class="card-body">

            @if($histories->count())

                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>{{ __('login_history.date') }}</th>

                                <th>{{ __('login_history.browser') }}</th>

                                <th>{{ __('login_history.platform') }}</th>

                                <th>{{ __('login_history.ip') }}</th>

                                <th>{{ __('login_history.user') }}</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($histories as $history)

                            <tr>

                                <td>

                                    {{ \Carbon\Carbon::parse($history->login_at)->format('d/m/Y H:i') }}

                                </td>

                                <td>

                                    <span class="badge bg-primary">

                                        {{ $history->browser }}

                                    </span>

                                </td>

                                <td>

                                    <span class="badge bg-success">

                                        {{ $history->platform }}

                                    </span>

                                </td>

                                <td>

                                    {{ $history->ip_address }}

                                </td>

                                <td style="max-width:350px;">

                                    <small class="text-muted">

                                        {{ \Illuminate\Support\Str::limit($history->user_agent,70) }}

                                    </small>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4 mb-2">
                         {{ $histories->links() }}
                </div>
            @else

                <div class="alert alert-info text-center">

                    <i class="bi bi-info-circle-fill"></i>

                    {{ __('login_history.no_history') }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection
<style>

.table tbody tr:hover{
    background:#fff8ef;
}

.pagination{
    margin-bottom:0;
}

.pagination .page-link{
    border:none;
    border-radius:12px;
    margin:0 4px;
    padding:8px 14px;
    transition:.3s;
}

.pagination .page-link:hover{
    transform:translateY(-2px);
}

</style>