@extends('front.layout.master')

@section('head')
    <title>Articoli :: Laravel-Italia.it</title>
    <meta name=”description” content="Tutti gli articoli dedicati a Laravel." />

    <meta property="og:title" content="Articoli :: Laravel-Italia.it" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url('articoli') }}" />
    <meta property="og:description" content="Alla scoperta di tecniche, package e tutorial dedicati a Laravel." />
    <meta property="og:image" content="{{ url('images/fb_post_image.png') }}" />

    <meta name="twitter:card" value="summary" />
@endsection

@section('contents')
    <section class="fw_block latest_articles lightgreybg pt90">
        <h3>Articoli</h3>
        <h6 class="text-center subtitle pb70">
            @if(Request::has('categoria'))
            <a href="{{ url('articoli') }}">Tutte le Categorie</a> /
            @else
            <b>Tutte le Categorie</b> /
            @endif

            {!!
                $categories->map(function($category) {
                    if(Request::has('categoria')) {
                        if(Request::get('categoria') === $category->slug) {
                            return '<b>' . $category->name . '</b>';
                        }
                    }

                    return '<a href="'.url('articoli?categoria=' . $category->slug).'">' . $category->name . '</a>';
                })->implode(' / ')
            !!}
        </h6>
        <div class="container articles">
            <div class="row">
                @forelse($articles as $index => $article)
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
            </div>

            <div class="row">
                <div class="col-md-12 pagination-container">
                    {!! $articles->appends(['categoria'])->render() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
