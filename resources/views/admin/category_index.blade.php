@extends('admin.master.layout')

@section('title') Categorie @endsection

@section('content')
    <p>Gestisci da qui le categorie presenti sul sito.</p>

    <hr>

    <p><button class="btn btn-success" id="add_button">+ Aggiungi Categoria</button></p>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Articoli Associati</th>
                <th>Operazioni</th>
            </tr>
            </thead>
            <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->articles->count() }}</td>
                    <td>
                        <button class="btn btn-sm btn-info edit_button" data-id="{{  $category->id }}"><span class="fa fa-pencil"></span> Modifica</button>
                        <button type="button" class="btn btn-sm btn-danger delete_button" data-id="{{ $category->id }}"><span class="fa fa-remove"></span> Cancella</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        Nessuna categoria presente, al momento.
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
                    <h4 class="modal-title" id="publishModalLabel">Aggiungi Categoria</h4>
                </div>
                <form id="category_add_form" action="{{ url('admin/categories/add') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="modal-body">
                        <p>Scegli il nome della nuova categoria.</p>
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
                    <h4 class="modal-title" id="publishModalLabel">Modifica Categoria</h4>
                </div>
                <form id="category_edit_form" action="" method="post">
                    {!! csrf_field() !!}
                    <div class="modal-body">
                        <p>Scegli il nuovo nome della categoria.</p>
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
            $.get( "{{ url('admin/categories/details') }}/" + $(this).data('id'))
                .done(function(data){
                    $('#category_edit_form').prop('action', '{{ url('admin/categories/edit') }}/' + data.id);
                    $('#new_name').val(data.name);
                    $('#editModal').modal('toggle');
                })
                .error(function(){
                    alert('La categoria selezionata non esiste o non è più disponibile.');
                    window.location.href = '{{ url('admin/categories') }}';
                });
        });

        $('#editModal').on('shown.bs.modal', function(){
            $('#new_name').focus();
        });

        $('.delete_button').click(function(){
            if(confirm('Sicuro di voler cancellare questa categoria?')){
                window.location.href = '{{ url('admin/categories/delete') }}/' + $(this).data('id');
            }
        });

    });
</script>
@endsection
