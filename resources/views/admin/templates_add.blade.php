@extends('admin.master.layout')

@section('title') Aggiungi Template @endsection

@section('content')
    <p>Aggiungi da qui un nuovo template.</p>

    <hr>

    <form action="" method="post" id="template_form">
        {!! csrf_field() !!}

        <div class="row">
            <div class="col-md-12">
                <input type="text" class="form-control" placeholder="Nome..." name="name" value="{{ old('name', '') }}" autofocus />
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="body" id="body" value="{{ old('body', '') }}" />
                <textarea id="editor" cols="30" rows="10"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p><button class="btn btn-success form-control" id="save_button">Salva Template</button></p>
            </div>
        </div>
    </form>
@endsection

@section('stylesheets')
<link rel="stylesheet" href="{{ url('assets') }}/simplemde/simplemde.min.css" />

<style>
    .CodeMirror {
        height: 450px;
    }
</style>
@endsection

@section('scripts')
<script src="{{ url('assets') }}/simplemde/simplemde.min.js"></script>

<script>
    $(document).ready(function(){
        var simplemde = new SimpleMDE({ element: $("#editor")[0] });
        simplemde.value($('#body').val());

        $('#save_button').click(function(){
            $('#body').val(simplemde.value());
        });
    });
</script>
@endsection
