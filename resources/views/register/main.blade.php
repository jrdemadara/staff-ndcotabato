@extends('../layouts/' . $layout)

@section('head')
    <title>Register - Notre Dame of Cotabato</title>
@endsection

@section('content')
    <div @class([
        'p-3 sm:px-8 relative h-screen lg:overflow-hidden bg-primary xl:bg-white dark:bg-darkmode-800 xl:dark:bg-darkmode-600',
        'before:hidden before:xl:block before:content-[\'\'] before:w-[57%] before:-mt-[28%] before:-mb-[16%] before:-ml-[13%] before:absolute before:inset-y-0 before:left-0 before:transform before:rotate-[-4.5deg] before:bg-primary/20 before:rounded-[100%] before:dark:bg-darkmode-400',
        'after:hidden after:xl:block after:content-[\'\'] after:w-[57%] after:-mt-[20%] after:-mb-[13%] after:-ml-[13%] after:absolute after:inset-y-0 after:left-0 after:transform after:rotate-[-4.5deg] after:bg-primary after:rounded-[100%] after:dark:bg-darkmode-700',
    ])>
        <div class="container relative z-10 sm:px-10">
            <div class="block grid-cols-2 gap-4 xl:grid">
                <!-- BEGIN: Register Info -->
                <div class="hidden min-h-screen flex-col xl:flex">
                    <a class="-intro-x flex items-center pt-5" href="">
                        <img class="w-16 h-16" src="{{ Vite::asset('resources/images/logo.png') }}" alt="logo" />
                        <span class="ml-3 text-lg text-white"> ND Cotabato </span>
                    </a>
                    <div class="my-auto">
                        <img class="-intro-x -mt-16 w-1/2" src="{{ Vite::asset('resources/images/illustration.svg') }}" alt="logo" />
                        <div class="-intro-x mt-10 text-4xl font-medium leading-tight text-white">
                            A few more clicks to <br />
                            sign up to your account.
                        </div>
                        <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">
                            Manage your
                            account in one place
                        </div>
                    </div>
                </div>
                <!-- END: Register Info -->
                <!-- BEGIN: Register Form -->
                <div class="my-10 flex h-screen py-5 xl:my-0 xl:h-auto xl:py-0">
                    <div class="mx-auto my-auto w-full rounded-md bg-white px-5 py-8 shadow-md dark:bg-darkmode-600 sm:w-3/4 sm:px-8 lg:w-2/4 xl:ml-20 xl:w-auto xl:bg-transparent xl:p-0 xl:shadow-none">
                        <h2 class="intro-x text-center text-2xl font-bold xl:text-left xl:text-3xl">
                            Sign Up
                        </h2>
                        <div class="intro-x mt-2 text-center text-slate-400 dark:text-slate-400 xl:hidden">
                            A few more clicks to sign in to your account. Manage all your
                            e-commerce accounts in one place
                        </div>
                        <div class="intro-x mt-8">
                            <form id="register-form">
                                <x-base.form-input class="intro-x block min-w-full px-4 py-3 xl:min-w-[350px]" id="id_number" type="text" placeholder="ID Number" />
                                <x-base.form-select class="mt-4 block min-w-full px-4 py-3 xl:min-w-[350px]" id="user_type">
                                    <option value="" selected disabled>Select User Type</option>
                                    <option>Administrator</option>
                                    <option>IT</option>
                                    <option>Teacher</option>
                                </x-base.form-select>
                                <x-base.form-select class="mt-4 block min-w-full px-4 py-3 xl:min-w-[350px]" id="section">
                                    <option value="" selected disabled>Select Section</option>
                                    <option value="none">None</option>
                                    @if ($sections && $sections->isNotEmpty())
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->secserial }}">{{ $section->secname }}</option>
                                        @endforeach
                                    @else
                                        <option disabled>No sections available</option>
                                    @endif
                                </x-base.form-select>

                                <x-base.form-input class="intro-x mt-4 block min-w-full px-4 py-3 xl:min-w-[350px]" id="password" type="text" placeholder="Password" />
                                <div class="intro-x mt-3 grid h-1 w-full grid-cols-12 gap-4">
                                    <div class="col-span-3 h-full rounded bg-success"></div>
                                    <div class="col-span-3 h-full rounded bg-success"></div>
                                    <div class="col-span-3 h-full rounded bg-success"></div>
                                    <div class="col-span-3 h-full rounded bg-slate-100 dark:bg-darkmode-800"></div>
                                </div>
                                <a class="intro-x mt-2 block text-xs text-slate-500 sm:text-sm" href="">
                                    What is a secure password?
                                </a>
                                <x-base.form-input class="intro-x mt-4 block min-w-full px-4 py-3 xl:min-w-[350px]" id="confirm_password" type="text" placeholder="Password Confirmation" />
                            </form>
                        </div>
                        <div class="intro-x mt-4 flex items-center text-xs text-slate-600 dark:text-slate-500 sm:text-sm">
                            <x-base.form-check.input class="mr-2 border" id="policy" type="checkbox" />
                            <label class="cursor-pointer select-none" for="policy">
                                I agree to the Notre Dame of Cotabato
                            </label>
                            <a class="ml-1 text-primary dark:text-slate-200" href="">
                                Privacy Policy
                            </a>

                        </div>
                        <div class="intro-x mt-5 text-center xl:mt-8 xl:text-left">
                            <x-base.button class="w-full px-4 py-3 align-top xl:mr-3 xl:w-32" id="btn-register" variant="primary">
                                Register
                            </x-base.button>
                            <a href="{{ route('login.index') }}">
                                <x-base.button class="mt-3 w-full px-4 py-3 align-top xl:mt-0 xl:w-32" variant="outline-secondary">
                                    Sign in
                                </x-base.button>
                            </a>


                        </div>
                    </div>
                </div>
                <!-- END: Register Form -->
            </div>
        </div>
    </div>

    <!-- BEGIN: Error Notification Content -->
    <x-base.notification class="flex" id="error-notification-content">
        <x-base.lucide class="text-danger" icon="x-circle" />
        <div class="ml-4 mr-4">
            <div class="font-medium">Oops...</div>
            <div class="mt-1 text-slate-500">
                Please complete all required fields.
            </div>
        </div>
    </x-base.notification>
    <!-- END: Error Notification Content -->

    <!-- BEGIN: Invalid ID Notification Content -->
    <x-base.notification class="flex" id="invalid-id-notification-content">
        <x-base.lucide class="text-danger" icon="x-circle" />
        <div class="ml-4 mr-4">
            <div class="font-medium">Oops...</div>
            <div class="mt-1 text-slate-500">
                The id number you provided is invalid.
            </div>
        </div>
    </x-base.notification>
    <!-- END: Invalid ID Notification Content -->

    <!-- BEGIN: Already Registered Notification Content -->
    <x-base.notification class="flex" id="already-registered-notification-content">
        <x-base.lucide class="text-danger" icon="x-circle" />
        <div class="ml-4 mr-4">
            <div class="font-medium">Oops...</div>
            <div class="mt-1 text-slate-500">
                The id number you provided is already registered.
            </div>
        </div>
    </x-base.notification>
    <!-- END: Already Registered Notification Content -->

    <!-- BEGIN: Already Taken Notification Content -->
    <x-base.notification class="flex" id="taken-notification-content">
        <x-base.lucide class="text-danger" icon="x-circle" />
        <div class="ml-4 mr-4">
            <div class="font-medium">Oops...</div>
            <div class="mt-1 text-slate-500">
                The section you selected is already taken.
            </div>
        </div>
    </x-base.notification>
    <!-- END: Already Registered Notification Content -->

    <!-- BEGIN: Registration Success Notification Content -->
    <x-base.notification class="flex" id="success-notification-content">
        <x-base.lucide class="text-success" icon="check-circle" />
        <div class="ml-4 mr-4">
            <div class="font-medium">Yey!</div>
            <div class="mt-1 text-slate-500">
                You can now login to your account.
            </div>
        </div>
    </x-base.notification>
    <!-- END: Registration Success Notification Content -->

    <!-- BEGIN: Error 500 Notification Content -->
    <x-base.notification class="flex" id="error-500-notification-content">
        <x-base.lucide class="text-danger" icon="x-circle" />
        <div class="ml-4 mr-4">
            <div class="font-medium">Oops...</div>
            <div class="mt-1 text-slate-500">
                Something went wrong with the server. <br>
                Please try again later.
            </div>
        </div>
    </x-base.notification>
    <!-- END: Error 500 Notification Content -->

    <!-- BEGIN: Policy Notification Content -->
    <x-base.notification class="flex" id="unchecked-notification-content">
        <x-base.lucide class="text-warning" icon="alert-circle" />
        <div class="ml-4 mr-4">
            <div class="font-medium">Oops...</div>
            <div class="mt-1 text-slate-500">
                Please agree to the Privacy Policy. <br>
            </div>
        </div>
    </x-base.notification>
    <!-- END: Policy Notification Content -->

    <!-- BEGIN: Empty Inputs Notification Content -->
    <x-base.notification class="flex" id="empty-input-notification-content">
        <x-base.lucide class="text-warning" icon="alert-circle" />
        <div class="ml-4 mr-4">
            <div class="font-medium">Oops...</div>
            <div class="mt-1 text-slate-500">
                Please complete all required fields. <br>
            </div>
        </div>
    </x-base.notification>
    <!-- END: Empty Inputs Notification Content -->

    <!-- BEGIN: Confirm Password Notification Content -->
    <x-base.notification class="flex" id="confirm-password-notification-content">
        <x-base.lucide class="text-warning" icon="alert-circle" />
        <div class="ml-4 mr-4">
            <div class="font-medium">Oops...</div>
            <div class="mt-1 text-slate-500">
                Password didn't match. <br>
            </div>
        </div>
    </x-base.notification>
    <!-- END: Confirm Password Notification Content -->
@endsection

@pushOnce('scripts')
    @vite('resources/js/pages/register/index.js')
@endPushOnce
