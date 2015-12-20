@extends('admin.master.layout')

@section('title') Aggiungi Serie @endsection

@section('content')
    <p>Aggiungi da qui la tua nuova serie.</p>

    <hr>

    <form action="" method="post" id="series_form">
        {!! csrf_field() !!}

        <div class="row">
            <div class="col-md-12">
                <input type="text" class="form-control" placeholder="Titolo..." name="title" value="{{ old('title', '') }}" autofocus />
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="description" id="description" value="{{ old('description', '') }}" />
                <textarea id="editor" cols="30" rows="10"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p><input type="text" class="form-control" placeholder="Metadescription..." name="metadescription" value="{{ old('metadescription', '') }}" /></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p><button class="btn btn-success form-control" id="save_button">Salva Serie</button></p>
            </div>
        </div>
    </form>
@endsection

@section('stylesheets')
<link rel="stylesheet" href="{{ url('assets') }}/simplemde/dist/simplemde.min.css" />
@endsection

@section('scripts')
<script src="{{ url('assets') }}/simplemde/dist/simplemde.min.js"></script>

<script>
    $(document).ready(function(){
        var simplemde = new SimpleMDE({ element: $("#editor")[0] });
        simplemde.value($('#description').val());

        $('#save_button').click(function(){
            $('#description').val(simplemde.value());
        });
    });
</script>
@endsection