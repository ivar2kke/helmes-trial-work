@php
    $name = empty($currentUserData) ? old('name') : $currentUserData['name'];
    $sectors = empty($currentUserData) ? old('sectors') : $currentUserData['sectors'];
    $agree_to_terms = empty($currentUserData) ? old('agree') : $currentUserData['agree_to_terms'];
    $action = session('user_id') !== null ? '/update/'.session('user_id') : '/store';
    $button_text = session('user_id') !== null ? 'Update' : 'Save';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <title>Helmes Trial Work</title>
    </head>
    <body class="antialiased">
        <p>Please enter your name and pick the Sectors you are currently involved in.</p>
        @if($errors->any())
        <div class="errors-alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session()->has('successMessage'))
        <div class="success-alert">
            <ul>
                <li>{{session()->get('successMessage')}}</li>
            </ul>
        </div>
        @endif

        <br>
        <br>
        <form method="POST" action="{{$action}}"> 
            @if(session('user_id') !== null)
                @method('PUT')
            @endif
            @csrf <!-- {{ csrf_field() }} -->
            <label for="name">Name:</label> 
            <input type="text" id="name" name="name" value="{{ $name }}">
            <br>
            <br>
            <label for="sectors">Sectors:</label> 
            <select multiple size="5" name="sectors[]" id="sectors">

                @foreach($sectorData as $id => $data)

                    @php($selected = '')
                    @if(!empty($sectors) && in_array($id, $sectors))
                        @php($selected = ' selected')
                    @endif

                    <option value="{{$id}}"{{$selected}}>{!!str_repeat('&nbsp;&nbsp;', $data['indentLevel'])!!}{{$data['name']}}</option>
                @endforeach

            </select>

            <br>
            <br>

            @php($agree = '')
            @if($agree_to_terms == 'on' || $agree_to_terms == 1)
                @php($agree = ' checked')
            @endif

            <input type="checkbox" id="agree" name="agree_to_terms"{{$agree}}><label for="agree">Agree to terms</label>

            <br>
            <br>
            <input type="submit" value="{{$button_text}}">
        </form>
        <br>

        @if(session('user_id') !== null)
        <form method="post" action="/terminate">
            @csrf <!-- {{ csrf_field() }} -->
            <button>Terminate session</button>
        </form>
        @endif

    </body>
</html>
