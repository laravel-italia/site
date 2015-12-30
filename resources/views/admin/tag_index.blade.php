@extends('admin.master.layout')

@section('title') Tag @endsection

@section('content')
    <p>Gestisci da qui i tag del forum.</p>

    <hr>

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
                        <button type="button" class="btn btn-sm btn-info edit_button"><span class="fa fa-pencil"></span> Modifica</button>
                        <button type="button" class="btn btn-sm btn-danger delete_button"><span class="fa fa-remove"></span> Cancella</button>
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
@endsection