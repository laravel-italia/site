@extends('front.master.layout')

@section('head')
    <title>Laravel-Italia.it</title>
    <meta name="description" content="La Community Italiana di Laravel." />

    <meta property="og:title" content="Laravel-Italia.it" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:description" content="La Community Italiana Ufficiale di Laravel." />
    <meta property="og:image" content="{{ url('images/fb_post_image.png') }}" />

    <meta name="twitter:card" value="summary" />
@endsection

@section('contents')
    <div class="fw_block pt90">
        <div class="container pb0 pt0">
            <div class="row">
                <div class="col-md-12">
                    <section class="jumbotron">
                        <h1 class="text-center">Il Framework per gli Artigiani del Web</h1>
                        <h5 class="text-center">Laravel ti permette di creare applicazioni fantastiche in poco tempo.</h5>

                        <div class="jumbut">
                            <a class="btn btn-primary" href="{{ url('articoli/la-prima-applicazione-con-laravel-52-task-list') }}" role="button">Vuoi saperne di più? Inizia subito!</a>
                            <a class="btn btn-primary" href="{{ env('FORUM_URL') }}" target="_blank" role="button">Serve una mano? Accedi al Forum</a>
                            <a class="btn btn-primary" href="{{ url('mappa') }}">Scopri chi usa Laravel!</a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- Blocco Ultimi Articoli -->
    <section class="fw_block latest_articles lightgreybg">
        <h3 class="pt90 pb50">Ultimi Articoli</h3>
        <div class="container">
            <div class="row">
            @forelse($latestArticles as $index => $article)
                @if($index % 4 === 0)
                </div>
                <div class="row">
                @endif

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <article class="archive">
                        @if($article->isPartOfSeries())
                            <a href="{{ url('articoli/' . $article->series->slug . '/' . $article->slug) }}" class="article-link">
                        @else
                            <a href="{{ url('articoli/' . $article->slug) }}" class="article-link">
                        @endif
                            <div class="status">{{ date('d/m/Y', strtotime($article->published_at)) }}</div>
                            <h6>{{ $article->title }}</h6>
                            <span><em>di <strong>{{ $article->user->name }}</strong></em></span>
                            <div class="description-block">
                                @if($article->isPartOfSeries())
                                    <p><b>Serie: {{ $article->series->title }}</b></p>
                                @endif
                                <p>{{ $article->digest }}</p>
                            </div>
                        </a>
                    </article>
                </div>
                @empty
                    <div class="col-md-12">
                        <p>Sembra non ci siano articoli sul sito, per ora...</p>
                    </div>
                @endforelse

                <div class="clearfix"></div>
                <div class="col-md-12">
                <h5 class="text-center"><a href="{{ url('articoli') }}">Visualizza tutti gli articoli →</a></h5></div>
            </div>
        </div>
    </section>
    <!-- Blocco Ultimi Articoli -->
@endsection
