@extends('admin.master.layout')

@section('title') Media @endsection

@section('content')

    <h3>Caricamento</h3>
    <p><i>Il file da caricare deve essere un <strong>jpg</strong> o <strong>png</strong>, di massimo <strong>2048 Kb</strong>.</i></p>
    <div class="row">
        <form action="{{ url('admin/media/upload') }}" enctype="multipart/form-data" method="post">
            {!! csrf_field() !!}
            <div class="col-md-10">
                <input type="file" class="form-control" name="media" required />
            </div>
            <div class="col-md-2">
                <button class="btn btn-success form-control"><span class="fa fa-upload"></span> Carica</button>
            </div>
        </form>
    </div>

    <hr>

    <h3>Elenco</h3>
    <p>Di seguito, i file caricati nel sistema.</p>

    {!! $media->render() !!}

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Indirizzo</th>
                <th>Caricato da</th>
                <th>Data di Caricamento</th>
                <th>Operazioni</th>
            </tr>
            </thead>
            <tbody>
            @forelse($media as $currentMedia)
                <tr>
                    <td>{{ $currentMedia->id }}</td>
                    <td>
                        <input class="form-control" type="text" value="{{ $currentMedia->url }}" readonly />
                    </td>
                    <td>{{ $currentMedia->user->name }}</td>
                    <td>{{ date('d/m/Y, H:i', strtotime($currentMedia->created_at)) }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger delete_button" data-id="{{ $currentMedia->id }}"><span class="fa fa-remove"></span> Cancella</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        Nessun media presente, al momento.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {!! $media->render() !!}
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('.delete_button').click(function(){
            if(confirm('Sicuro di voler cancellare questo media?')){
                window.location.href = "{{ url('admin/media/delete') }}/" + $(this).data('id');
            }
        });
    });
</script>
@endsection
