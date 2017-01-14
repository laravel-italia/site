@extends('front.master.layout')

@section('head')
    <title>Errore! :: Laravel-Italia.it</title>
@endsection

@section('contents')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <article class="not-found">
                    <h2 class="w_light pt40">Mmmh... qualcosa non va.</h2>
                    <h2 class="pt60 pb50"><b>:\</b></h2>
                    <h6 class="subtitle">A quanto pare qualcosa è andato storto durante la tua richiesta. Prova di nuovo tra un po'!</h6>
                </article>
            </div>
        </div>
    </div>
@endsection
