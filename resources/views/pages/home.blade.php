@extends('../layouts/' . $layout)

@section('subhead')
    <title>Employee Log - Notre Dame of Cotabato</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex flex-col items-center sm:flex-row">
        <h2 class="mr-auto text-lg font-medium">Home</h2>
    </div>
    <div class="flex flex-col justify-center items-center mt-4">
        <img src="{{ Vite::asset('resources/images/logo.png') }}" class="w-56 saturate-50" alt="logo">
        <h2 class="text-4xl font-black mt-2 text-primary">Notre Dame of Cotabato</h2>
        <h2 class="text-lg tracking-widest text-primary">Ad Jesum per Mariam</h2>


    </div>
@endsection
