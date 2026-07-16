@extends('layouts.crud')

@section('title', 'Gestion des utilisateurs')

@section('content')

<div class="container py-5">

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            {{ session('error') }}

            <button class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold" style="color:#8B4513;">

                Gestion des utilisateurs

            </h2>

            <p class="text-muted">

                Gérez les comptes utilisateurs de Marrakech Tour.

            </p>

        </div>

    </div>

    <!-- ================= Cartes ================= -->

    <div class="row g-4 mb-4">

        <div class="col-lg-4">

            <div class="card border-0 shadow rounded-4 text-center h-100">

                <div class="card-body py-4">

                    <i class="bi bi-people-fill fs-1 text-primary"></i>

                    <h2 class="fw-bold mt-3">

                        {{ $totalUsers }}

                    </h2>

                    <p class="text-muted mb-0">

                        Utilisateurs

                    </p>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow rounded-4 text-center h-100">

                <div class="card-body py-4">

                    <i class="bi bi-shield-lock-fill fs-1 text-danger"></i>

                    <h2 class="fw-bold mt-3">

                        {{ $totalAdmins }}

                    </h2>

                    <p class="text-muted mb-0">

                        Administrateurs

                    </p>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow rounded-4 text-center h-100">

                <div class="card-body py-4">

                    <i class="bi bi-person-fill fs-1 text-success"></i>

                    <h2 class="fw-bold mt-3">

                        {{ $totalNormalUsers }}

                    </h2>

                    <p class="text-muted mb-0">

                        Utilisateurs simples

                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- ================= Tableau ================= -->

    <div class="card shadow border-0 rounded-4">

        <div class="card-body">
                    <div class="mb-4 d-flex gap-2 flex-wrap">

    <a href="{{ route('users.index') }}"
       class="btn {{ !request('role') ? 'btn-warning' : 'btn-outline-warning' }} rounded-pill">

        <i class="bi bi-people-fill"></i>

        Tous

    </a>

    <a href="{{ route('users.index', ['role' => 'Admin']) }}"
       class="btn {{ request('role') == 'Admin' ? 'btn-danger' : 'btn-outline-danger' }} rounded-pill">

        <i class="bi bi-shield-lock-fill"></i>

        Administrateurs

    </a>

    <a href="{{ route('users.index', ['role' => 'User']) }}"
       class="btn {{ request('role') == 'User' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill">

        <i class="bi bi-person-fill"></i>

        Utilisateurs

    </a>

</div>
            <form method="GET"
                  action="{{ route('users.index') }}"
                  class="mb-4">
                    <input type="hidden"name="role" value="{{ request('role') }}">
                <div class="input-group">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Rechercher par nom ou email..."
                        value="{{ request('search') }}">

                    <button class="btn btn-warning">

                        <i class="bi bi-search"></i>

                        Rechercher

                    </button>

                </div>

            </form>

            <table class="table table-hover align-middle">

                <thead class="table-warning">

                    <tr>

                        <th width="70">Avatar</th>

                        <th>Nom</th>

                        <th>Email</th>

                        <th width="120">Rôle</th>

                        <th width="180">Inscription</th>

                        <th width="220" class="text-center">

                            Actions

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($users as $user)
                    <tr>

    <td>

        <div class="rounded-circle bg-warning text-dark d-flex justify-content-center align-items-center fw-bold"
             style="width:45px;height:45px;">

            {{ collect(explode(' ', $user->name))
                ->map(fn($word)=>strtoupper(substr($word,0,1)))
                ->take(2)
                ->implode('') }}

        </div>

    </td>

    <td>

        <strong>

            {{ $user->name }}

        </strong>

    </td>

    <td>

        {{ $user->email }}

    </td>

    <td>

        @if($user->hasRole('Admin'))

            <span class="badge bg-danger">

                Admin

            </span>

        @else

            <span class="badge bg-primary">

                User

            </span>

        @endif

    </td>

    <td>

        <div class="fw-semibold">

            {{ $user->created_at->format('d/m/Y') }}

        </div>

        <small class="text-muted">

            {{ $user->created_at->format('H:i') }}

        </small>

    </td>

    <td class="text-center">

        <!-- Voir -->

        <button
    type="button"
    class="btn btn-info btn-sm view-user"

    data-id="{{ $user->id }}"
    data-name="{{ $user->name }}"
    data-email="{{ $user->email }}"
    data-role="{{ $user->hasRole('Admin') ? 'Administrateur' : 'Utilisateur' }}"
    data-role-type="{{ $user->hasRole('Admin') ? 'Admin' : 'User' }}"
    data-date="{{ $user->created_at->format('d/m/Y') }}"
    data-time="{{ $user->created_at->format('H:i') }}">

    <i class="bi bi-eye-fill"></i>

