@extends('front.master.layout')

@section('head')
    <title>Aggiungiti alla Mappa - Laravel-Italia.it</title>
    <meta name="description" content="La Community Italiana di Laravel." />

    <meta property="og:title" content="Laravel-Italia.it" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:description" content="La Community Italiana Ufficiale di Laravel." />
    <meta property="og:image" content="{{ url('images/fb_post_image.png') }}" />

    <meta name="twitter:card" value="summary" />
@endsection

@section('contents')
    <div class="fw_block">
        <div class="container pb0 pt0">
            <div class="row">
                <div class="col-md-12 pt20">
                    <h4>Aggiunta alla Mappa</h4>
                    <p class="pt20">Grande, è fatta! Hai confermato l'inserimento di <b>"{{ $mapEntry->name }}"</b>! Da questo momento <b>sei visibile dalla sezione "Mappa"</b> del sito.</p>
                    <p>Benvenuto nella famiglia e grazie per esserne parte, è bello averti con noi!</p>

                    <h3 class="pt30">:)</h3>

                    <p class="pt40" style="text-align: center;"><a href="{{ url('mappa') }}">Vai alla Mappa</a></p>
                    <p style="text-align: center;"><a href="{{ url('/') }}">Torna alla Pagina Principale</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
