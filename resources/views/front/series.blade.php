@extends('front.master.layout')

@section('head')
    <title>Serie :: Laravel-Italia.it</title>
    <meta name="description" content="Tutte le serie di articoli dedicate a Laravel." />

    <meta property="og:title" content="Serie :: Laravel-Italia.it" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url('serie') }}" />
    <meta property="og:description" content="Tutte le serie di articoli dedicate a Laravel." />
    <meta property="og:image" content="{{ url('images/fb_post_image.png') }}" />
@endsection

@section('contents')
    <section class="fw_block latest_articles lightgreybg pt90">
        <h3>Serie</h3>
        <h6 class="text-center subtitle pb70">Approfondimenti e applicazioni complete con Laravel</h6>
        <div class="container">
            <div class="row">
                @forelse($series as $index => $singleSeries)

                    @if($index % 4 === 0)
                    </div>
                    <div class="row">
                    @endif

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <article class="archive">
                            <a href="{{ url('serie/' . $singleSeries->slug) }}" class="series-link">
                                <div class="status">
                                @if($singleSeries->is_completed)
                                    Completata!
                                @else
                                    In Corso...
                                @endif
                                </div>

                                <h6>{{ $singleSeries->title }}</h6>
                                <span><em>Totale Articoli: <strong>{{ count($singleSeries->articles) }}</strong></em></span>
                                <div class="description-block">
                                    <p>{!! Markdown::convertToHtml($singleSeries->description) !!}</p>
                                </div>
                            </a>
                        </article>
                    </div>

                @empty
                <div class="col-md-12">
                    <p>Sembra non ci siano serie sul sito, per ora...</p>
                </div>
                @endforelse

                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection
