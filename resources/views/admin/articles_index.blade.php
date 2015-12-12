@extends('admin.master.layout')

@section('title') Elenco Articoli @endsection

@section('content')
    <p>Di seguito, gli articoli attualmente presenti sul sito.</p>

    <hr>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Titolo</th>
                <th>Autore</th>
                <th>Serie</th>
                <th>Categorie</th>
                <th>Stato</th>
                <th>Operazioni</th>
            </tr>
            </thead>
            <tbody>
            @forelse($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->user->name }}</td>
                    <td>@if($article->isPartOfSeries()) $article->series->title @else Nessuna @endif</td>
                    <td>{{ $article->categories()->get()->pluck('name')->implode(', ') }}</td>
                    <td>@if($article->isPublished()) Pubblicato ({{ date('d/m/Y, H:i') }}) @else Non Pubblicato @endif</td>
                    <td>
                        @if(Auth::user()->isAdministrator())
                            @if($article->isPublished())
                                <a href="#" class="btn btn-sm btn-warning"><span class="fa fa-eye-slash"></span> Nascondi</a>
                            @else
                                <a href="#" class="btn btn-sm btn-success"><span class="fa fa-check"></span> Pubblica</a>
                            @endif
                        @endif

                        @if(Auth::user()->isAdministrator() || Auth::user()->isAuthorOf($article))
                            <a href="#" class="btn btn-sm btn-info"><span class="fa fa-pencil"></span> Modifica</a>
                        @endif
                        
                        <button type="button" class="btn btn-sm btn-danger" id="delete_button" data-id="{{ $article->id }}"><span class="fa fa-times"></span> Cancella</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        Nessun articolo presente, al momento.
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
        $('#delete_button').click(function(){
            if(confirm('Sicuro di voler cancellare questo articolo?')){
                window.location.href = "{{ url('admin/articles/delete') }}/" + $(this).data('id');
            }
        });
    });
</script>
@endsection