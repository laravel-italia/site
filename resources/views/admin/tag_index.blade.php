@extends('admin.master.layout')

@section('title') Tag @endsection

@section('content')
    <p>Gestisci da qui i tag del forum.</p>

    <hr>

    <p><button class="btn btn-success" id="add_button">+ Aggiungi Tag</button></p>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Tag</th>
                <th>Link</th>
                <th>Operazioni</th>
            </tr>
            </thead>
            <tbody>
            @forelse($tags as $tag)
                <tr>
                    <td>{{ $tag->id }}</td>
                    <td>{{ $tag->name }}</td>
                    <td><a href="{{ url('forum?tag=' . $tag->slug) }}" target="_blank">Guarda nel Forum</a></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info edit_button" data-id="{{ $tag->id }}"><span class="fa fa-pencil"></span> Modifica</button>
                        <button type="button" class="btn btn-sm btn-danger delete_button" data-id="{{ $tag->id }}"><span class="fa fa-remove"></span> Cancella</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        Nessun tag presente, al momento.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="publishModalLabel">Aggiungi Tag</h4>
                </div>
                <form id="tag_add_form" action="{{ url('admin/tags/add') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="modal-body">
                        <p>Scegli il nome del tag da aggiungere.</p>
                        <p><input type="text" class="form-control" name="name" id="name" required /></p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Aggiungi</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-remove"></span> Annulla</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editModalLabel">Modifica Tag</h4>
                </div>
                <form id="tag_edit_form" action="" method="post">
                    {!! csrf_field() !!}
                    <div class="modal-body">
                        <p>Scegli il nuovo nome per questo tag.</p>
                        <p><input type="text" class="form-control" name="name" id="new_name" required /></p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Salva</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-remove"></span> Annulla</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){

            $('#addModal').on('shown.bs.modal', function(){
                $('#name').focus();
            });

            $('#add_button').click(function(){
                $('#name').val('');
                $('#addModal').modal('toggle');
            });

            $('.edit_button').click(function(){
                $.get( "{{ url('admin/tags/details') }}/" + $(this).data('id'))
                        .done(function(data){
                            $('#tag_edit_form').prop('action', '{{ url('admin/tags/edit') }}/' + data.id);
                            $('#new_name').val(data.name);
                            $('#editModal').modal('toggle');
                        })
                        .error(function(){
                            alert('Il tag scelto non esiste o non è più disponibile.');
                            window.location.href = '{{ url('admin/tags') }}';
                        });
            });

            $('#editModal').on('shown.bs.modal', function(){
                $('#new_name').focus();
            });

            $('.delete_button').click(function(){
                if(confirm('Sicuro di voler cancellare questo tag?')){
                    window.location.href = '{{ url('admin/tags/delete') }}/' + $(this).data('id');
                }
            });

        });
    </script>
@endsection