</button>

        <!-- Changer le rôle -->

        <form action="{{ route('users.role', $user) }}"
              method="POST"
              class="d-inline">

            @csrf
            @method('PATCH')

            @if(auth()->id() != $user->id)

                <button type="button" class="btn btn-warning btn-sm edit-role" data-bs-toggle="modal" data-bs-target="#roleModal"
                   data-id="{{ $user->id }}"
                   data-name="{{ $user->name }}"
                   data-role="{{ $user->hasRole('Admin') ? 'Admin' : 'User' }}">
                       <i class="bi bi-arrow-repeat"></i>

                </button>

            @else

                <button
                    class="btn btn-secondary btn-sm"
                    disabled
                    title="Vous ne pouvez pas modifier votre propre rôle">

                    <i class="bi bi-lock-fill"></i>

                </button>

            @endif

        </form>

        <!-- Supprimer -->

        @if(auth()->id() != $user->id)

        <form action="{{ route('users.destroy', $user) }}"
              method="POST"
              class="d-inline"
              onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">

            @csrf
            @method('DELETE')

           <button type="button" class="btn btn-danger btn-sm delete-user"data-bs-toggle="modal" data-bs-target="#deleteModal"
                data-id="{{ $user->id }}" data-name="{{ $user->name }}">

             <i class="bi bi-trash-fill"></i>

            </button>

        </form>

        @else

        <button
            class="btn btn-secondary btn-sm"
            disabled
            title="Impossible de supprimer votre compte">

            <i class="bi bi-lock-fill"></i>

        </button>

        @endif

    </td>

</tr>
@empty

<tr>

    <td colspan="6" class="text-center py-4">

        Aucun utilisateur trouvé.

    </td>

</tr>

@endforelse

</tbody>

</table>

<div class="mt-4">

    {{ $users->withQueryString()->links() }}

</div>

</div>

</div>
<div class="modal fade"
     id="adminUserModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 rounded-4 shadow-lg">

            <div class="modal-header"
                 style="background:#8B4513;color:white;">

                <h4 class="modal-title">

                    <i class="bi bi-person-circle"></i>

                    Détails de l'administrateur

                </h4>

                <button class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body p-5">

                <div class="text-center mb-4">

                    <div id="adminAvatar"
                         class="rounded-circle bg-warning text-dark d-flex justify-content-center align-items-center fw-bold mx-auto shadow"
                         style="width:110px;height:110px;font-size:38px;">

                    </div>

                    <h3 id="adminName"
                        class="fw-bold mt-3">
                    </h3>

                    <span class="badge bg-danger fs-6 px-3 py-2">

                        Administrateur

                    </span>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <div class="card border-0 bg-light rounded-4">

                            <div class="card-body">

                                <small>Email</small>

                                <h6 id="adminEmail"></h6>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <div class="card border-0 bg-light rounded-4">

                            <div class="card-body">

                                <small>ID</small>

                                <h6 id="adminId"></h6>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="card border-0 bg-light rounded-4">

                            <div class="card-body">

                                <small>Date d'inscription</small>

                                <h6 id="adminDate"></h6>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="card border-0 bg-light rounded-4">

                            <div class="card-body">

                                <small>Heure</small>

                                <h6 id="adminTime"></h6>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<!-- ===================== MODALE UTILISATEUR ===================== -->

<div class="modal fade" id="userModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 overflow-hidden user-modal">

            <div class="user-header">

                <button
                    type="button"
                    class="btn-close btn-close-white position-absolute end-0 top-0 m-4"
                    data-bs-dismiss="modal">
                </button>

                <div id="avatarUser" class="user-avatar shadow"></div>

                <h2 id="modalName" class="mt-4 fw-bold text-white"></h2>

                <span id="modalRoleBadge" class="badge rounded-pill px-4 py-2 mt-2"></span>

            </div>

            <div class="modal-body p-5">

                <div class="row g-4">

                    <div class="col-md-6">

                        <div class="info-card">

                            <i class="bi bi-envelope-fill text-warning fs-4"></i>

                            <small>Email</small>

                            <h6 id="modalEmail"></h6>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="info-card">

                            <i class="bi bi-person-vcard-fill text-primary fs-4"></i>

                            <small>ID Utilisateur</small>

                            <h6 id="modalId"></h6>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="info-card">

                            <i class="bi bi-calendar2-check-fill text-success fs-4"></i>

                            <small>Date d'inscription</small>

                            <h6 id="modalDate"></h6>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="info-card">

                            <i class="bi bi-clock-history text-danger fs-4"></i>

                            <small>Heure</small>

                            <h6 id="modalTime"></h6>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<!-- ===================== MODALE SUPPRESSION ===================== -->

<div class="modal fade"
     id="deleteModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header bg-danger text-white">

                <h5 class="modal-title">

                    <i class="bi bi-exclamation-triangle-fill"></i>

                    Confirmation

                </h5>

                <button  type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body text-center">

                <i class="bi bi-trash-fill text-danger"
                   style="font-size:60px;"></i>

                <h4 class="mt-3">

                    Supprimer cet utilisateur ?

                </h4>

                <p class="text-muted">

                    Vous êtes sur le point de supprimer

                    <strong id="deleteUserName"></strong>

                </p>

                <p class="text-danger">

                    Cette action est irréversible.

                </p>

            </div>

            <div class="modal-footer">

                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Annuler

                </button>

                <form id="deleteForm"
                      method="POST">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger">

                        Supprimer

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
<!-- ===================== MODALE MODIFIER LE RÔLE ===================== -->

