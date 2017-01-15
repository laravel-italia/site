@extends('front.master.layout')

@section('head')
    <title>Mappa - Laravel-Italia.it</title>
    <meta name="description" content="La Community Italiana di Laravel." />

    <meta property="og:title" content="Laravel-Italia.it" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:description" content="La Community Italiana Ufficiale di Laravel." />
    <meta property="og:image" content="{{ url('images/fb_post_image.png') }}" />

    <meta name="twitter:card" value="summary" />

    <link rel="stylesheet" href="{{ url('flat-icons.css') }}">
@endsection

@section('contents')
    <div class="fw_block">
        <div class="container pb0 pt0">
            <div class="row">
                <div class="col-md-3 pt20">
                    <h4>Mappa</h4>

                    <p class="pt20">Ehi! Sei sulla <b>mappa di Laravel-Italia</b>!</p>
                    <p>L'abbiamo realizzata per permettere, a tutti, di "trovarci" più facilmente. Hai bisogno di uno sviluppatore o un'agenzia nella tua zona? Qui sei il benvenuto.</p>
                    <p><b>Cosa aspetti ad aggiungere te o la tua azienda? Ed è gratis!</b></p>
                    <p></p>

                    <hr>

                    <p>
                        <a href="{{ url('mappa/aggiungi') }}" class="btn btn-danger btn-signup">Aggiungiti Ora! <span class="glyphicon glyphicon-flash"></span></a>
                    </p>
                </div>

                <div class="col-md-9">
                    <iframe
                            class="map"
                            frameborder="0" style="border:0"
                            src="https://www.google.com/maps/embed/v1/place?q=Italy&key=AIzaSyA6cXuOpvM91gJZ-1ckW_l6hTdSIUrUQSA"
                            allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Blocco Ultimi Articoli -->
    <section class="fw_block latest_articles lightgreybg">
        <div class="container">
            <div class="row pb30">
                <div class="col-md-5">
                    <select name="" id="" class="form-control select-filter">
                        <option value="">Tutte le Regioni</option>
                        <option value="">Abruzzo</option>
                        <option value="">Abruzzo</option>
                        <option value="">Abruzzo</option>
                        <option value="">Abruzzo</option>
                        <option value="">Abruzzo</option>
                        <option value="">Abruzzo</option>
                        <option value="">Abruzzo</option>
                        <option value="">Abruzzo</option>
                        <option value="">Abruzzo</option>
                        <option value="">Abruzzo</option>
                        <option value="">Abruzzo</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <select name="" id="" class="form-control select-filter">
                        <option value="">Sviluppatori e Agenzie / Aziende</option>
                        <option value="">Solo Sviluppatori</option>
                        <option value="">Solo Agenzie / Aziende</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger btn-filter">Filtra <i style="font-size:14px;" class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
            <div class="row">
            @foreach($mapEntries as $index => $mapEntry)
                @if($index % 4 === 0)
                </div>
                <div class="row">
                @endif

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="#" class="article-link">
                        <article class="archive">
                            <div class="status">
                                @if($mapEntry->type == 'company')
                                    Azienda / Agenzia
                                @else
                                    Sviluppatore
                                @endif
                            </div>
                            <h6>{{ $mapEntry->name }}</h6>
                            <span><em>a <strong>{{ $mapEntry->city }}</strong></em></span>
                            <div class="description-block">
                                <p>{{ $mapEntry->description }}</p>

                                <div class="left">
                                    <p>
                                        @if($mapEntry->website_url != '')
                                            <a href="{{ $mapEntry->website_url }}" target="_blank">Sito Web</a>
                                        @endif
                                    </p>
                                </div>

                                <div class="right">
                                    <p>
                                        @if($mapEntry->github_url != '')
                                            <a href="{{ $mapEntry->github_url }}" target="_blank"><img src="{{ url('images/Github.svg') }}" class="social-icon" alt="" /></a>
                                        @endif

                                        @if($mapEntry->facebook_url != '')
                                            <a href="{{ $mapEntry->facebook_url }}" target="_blank"><img src="{{ url('images/Facebook.svg') }}" class="social-icon" alt="" /></a>
                                        @endif

                                        @if($mapEntry->twitter_url != '')
                                            <a href="{{ $mapEntry->twitter_url }}" target="_blank"><img src="{{ url('images/Twitter.svg') }}" class="social-icon" alt="" /></a>
                                        @endif
                                    </p>
                                </div>

                                <div class="clearfix"></div>
                            </div>
                        </article>
                    </a>
                </div>
            @endforeach
            </div>

            <div class="row">
                <div class="col-md-12 pagination-container">
                    {!! $mapEntries->render() !!}
                </div>
            </div>
        </div>
    </section>
    <!-- Blocco Ultimi Articoli -->

    <style>
        .map {
            width: 100%;
            height: 450px;
        }

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

        .btn-filter {
            width: 100%;
            color: #FFFFFF;
            padding: 0px 42px !important;
            background-color: #f4645f;
            font-size: 16px;
            height: 30px;
            margin-top: 7px;
        }

        .btn-filter:hover, .btn-filter:active {
            color: #FFFFFF;
            background-color: #f4645f;
        }

        select, select option, input, textarea {
            color: #444444 !important;
        }

        .social-icon {
            margin: 0px 4px;
            width: 30px;
        }

        .left {
            float: left;
        }

        .right {
            float: right;
        }
    </style>
@endsection
