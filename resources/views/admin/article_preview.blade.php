@extends('front.master.layout')

@section('head')
    <title>@if($article->series) {{ $article->series->title }} :: @endif {{ $article->title }}</title>
    <meta name=”description” content="{{ $article->metadescription }}" />

    <meta property="og:title" content="{{ $article->title }} :: Laravel-Italia.it" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url('articoli/' . $article->slug) }}" />
    <meta property="og:description" content="{{ $article->metadescription }}" />
    <meta property="og:image" content="{{ url('images/fb_post_image.png') }}" />

    <meta name="twitter:card" value="summary" />

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.4.0/styles/default.min.css" />
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
                                <img src="{{ url('profile-pictures/' . $article->user->id . '.jpg') }}" alt="francesco" />
                            </figure>
                            <div>
                                <b class="author-name">{{ $article->user->name }}</b>
                                <br/><span class="date">{{ date('d/m/Y', strtotime($article->published_at)) }} </span> in <em> {!! $article->categories->map(function($category) { return '<a href="' . url('articoli?categoria=' . $category->slug) . '">'.$category->name.'</a>'; })->implode(', ') !!}</em>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {!! Markdown::convertToHtml($article->body) !!}

                    <hr>
                </article>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.4.0/highlight.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            hljs.initHighlightingOnLoad();
        });
    </script>
@endsection
