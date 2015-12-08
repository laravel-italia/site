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
                <th>Stato</th>
                <th>Operazioni</th>
            </tr>
            </thead>
            <tbody>
            @forelse($articles as $article)
                <tr>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <p style="text-align: center;">Nessun articolo presente, al momento.</p>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection