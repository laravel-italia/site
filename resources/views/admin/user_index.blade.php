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
    <p>Di seguito l'elenco degli utenti richiesto. (<a href="#newEditorModal" data-toggle="modal">Invita un nuovo Editor</a>)</p>

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
                        @if($user->role->name == 'editor') Editor @endif
                        @if($user->role->name == 'administrator') Amministratore @endif
                    </td>
                    <td>
                        <a href="#profilePictureModal" data-toggle="modal" data-id="{{ $user->id }}" class="btn btn-default picture-button"><span class="fa fa-image"></span> Cambia Foto</a>

                        @if($user->id !== Auth::user()->id)
                            @if($user->role->name !== 'editor')
                                <button data-id="{{ $user->id }}" class="btn btn-warning editor-button"><span class="fa fa-pencil"></span> Rendi Editor</button>
                            @endif

                            @if($user->role->name !== 'administrator')
                                <button data-id="{{ $user->id }}" class="btn btn-success administrator-button"><span class="fa fa-eye"></span> Rendi Amministratore</button>
                            @endif

                            @if($user->is_blocked == false)
                                <button data-id="{{ $user->id }}" class="btn btn-danger block-button"><span class="fa fa-remove"></span> Blocca</button>
                            @else
                                <button data-id="{{ $user->id }}" class="btn btn-info unblock-button"><span class="fa fa-check"></span> Sblocca</button>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {!! $users->appends(['name' => Request::get('name', ''), 'email' => Request::get('email', ''), 'role' => Request::get('role', 'all')])->render() !!}

    <div class="modal fade" id="newEditorModal" tabindex="-1" role="dialog" aria-labelledby="newEditorModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="publishModalLabel">Invita Editor</h4>
                </div>
                <form id="article_publish_form" action="{{ url('admin/users/invite') }}" method="post">
                    {!! csrf_field() !!}

                    <div class="modal-body">
                        <p>Inserisci nome completo ed indirizzo email del nuovo editor. Verrà inviato un invito.</p>

                        <p><input type="text" class="form-control" name="name" placeholder="Nome..." /></p>
                        <p><input type="text" class="form-control" name="email" placeholder="Indirizzo Email..." /></p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Invita Editor</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-remove"></span> Chiudi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="profilePictureModal" tabindex="-1" role="dialog" aria-labelledby="newEditorModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="publishModalLabel">Cambia Foto</h4>
                </div>
                <form id="article_publish_form" enctype="multipart/form-data" action="{{ url('admin/users/change-picture') }}" method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" name="user_id" id="user_id" />

                    <div class="modal-body">
                        <p class="user-picture"></p>
                        <hr>

                        <p>Scegli una nuova foto profilo per l'utente.</p>
                        <p><input type="file" class="form-control" name="picture" /></p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Carica</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-remove"></span> Chiudi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        .user-picture {
            text-align: center;
        }

        .user-picture img {
            max-width: 150px;
        }
    </style>

    <script>
        $(document).ready(function(){
            $('#role').val('{{ Request::get('role', 'all') }}');

            $('.picture-button').click(function() {
                var pictureUrl = '{{ url('profile-pictures') }}/' + $(this).data('id') + '.jpg';

                $('#user_id').val($(this).data('id'));

                $('.user-picture').html('<img src="' + pictureUrl + '" id="user_picture" />');

                $('#user_picture').attr('src', '{{ url('profile-pictures') }}/' + $(this).data('id') + '.jpg');
                $('#user_picture').on('error', function(){
                   $(this).parent().text('Nessuna foto presente per l\'utente.');
                });
            });

            $('.block-button').click(function(){
                if(confirm('Sicuro di bloccare questo utente?')) {
                    window.location.href = '{{ url('admin/users/block') }}/' + $(this).data('id');
                }
            });

            $('.unblock-button').click(function(){
                if(confirm('Sicuro di sbloccare questo utente?')) {
                    window.location.href = '{{ url('admin/users/unblock') }}/' + $(this).data('id');
                }
            });

            $('.user-button').click(function(){
                if(confirm('Vuoi dare a questa persona il ruolo di "Utente"?')) {
                    window.location.href = '{{ url('admin/users/switch') }}/' + $(this).data('id') + '/user';
                }
            });

            $('.editor-button').click(function(){
                if(confirm('Vuoi dare a questa persona il ruolo di "Editor"?')) {
                    window.location.href = '{{ url('admin/users/switch') }}/' + $(this).data('id') + '/editor';
                }
            });

            $('.administrator-button').click(function(){
                if(confirm('Vuoi dare a questa persona il ruolo di "Amministratore"?')) {
                    window.location.href = '{{ url('admin/users/switch') }}/' + $(this).data('id') + '/administrator';
                }
            });
        });
    </script>
@endsection
