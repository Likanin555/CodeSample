@extends('layouts.app')

@section('content')

@php
    use App\Http\Controllers\DragonsController;
    // Jeżeli użytkownik wszedł bezpośrednio w link zamiast przez formularz -> przekieruj go do strony z formularzem
    if (!isset($_POST['SpeciesChoice']) || empty($_POST['SpeciesChoice'])) {
        header("Location: {{url:'acquire'}}");
        exit;
    }

    // Pobierz z formularza informację o wybranej rasie
    $spec = $_POST['SpeciesChoice'];

    // Wylosuj element natury bazując na wybranej rasie
    $element = DragonsController::randomElement($spec);

    // Wylosuj samiec czy samica
    $gender = rand(1,2);
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-15">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-acquire">
                            <tbody>
                                <form action="/acquire/choose" method="POST" class="formChoose">
                                    {{csrf_field()}}
                                    <tr>
                                        <td class="title-acquire">
                                            <div class="fs-4">Oto Twój nowy smok gatunku <b>{{ __('messages.' . $spec . ".display"); }}</b>!</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title-acquire fs-5">
                                            Wylosowany żywioł to {{ __('messages.' . $element); }}, a płeć {{ __('messages.gender.' . $gender); }}.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title-acquire">
                                            <img src="{{asset('img/util/egg.png')}}" class="img-fluid" alt="MysteryEgg">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title-acquire">
                                            Wybierz imię dla swojego nowego smoka <input type="text" name="NameDragon" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title-acquire">

                                            <!-- Aby upewnić się że odpowiedni użytkownik jest wybrany -->
                                            <input type="hidden" name="idPlayer" value="{{Auth::id()}}" />

                                            <input type="submit" id="AcceptDragon" value="Przyjmij!">
                                        </td>
                                    </tr>
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
