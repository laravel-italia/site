@extends('front.layout.master')

@section('head')
    <title>{{ $article->title }} :: Laravel-Italia.it</title>
    <meta name=”description” content="{{ $article->metadescription }}" />

    <meta property="og:title" content="{{ $article->title }} :: Laravel-Italia.it" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url('articoli/' . $article->slug) }}" />
    <meta property="og:description" content="{{ $article->metadescription }}" />
    <meta property="og:image" content="{{ url('images/fb_post_image.png') }}" />

    <meta name="twitter:card" value="summary" />
@endsection

@section('contents')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <article class="single_article">

                    <h2 class="w_light">{{ $article->title }}</h2>
                    <h6 class="subtitle">{{ $article->digest }}</h6>

                    <div class="author">
                        <div class="auth_cont pt30 pb30">
                            <figure>
                                <a href="#"><img src="{{ url('profile-pictures/' . $article->user->id . '.jpg') }}" alt="francesco" /></a>
                            </figure>
                            <div>
                                <a href="#" rel="author">{{ $article->user->name }}</a>
                                <br/><span class="date">{{ date('d/m/Y', strtotime($article->published_at)) }} </span> in <em> {!! $article->categories->map(function($category) { return '<a href="' . url('categorie/' . $category->slug) . '">'.$category->name.'</a>'; })->implode(', ') !!}</em>
                            </div>
                        </div>
                    </div>

                    <hr>

                    @if($article->series)
                        <div class="panel-group series pt20" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" class="collapse-link" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <span class="glyphicon glyphicon-plus"></span> Questo articolo fa parte di... <b>"{{ $article->series->title }}"</b>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        {!! Markdown::convertToHtml($article->series->description) !!}

                                        <ul>
                                            @foreach($article->series->articles()->get() as $siblingArticle)
                                                @if($article->slug === $siblingArticle->slug)
                                                    <li><b>{{ $siblingArticle->title }}</b></li>
                                                @else
                                                    <li><a href="{{ url('articoli/' . $siblingArticle->slug) }}">{{ $siblingArticle->title }}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {!! Markdown::convertToHtml($article->body) !!}

                    <hr>

                    <p>DISCOURSE INTEGRATION HERE</p>
                </article>
            </div>
        </div>
    </div>
@endsection
