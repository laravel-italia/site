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
                        <a href="#" class="btn btn-sm btn-success">Pubblica</a>
                        <a href="#" class="btn btn-sm btn-warning">Nascondi</a>
                        <a href="#" class="btn btn-sm btn-info">Modifica</a>
                        <a href="#" class="btn btn-sm btn-danger">Cancella</a>
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