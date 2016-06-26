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

                    <span class='st_sharethis_large' displayText='ShareThis'></span>
                    <span class='st_facebook_large' displayText='Facebook'></span>
                    <span class='st_twitter_large' displayText='Tweet'></span>
                    <span class='st_linkedin_large' displayText='LinkedIn'></span>

                    <hr>

                    <div id='discourse-comments'></div>

                    <script type="text/javascript">
                        DiscourseEmbed = {
                            discourseUrl: 'http://discourse-test.laravel-italia.it/',
                            discourseEmbedUrl: '{{ url('articoli/' . $article->slug) }}'
                        };

                        (function() {
                            var d = document.createElement('script'); d.type = 'text/javascript'; d.async = true;
                            d.src = DiscourseEmbed.discourseUrl + 'javascripts/embed.js';
                            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(d);
                        })();
                    </script>
                </article>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">var switchTo5x=true;</script>
    <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
    <script type="text/javascript">stLight.options({publisher: "f4be743d-c9b3-4324-b932-5d9fb791f092", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>

    <script src="{{ url('js/highlight.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            hljs.initHighlightingOnLoad();
        });
    </script>
@endsection
