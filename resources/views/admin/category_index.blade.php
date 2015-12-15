@extends('admin.master.layout')

@section('title') Categorie @endsection

@section('content')
    <p>Gestisci da qui le categorie presenti sul sito.</p>

    <hr>

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
                        <a href="#" class="btn btn-sm btn-info"><span class="fa fa-pencil"></span> Modifica</a>
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
@endsection

@section('scripts')
<script>
    $(document).ready(function(){

        $('.delete_button').click(function(){
            if(confirm('Sicuro di voler cancellare questa categoria?')){
                window.location.href = '{{ url('admin/categories/delete') }}/' + $(this).data('id');
            }
        });

    });
</script>
@endsection