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
                    <p class="pt20">Far parte della mappa di Laravel-Italia.it è semplicissimo. Tutto quello che devi fare, infatti, è <b>compilare il questionario che vedi qui di seguito</b>. A quel punto dovrai soltanto <b>confermare via mail l'inserimento</b>.</p>

                    @if(Session::has('error_message'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>{{ Session::get('error_message') }}</strong>
                        </div>
                    @endif

                    @if(isset($errors) && count($errors) > 0)
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>{{ $errors->first() }}</strong>
                        </div>
                    @endif

                    <form action="{{ url('mappa/aggiungi') }}" method="POST">
                        {{ csrf_field() }}

                        <h5>Informazioni Generali</h5>
                        <p>Iniziamo dalle cose più importanti. Compila questi quattro campi, sono obbligatori!</p>
                        <div class="row pt20">
                            <div class="col-md-6">
                                <p><b>1) Ti iscrivi come sviluppatore o come agenzia/azienda?</b></p>
                                <p>
                                    <select class="form-control" name="type" id="type">
                                        <option value="developer">Sviluppatore</option>
                                        <option value="company">Agenzia/Azienda</option>
                                    </select>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><b>2) Scegli adesso il nome con cui comparirai:</b></p>
                                <p>
                                    <input type="text" class="form-control" name="name" placeholder="Scegli il nome..." required />
                                </p>
                            </div>
                        </div>

                        <div class="row pt20">
                            <div class="col-md-12">
                                <p><b>3) Spiega un po' chi sei, cosa fai, o cosa fa la tua azienda. Hai 255 caratteri!</b></p>
                                <p>
                                    <textarea class="form-control" name="description" id="description" rows="5" required></textarea>
                                    <i><span id="char_count">255</span> Caratteri Rimanenti</i>
                                </p>
                            </div>
                        </div>

                        <div class="row pt20">
                            <div class="col-md-12">
                                <p><b>4) Dove ti trovi? Inserisci il tuo indirizzo, oppure anche solo la città, in modo tale da poter essere aggiunto alla mappa!</b></p>
                                <p>
                                    <input type="text" class="form-control" id="location" placeholder="Indirizzo..." required />
                                </p>

                                <input type="hidden" name="latitude" id="latitude" value="" />
                                <input type="hidden" name="longitude" id="longitude" value="" />
                                <input type="hidden" name="region" id="region" value="" />
                                <input type="hidden" name="city" id="city" value="" />
                            </div>
                        </div>

                        <hr>

                        <h5>Come Raggiungerti?</h5>
                        <p>Adesso facci sapere come raggiungerti: non è obbligatorio riempire questi campi, ma magari il tuo prossimo contatto di lavoro è dietro l'angolo!</p>

                        <div class="row pt20">
                            <div class="col-md-3">
                                <p><b>Sito Web:</b></p>
                                <p>
                                    <input class="form-control" type="text" name="website_url" placeholder="http://...">
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p><b>GitHub</b></p>
                                <p>
                                    <input class="form-control" type="text" name="github_url" placeholder="http://...">
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p><b>Facebook</b></p>
                                <p>
                                    <input class="form-control" type="text" name="facebook_url" placeholder="http://...">
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p><b>Twitter</b></p>
                                <p>
                                    <input class="form-control" type="text" name="twitter_url" placeholder="http://...">
                                </p>
                            </div>
                        </div>

                        <div class="row pt30 pb30">
                            <div class="col-md-12">
                                <h5>Pronti? Via!</h5>
                                <p>Ricontrolla e verifica che sia tutto ok. Dopodichè clicca su "Aggiungiti alla Mappa!" per inviare la richiesta.</p>
                                <p>
                                    <button type="submit" class="btn btn-danger btn-signup">
                                        <span class="glyphicon glyphicon-flash"></span>
                                        Aggiungiti alla Mappa!
                                        <span class="glyphicon glyphicon-flash"></span>
                                    </button>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
    </style>
@endsection

@section('scripts')
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA6zvKJv8iAr8hNCSs0HA78cAKxmU42330&libraries=places"></script>
    <script src="{{ url('js/jquery.geocomplete.min.js') }}"></script>

    <script>
        $(document).ready(function(){
            $("#location").geocomplete().bind("geocode:result", function(event, result){
                $('#latitude').val(result.geometry.location.lat());
                $('#longitude').val(result.geometry.location.lng());
                $('#region').val(getRegionName(result));
                $('#city').val(getCityName(result));
            });

            $('#description').keyup(function(){
                $('#char_count').text(255 - $('#description').val().length);
            });
        });

        function getCityName(result)
        {
            return getAddressComponentValue('administrative_area_level_3', result);
        }

        function getRegionName(result)
        {
            return getAddressComponentValue('administrative_area_level_1', result);
        }

        function getAddressComponentValue(name, result)
        {
            var item;
            for(var c in result.address_components) {
                item = result.address_components[c];

                if(item.types.indexOf(name) !== -1) {
                    return item.long_name;
                }
            }
        }
    </script>
@endsection
