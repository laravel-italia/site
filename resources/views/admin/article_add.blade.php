@extends('admin.master.layout')

@section('title') Nuovo Articolo @endsection

@section('content')
    <p>Aggiungi da qui il tuo nuovo articolo.</p>

    <hr>

    <form action="" method="post" id="article_form">
        {!! csrf_field() !!}

        <div class="row">
            <div class="col-md-12">
                <input type="text" class="form-control" placeholder="Titolo..." name="title" value="{{ old('title', '') }}" />
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-8">
                <input type="hidden" name="body" id="body" value="{{ old('body', '') }}" />
                <textarea id="editor" cols="30" rows="10"></textarea>
            </div>
            <div class="col-md-4">
                <p>
                    <button id="save_button" class="btn btn-success form-control"><span class="glyphicon glyphicon-floppy-disk"></span> Salva Articolo</button>
                </p>

                <hr>

                <div class="categories-list">
                    <p><b>Categorie Associate</b></p>
                    @foreach($categories as $category)
                        <label><input type="checkbox" name="categories[]" value="{{ $category->id }}" id="category_{{ $category->id }}"> {{ $category->name }}</label><br>
                    @endforeach
                </div>

                <hr>

                <p><b>Serie Associata</b></p>

                <select name="series_id" id="series_id" class="form-control">
                    <option value="0">Nessuna</option>
                    @foreach($series as $singleSeries)
                    <option value="{{ $singleSeries->id }}">{{ $singleSeries->title }}</option>
                    @endforeach
                </select>

                <hr>

                <p><b>Carica Template</b></p>

                <select id="template_select" class="form-control">
                    <option value="0">Scegli template...</option>
                    @foreach($templates as $template)
                        <option value="{{ $template->id }}">{{ $template->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p><input type="text" class="form-control" placeholder="Estratto..." name="digest" value="{{ old('digest', '') }}" /></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p><input type="text" class="form-control" placeholder="Metadescription..." name="metadescription" value="{{ old('metadescription', '') }}" /></p>
            </div>
        </div>
    </form>
@endsection

@section('stylesheets')
<link rel="stylesheet" href="{{ url('assets') }}/simplemde/simplemde.min.css" />

<style>
    .categories-list label {
        font-weight: normal;
    }

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

        $('#series_id').val('{{ old('series_id', '0') }}');

        @foreach(old('categories', []) as $currentCategory)
        $('#category_{{ $currentCategory }}').prop('checked', true);
        @endforeach

        $('#save_button').click(function(){
            $('#body').val(simplemde.value());
        });

        $('#template_select').change(function(){
            if($(this).val() === 0) {
                return;
            }

            if(simplemde.value() !== '' && !confirm('Sicuro? C\'è già del testo qui!')) {
                $('#template_select').prop('disabled', false).val(0);
                return;
            }

            $(this).prop('disabled', 'disabled');
            $.get( "{{ url('admin/templates/find') }}/" + $(this).val(), function( data ) {
                $('#body').val(data.body);
                simplemde.value($('#body').val());
            }).fail(function(){
                alert('Errore, elemento non trovato. Ricaricare la pagina.');
            }).always(function(){
                $('#template_select').prop('disabled', false).val(0);
            });
        });
    });
</script>
@endsection
