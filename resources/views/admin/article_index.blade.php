@extends('admin.master.layout')

@section('title') Elenco Articoli @endsection

@section('content')
    <p>Di seguito, gli articoli attualmente presenti sul sito.</p>

    <hr>

    @if(count($unpublishedArticles) > 0 && Auth::user()->isAdministrator())
        <h3>Coda di Revisione</h3>

        <p>Ci sono degli articoli da controllare!</p>

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
                @foreach($unpublishedArticles as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->user->name }}</td>
                        <td>@if($article->isPartOfSeries()) {{ $article->series->title }} @else Nessuna @endif</td>
                        <td>{{ $article->categories()->get()->pluck('name')->implode(', ') }}</td>
                        <td>@if($article->isPublished()) Pubblicato ({{ date('d/m/Y, H:i', strtotime($article->published_at)) }}) @else Non Pubblicato @endif</td>
                        <td>
                            <button data-id="{{ $article->id }}" class="btn btn-sm btn-success publish_button"><span class="fa fa-check"></span> Pubblica</button>
                            <a href="{{ url('admin/articles/edit/' . $article->id) }}" class="btn btn-sm btn-info"><span class="fa fa-pencil"></span> Modifica</a>
                            <button type="button" class="btn btn-sm btn-danger delete_button" data-id="{{ $article->id }}"><span class="fa fa-remove"></span> Cancella</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <h3>Articoli Pubblicati</h3>

    {!! $publishedArticles->render() !!}

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
            @forelse($publishedArticles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->user->name }}</td>
                    <td>@if($article->isPartOfSeries()) {{ $article->series->title }} @else Nessuna @endif</td>
                    <td>{{ $article->categories()->get()->pluck('name')->implode(', ') }}</td>
                    <td>@if($article->isPublished()) Pubblicato ({{ date('d/m/Y, H:i', strtotime($article->published_at)) }}) @else Non Pubblicato @endif</td>
                    <td>
                        @if(Auth::user()->isAdministrator())
                            @if($article->isPublished())
                                <button data-id="{{ $article->id }}" class="btn btn-sm btn-warning unpublish_button"><span class="fa fa-eye-slash"></span> Nascondi</button>
                            @else
                                <button data-id="{{ $article->id }}" class="btn btn-sm btn-success publish_button"><span class="fa fa-check"></span> Pubblica</button>
                            @endif
                        @endif

                        @if(Auth::user()->isAdministrator() || Auth::user()->isAuthorOf($article))
                            <a href="{{ url('admin/articles/edit/' . $article->id) }}" class="btn btn-sm btn-info"><span class="fa fa-pencil"></span> Modifica</a>
                        @endif

                        @if(Auth::user()->isAdministrator())
                            <button type="button" class="btn btn-sm btn-danger delete_button" data-id="{{ $article->id }}"><span class="fa fa-remove"></span> Cancella</button>
                        @endif
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

    {!! $publishedArticles->render() !!}

    <div class="modal fade" id="publishModal" tabindex="-1" role="dialog" aria-labelledby="publishModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="publishModalLabel">Pubblica Articolo</h4>
                </div>
                <form id="article_publish_form" action="" method="post">
                    {!! csrf_field() !!}
                    <div class="modal-body">
                        <p>Scegli la data e l'ora di pubblicazione dell'articolo.</p>
                        <p><input type="text" class="form-control" name="published_at" id="published_at" placeholder="gg/mm/aaaa oo:mm" /></p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Conferma Pubblicazione</button>
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

        $('.publish_button').click(function(){
            $('#article_publish_form').prop('action', '{{ url('admin/articles/publish') }}/' + $(this).data('id'));
            $('#published_at').val(getCurrentDateTime());
            $('#publishModal').modal('toggle');
        });

        $('.unpublish_button').click(function(){
            if(confirm('Sicuro di voler rimuovere questo articolo dalla pubblicazione?')){
                window.location.href = "{{ url('admin/articles/unpublish') }}/" + $(this).data('id');
            }
        });

        $('.delete_button').click(function(){
            if(confirm('Sicuro di voler cancellare questo articolo?')){
                window.location.href = "{{ url('admin/articles/delete') }}/" + $(this).data('id');
            }
        });

        function getCurrentDateTime()
        {
            var now = new Date();

            minutes = now.getMinutes();
            if(minutes < 10)
                minutes = '0' + minutes;

            return now.getDate() + '/' + (now.getMonth() + 1) + '/' + now.getFullYear() + ' ' + now.getHours() + ':' + minutes;
        }
    });
</script>
@endsection