<div class="modal fade"
     id="roleModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header bg-warning">

                <h5 class="modal-title">

                    <i class="bi bi-shield-lock-fill"></i>

                    Modifier le rôle

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form id="roleForm" method="POST">

                @csrf
                @method('PATCH')

                <div class="modal-body">

                    <p class="mb-3">

                        Utilisateur :

                        <strong id="roleUserName"></strong>

                    </p>

                    <div class="mb-3">

                        <label class="form-label">

                            Nouveau rôle

                        </label>

                        <select
                            name="role"
                            id="roleSelect"
                            class="form-select">

                            <option value="User">

                                User

                            </option>

                            <option value="Admin">

                                Admin

                            </option>

                        </select>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Annuler

                    </button>

                    <button
                        type="submit"
                        class="btn btn-warning">

                        Enregistrer

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===========================
    // AFFICHAGE DETAILS UTILISATEUR / ADMIN
    // ===========================

    document.querySelectorAll('.view-user').forEach(function(button){

        button.addEventListener('click', function(){

            let roleType = this.dataset.roleType;

            let name  = this.dataset.name;
            let email = this.dataset.email;
            let id    = this.dataset.id;
            let role  = this.dataset.role;
            let date  = this.dataset.date;
            let time  = this.dataset.time;

            let initials = name
                .split(' ')
                .map(word => word.charAt(0))
                .join('')
                .substring(0,2)
                .toUpperCase();

            // ===========================
            // ADMIN
            // ===========================

            if(roleType === "Admin"){

                document.getElementById('adminAvatar').textContent = initials;
                document.getElementById('adminName').textContent = name;
                document.getElementById('adminEmail').textContent = email;
                document.getElementById('adminId').textContent = id;
                document.getElementById('adminDate').textContent = date;
                document.getElementById('adminTime').textContent = time;

                let adminModal = new bootstrap.Modal(
                    document.getElementById('adminUserModal')
                );

                adminModal.show();
            }

            // ===========================
            // UTILISATEUR
            // ===========================

            else{

                document.getElementById('avatarUser').textContent = initials;
                document.getElementById('modalName').textContent = name;
                document.getElementById('modalEmail').textContent = email;
                document.getElementById('modalId').textContent = id;
                document.getElementById('modalDate').textContent = date;
                document.getElementById('modalTime').textContent = time;

                const badge = document.getElementById('modalRoleBadge');

                badge.textContent = role;
                badge.className = "badge bg-primary rounded-pill px-4 py-2";

                let userModal = new bootstrap.Modal(
                    document.getElementById('userModal')
                );

                userModal.show();
            }

        });

    });



    // ===========================
    // SUPPRESSION
    // ===========================

    document.querySelectorAll('.delete-user').forEach(function(button){

        button.addEventListener('click', function(){

            document.getElementById('deleteUserName').textContent =
                this.dataset.name;

            document.getElementById('deleteForm').action =
                "/users/" + this.dataset.id;

        });

    });



    // ===========================
    // MODIFICATION ROLE
    // ===========================

    document.querySelectorAll('.edit-role').forEach(function(button){

        button.addEventListener('click', function(){

            document.getElementById('roleUserName').textContent =
                this.dataset.name;

            document.getElementById('roleSelect').value =
                this.dataset.role;

            document.getElementById('roleForm').action =
                "/users/" + this.dataset.id + "/role";

        });

    });



    // ===========================
    // CORRECTION BOOTSTRAP
    // ===========================

    document.querySelectorAll('.modal').forEach(function(modal){

        modal.addEventListener('hidden.bs.modal', function(){

            document.body.classList.remove('modal-open');

            document.body.style.paddingRight = '';

            document.querySelectorAll('.modal-backdrop').forEach(function(backdrop){

                backdrop.remove();

            });

        });

    });

});

</script>

<style>

.card{
    transition:.3s;
}

.card:hover{
    transform:translateY(-5px);
    box-shadow:0 15px 35px rgba(0,0,0,.15);
}

.table tbody tr:hover{
    background:#fff8ef;
}

.badge{
    font-size:.85rem;
}

.user-modal{

    border-radius:30px;
    overflow:hidden;

}

.user-header{

    background:linear-gradient(135deg,#8B4513,#C96A2B);
    padding:55px 30px;
    text-align:center;
    position:relative;

}

.user-avatar{

    width:130px;
    height:130px;
    border-radius:50%;
    margin:auto;
    background:white;
    color:#8B4513;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:46px;
    font-weight:bold;
}

.info-card{

    background:#faf7f2;
    border-radius:20px;
    padding:25px;
    text-align:center;
    transition:.35s;

}

.info-card:hover{

    transform:translateY(-6px);
    box-shadow:0 15px 35px rgba(0,0,0,.12);

}

.info-card small{

    display:block;
    color:#999;
    margin-top:10px;
    margin-bottom:8px;

}

.info-card h6{

    font-size:18px;
    font-weight:700;
    margin:0;

}

#modalRoleBadge{

    font-size:15px;

}

.modal-body table td{
    font-weight:500;
}

</style>

@endsection
