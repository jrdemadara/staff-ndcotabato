@extends('../layout/' . $layout)

@section('head')
    <title>Error 500</title>

@section('content')
    <div class="container">
        <!-- BEGIN: Error Page -->
        <div class="error-page flex flex-col lg:flex-row items-center justify-center h-screen text-center lg:text-left">
            <div class="-intro-x lg:mr-20">
                <img alt="img" class="h-48 lg:h-auto" src="{{ asset('build/assets/images/error-illustration.svg') }}">
            </div>
            <div class="text-white mt-10 lg:mt-0">
                <div class="intro-x text-8xl font-medium">500</div>
                <div class="intro-x text-xl lg:text-3xl font-medium mt-5">Oops. The server encountered an unexpected
                    condition that prevented it from fulfilling the request.</div>
                <button
                    class="intro-x btn py-3 px-4 text-white border-white dark:border-darkmode-400 dark:text-slate-200 mt-10">Back
                    to Home</button>
            </div>
        </div>
        <!-- END: Error Page -->
    </div>
@endsection
