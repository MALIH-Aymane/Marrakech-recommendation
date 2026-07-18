@extends('layouts.crud')

@section('title','Historique des connexions')

@section('content')

<div class="container py-5">

    <h2 class="fw-bold mb-4" style="color:#8B4513;">
        <i class="bi bi-clock-history"></i>
        Historique des connexions
    </h2>

    <div class="card shadow rounded-4 border-0">

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-warning">

                        <tr>
                            <th>Utilisateur</th>
                            <th>Email</th>
                            <th>IP</th>
                            <th>Navigateur</th>
                            <th>Système</th>
                            <th>Date</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($histories as $history)

                        <tr>

                            <td>{{ $history->user->name }}</td>

                            <td>{{ $history->user->email }}</td>

                            <td>{{ $history->ip_address }}</td>

                            <td>{{ $history->browser }}</td>

                            <td>{{ $history->platform }}</td>

                            <td>{{ $history->login_at }}</td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                Aucun historique.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>
            </div>

            {{ $histories->links() }}

        </div>

    </div>

</div>

@endsection
