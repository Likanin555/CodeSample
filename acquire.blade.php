@extends('layouts.app')

@section('content')

@php
    use App\Http\Controllers\DragonsController;
@endphp

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-15">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <form action="/acquire/choose" method="POST">
                                    {{csrf_field()}}
                                @php $arrayDragons = array_sort( DragonsController::getConf(), 'order' ); @endphp

                                @foreach ( $arrayDragons as $species => $option)
                                <tr>
                                    <td>
                                        <div class="text-center">
                                            <!-- Wyświetlenie tłumaczenia rasy na podstawie wybranego języka przez użytkownika -->
                                            <h1 class="mb-1 fs-2">{{ __('messages.' . $species . ".display"); }}</h1>
                                            <img src="{{ asset('img/species/'.$species.'.jpg') }}" class="img-fluid" style="max-width: 400px;" alt="...">
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <!-- Opis wybranej bestii na podstawie wybranego języka przez użytkownika -->
                                        <p>{{ __('messages.' . $species . ".description"); }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <button type="submit" class="btn btn-dark SpeciesChoice" name="SpeciesChoice" value={{$species}}>Przygarnij {{ __('messages.' . $species . ".display"); }}</button>
                                    </td>
                                </tr>
                                @endforeach
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
