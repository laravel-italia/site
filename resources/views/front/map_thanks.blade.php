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

                    <p class="pt20">Perfetto, andata! A questo punto <b>dovresti ricevere un messaggio di posta con un link</b> per la conferma.</p>

                    <p><b>Una volta effettuata la conferma via mail sarai già visibile sul sito!</b> Forza, che aspetti?</p>

                    <h3 class="pt30">:)</h3>

                    <p class="pt40" style="text-align: center;"><a href="{{ url('mappa') }}">Vai alla Mappa</a></p>
                    <p style="text-align: center;"><a href="{{ url('/') }}">Torna alla Pagina Principale</a></p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-signup {
            color: #FFFFFF;
            height: 62px !important;
            width: 100%;
            background-color: #f4645f;
        }

        .btn-signup:hover {
            color: #FFFFFF;
            background-color: #f4645f;
        }
    </style>
@endsection
