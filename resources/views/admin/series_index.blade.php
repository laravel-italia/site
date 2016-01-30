@extends('admin.master.layout')

@section('title') Elenco Serie @endsection

@section('content')
    <p>Di seguito, le serie attualmente presenti sul sito.</p>

    <hr>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Titolo</th>
                <th>Articoli Associati</th>
                <th>Stato Pubblicazione</th>
                <th>Stato Completamento</th>
                <th>Operazioni</th>
            </tr>
            </thead>
            <tbody>
            @forelse($series as $currentSeries)
                <tr>
                    <td>{{ $currentSeries->id }}</td>
                    <td>{{ $currentSeries->title }}</td>
                    <td>{{ count($currentSeries->articles) }}</td>
                    <td>@if($currentSeries->is_published) Pubblicata @else Non Pubblicata @endif</td>
                    <td>@if($currentSeries->is_completed) Completata @else Non Completata @endif</td>
                    <td>
                        @if($currentSeries->is_published)
                            <button data-id="{{ $currentSeries->id }}" class="btn btn-sm btn-warning unpublish_button"><span class="fa fa-eye-slash"></span> Nascondi</button>
                        @else
                            <button data-id="{{ $currentSeries->id }}" class="btn btn-sm btn-success publish_button"><span class="fa fa-check"></span> Pubblica</button>
                        @endif

                            @if($currentSeries->is_completed)
                                <button data-id="{{ $currentSeries->id }}" class="btn btn-sm btn-warning incomplete_button"><span class="fa fa-thumbs-down"></span> Non Completata</button>
                            @else
                                <button data-id="{{ $currentSeries->id }}" class="btn btn-sm btn-success complete_button"><span class="fa fa-thumbs-up"></span> Completata</button>
                            @endif

                        <a href="{{ url('admin/series/edit/' . $currentSeries->id) }}" class="btn btn-sm btn-info"><span class="fa fa-pencil"></span> Modifica</a>
                        <button type="button" class="btn btn-sm btn-danger delete_button" data-id="{{ $currentSeries->id }}"><span class="fa fa-remove"></span> Cancella</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        Nessuna serie presente, al momento.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('.delete_button').click(function(){
            if(confirm('Sicuro di voler cancellare questa serie? Saranno rimossi anche gli articoli ad essa associati.')){
                window.location.href = "{{ url('admin/series/delete') }}/" + $(this).data('id');
            }
        });

        $('.publish_button').click(function(){
            if(confirm('Sicuro di voler mandare questa serie in pubblicazione?')){
                window.location.href = "{{ url('admin/series/publish') }}/" + $(this).data('id');
            }
        });

        $('.unpublish_button').click(function(){
            if(confirm('Sicuro di voler rimuovere questa serie dalla pubblicazione?')){
                window.location.href = "{{ url('admin/series/unpublish') }}/" + $(this).data('id');
            }
        });

        $('.complete_button').click(function(){
            if(confirm('Sicuro di contrassegnare questa serie come completa?')){
                window.location.href = "{{ url('admin/series/complete') }}/" + $(this).data('id');
            }
        });

        $('.incomplete_button').click(function(){
            if(confirm('Sicuro di contrassegnare questa serie come incompleta?')){
                window.location.href = "{{ url('admin/series/incomplete') }}/" + $(this).data('id');
            }
        });
    });
</script>
@endsection
