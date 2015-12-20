@extends('admin.master.layout')

@section('title') Utenti @endsection

@section('content')

    <h3>Filtra</h3>
    <p>Usa i filtri qui di seguito per raffinare la tua ricerca.</p>

    <div class="row">
        <form action="">
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Nome..." name="name" value="{{ Request::get('name', '') }}" />
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Email..." name="email" value="{{ Request::get('email', '') }}" />
            </div>
            <div class="col-md-3">
                <select name="role" id="role" class="form-control">
                    <option value="all" selected>Tutti</option>
                    <option value="user">Utenti</option>
                    <option value="editor">Editor</option>
                    <option value="administrator">Amministratori</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-info"><span class="fa fa-search"></span> Filtra</button>
                <a href="{{ url('admin/users') }}" class="btn btn-warning"><span class="fa fa-reorder"></span> Reset</a>
            </div>
        </form>
    </div>

    <hr>

    <h3>Elenco</h3>
    <p>Di seguito l'elenco degli utenti richiesto.</p>

    {!! $users->appends(['name' => Request::get('name', ''), 'email' => Request::get('email', ''), 'role' => Request::get('role', 'all')])->render() !!}

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Indirizzo Email</th>
                <th>Iscritto Il</th>
                <th>Ruolo</th>
                <th>Operazioni</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ date('d/m/Y', strtotime($user->created_at)) }}</td>
                    <td>
                        @if($user->role->name == 'user') Utente @endif
                        @if($user->role->name == 'editor') Editor @endif
                        @if($user->role->name == 'administrator') Amministratore @endif
                    </td>
                    <td>
                        @if($user->id !== Auth::user()->id)
                            @if($user->role->name !== 'user')
                                <button class="btn btn-info"><span class="fa fa-user"></span> Rendi Utente</button>
                            @endif

                            @if($user->role->name !== 'editor')
                                <button class="btn btn-warning"><span class="fa fa-pencil"></span> Rendi Editor</button>
                            @endif

                            @if($user->role->name !== 'administrator')
                                <button class="btn btn-success"><span class="fa fa-eye"></span> Rendi Amministratore</button>
                            @endif

                            <button class="btn btn-danger"><span class="fa fa-remove"></span> Blocca</button>
                        @else
                            <i>Nessuna disponibile</i>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {!! $users->appends(['name' => Request::get('name', ''), 'email' => Request::get('email', ''), 'role' => Request::get('role', 'all')])->render() !!}

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('#role').val('{{ Request::get('role', 'all') }}');
        });
    </script>
@endsection