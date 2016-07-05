@extends('front.master.layout')

@section('head')
    <title>Pagina non Trovata :: Laravel-Italia.it</title>
@endsection

@section('contents')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <article class="not-found">
                    <h2 class="w_light pt40">Ops!</h2>

                    <h2 class="pt40 pb40"><b>:(</b></h2>

                    <h6 class="subtitle">Sembra proprio che la pagina da te cercata non sia stata trovata.</h6>

                    <h5 class="pb30"><i>"E ora? Che faccio?"</i></h5>

                    <ul class="pt30">
                        <li>Controlla che l'indirizzo inserito sia giusto;</li>
                        <li>Dai uno sguardo <a href="{{ url('articoli') }}">agli altri articoli</a> che abbiamo pubblicato;</li>
                        <li>Torna alla <a href="{{ url('/') }}">pagina principale</a>;</li>
                    </ul>
                </article>
            </div>
        </div>
    </div>
@endsection
