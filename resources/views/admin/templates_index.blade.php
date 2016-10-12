@extends('admin.master.layout')

@section('title') Elenco Template @endsection

@section('content')
    <p>Di seguito, i template attualmente presenti nel sistema.</p>

    <hr>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Operazioni</th>
            </tr>
            </thead>
            <tbody>
            @forelse($templates as $template)
                <tr>
                    <td>{{ $template->id }}</td>
                    <td>{{ $template->name }}</td>
                    <td>
                        <a href="{{ url('admin/templates/edit/' . $template->id) }}" class="btn btn-sm btn-info"><span class="fa fa-pencil"></span> Modifica</a>
                        <button type="button" class="btn btn-sm btn-danger delete_button" data-id="{{ $template->id }}"><span class="fa fa-remove"></span> Cancella</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        Nessun template presente.
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
            if(confirm('Sicuro di voler cancellare questo template?')){
                window.location.href = "{{ url('admin/templates/delete') }}/" + $(this).data('id');
            }
        });
    });
</script>
@endsection
