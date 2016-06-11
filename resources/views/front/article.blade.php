@extends('front.layout.master')

@section('head')
    <title>{{ $article->title }} :: Laravel-Italia.it</title>
    <meta name=”description” content="{{ $article->metadescription }}" />
@endsection

@section('contents')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <article class="single_article">
                    <div class="author">
                        <div class="auth_cont pt30 pb30">
                            <figure>
                                <a href="#"><img src="{{ url('images/author.jpg') }}" alt="francesco" /></a>
                            </figure>
                            <div>
                                <a href="#" rel="author">{{ $article->user->name }}</a>
                                <br/><span class="date">{{ date('d/m/Y', strtotime($article->published_at)) }} </span> in <em> {!! $article->categories->map(function($category) { return '<a href="' . url('categorie/' . $category->slug) . '">'.$category->name.'</a>'; })->implode(', ') !!}</em>
                            </div>
                        </div>
                    </div>

                    <h2 class="w_light">{{ $article->title }}</h2>
                    <h6 class="subtitle">{{ $article->digest }}</h6>

                    {!! Markdown::convertToHtml($article->body) !!}

                    <hr>

                    <p>DISCOURSE INTEGRATION HERE</p>
                </article>
            </div>
        </div>
    </div>
@endsection
