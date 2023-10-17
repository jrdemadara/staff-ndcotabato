@extends('../layouts/' . $layout)

@section('subhead')
    <title>Student Profile - Notre Dame of Cotabato</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex flex-col items-center sm:flex-row">
        <h2 class="mr-auto text-lg font-medium">Student Profile</h2>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box mt-5 p-5">
        <div class="flex flex-col sm:flex-row sm:items-end xl:items-end mt-10">
            <form action="{{ route('student-profile.details') }}" method="POST" class="sm:mr-auto xl:flex">
                @csrf
                @if (isset($search))
                    <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                        <x-base.form-input id="horizontal-form-1" type="text" id="search" name="search"
                            value="{{ $search }}" placeholder="Search Keyword" />
                    </div>
                @else
                    <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                        <x-base.form-input id="horizontal-form-1" type="text" id="search" name="search"
                            placeholder="Search Keyword" />
                    </div>
                @endif

                <div class="mt-5 xl:mt-0">
                    <x-base.button type="submit" class="mr-2 w-full" variant="primary">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Search" />
                        Search...
                    </x-base.button>
                </div>
            </form>
        </div>
        <div class="scrollbar-hidden overflow-x-auto">
            <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                <div class="p-5 z-0">
                    <div class="flex flex-col items-center border-b border-slate-200/60 p-5 sm:flex-row">
                        <h2 class="mr-auto text-base font-medium">
                            STUDENT PROFILES
                        </h2>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        @if (isset($students) && !empty($students))
                            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                                <x-base.table.thead>
                                    <x-base.table.tr>
                                        <x-base.table.th class="whitespace-nowrap border-b-0">
                                            <i data-lucide="hash" class="w-4 h-4 mr-2"></i>
                                        </x-base.table.th>
                                        <x-base.table.th class="whitespace-nowrap border-b-0">
                                            LRN NUMBER
                                        </x-base.table.th>
                                        <x-base.table.th class="whitespace-nowrap border-b-0">
                                            FULLNAME
                                        </x-base.table.th>
                                        <x-base.table.th class="whitespace-nowrap border-b-0">
                                            BIRTHDATE
                                        </x-base.table.th>
                                        <x-base.table.th class="whitespace-nowrap border-b-0">
                                            AGE
                                        </x-base.table.th>
                                        <x-base.table.th class="whitespace-nowrap border-b-0">
                                            GENDER
                                        </x-base.table.th>
                                        <x-base.table.th class="whitespace-nowrap border-b-0">
                                            GRADE
                                        </x-base.table.th>
                                        <x-base.table.th class="whitespace-nowrap border-b-0">
                                            SECTION
                                        </x-base.table.th>
                                        <x-base.table.th class="whitespace-nowrap border-b-0">
                                            ADDRESS
                                        </x-base.table.th>
                                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                                            PARENTS/GUARDIANS
                                        </x-base.table.th>
                                    </x-base.table.tr>
                                </x-base.table.thead>
                                <x-base.table.tbody>
                                    @foreach ($students as $index => $item)
                                        <x-base.table.tr class="intro-x">
                                            <x-base.table.td
                                                class="border-b-0 bg-white !py-3.5 shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                                <div class="flex items-center">
                                                    <div class="flex mt-0.5 font-medium">
                                                        {{ $index + 1 }}
                                                    </div>
                                                </div>
                                            </x-base.table.td>
                                            <x-base.table.td
                                                class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                                <a class="flex items-center underline decoration-dotted" href="#">
                                                    {{ $item->{'lrn'} }}
                                                </a>
                                            </x-base.table.td>
                                            <x-base.table.td
                                                class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                                {{ $item->{'fullname'} }}
                                            </x-base.table.td>
                                            <x-base.table.td
                                                class="border-b-0 bg-white capitalize shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                                {{ $item->{'birthdate'} }}
                                            </x-base.table.td>

                                            <x-base.table.td
                                                class="border-b-0 bg-white capitalize shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                                {{ $item->{'age'} }}
                                            </x-base.table.td>

                                            <x-base.table.td
                                                class="border-b-0 bg-white capitalize shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                                {{ $item->{'gender'} }}
                                            </x-base.table.td>

                                            <x-base.table.td
                                                class="border-b-0 bg-white capitalize shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                                {{ $item->{'grade'} }}
                                            </x-base.table.td>

                                            <x-base.table.td
                                                class="border-b-0 bg-white capitalize shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                                {{ $item->{'section'} }}
                                            </x-base.table.td>

                                            <x-base.table.td
                                                class="border-b-0 bg-white capitalize shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                                {{ $item->{'address'} }}
                                            </x-base.table.td>
                                            <x-base.table.td
                                                class="relative w-56 border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400">
                                                <div class="flex flex-col items-start">
                                                    <a class="whitespace-nowrap font-medium" href="">
                                                        {{ $item->{'parent'} }}
                                                    </a>
                                                    <div class="mt-0.5 whitespace-nowrap text-xs text-slate-500">
                                                        {{ $item->{'contact'} }}
                                                    </div>
                                                </div>
                                            </x-base.table.td>
                                        </x-base.table.tr>
                                    @endforeach
                                </x-base.table.tbody>
                            </x-base.table>
                        @else
                            <p class="p-5 font-medium text-md text-warning">No entrance data available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
