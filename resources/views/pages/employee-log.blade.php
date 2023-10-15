@extends('../layouts/' . $layout)

@section('subhead')
    <title>Employee Log - Notre Dame of Cotabato</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex flex-col items-center sm:flex-row">
        <h2 class="mr-auto text-lg font-medium">Employee Log</h2>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box mt-5 p-5">
        <div class="flex flex-col sm:flex-row sm:items-end xl:items-end mt-10">
            <form action="{{ route('employee-log') }}" method="POST" class="sm:mr-auto xl:flex">
                @csrf
                <div class="items-center sm:mr-4 sm:flex">
                    <label class="mr-2 w-12 flex-none xl:w-auto xl:flex-initial">
                        Employee
                    </label>
                    <x-base.tom-select class="mt-2 w-full sm:w-80 sm:mt-0" id="employee" name="employee">
                        @if (@isset($selectedEmployee))
                            <option selected value="{{ $selectedEmployee[0]->teaserial }}">
                                {{ $selectedEmployee[0]->fullname }}
                            </option>
                        @else
                            <option selected disabled hidden>Select Employee</option>
                        @endif
                        @if (@isset($employees))
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->teaserial }}">{{ $employee->fullname }}</option>
                            @endforeach
                        @endif
                    </x-base.tom-select>
                </div>
                <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                    <label class="mr-2 w-12 flex-none xl:w-auto xl:flex-initial">
                        Date Range
                    </label>
                    <x-base.litepicker class="mt-2 w-full sm:w-52 sm:mt-0" id="daterange" name="daterange" />
                </div>
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
                        <h2 class="mr-auto text-base font-medium text-green-700">
                            GATE: ENTRANCE
                        </h2>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        @if (isset($entranceData) && !empty($entranceData))
                            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                                <x-base.table.thead>
                                    <x-base.table.tr>
                                        <x-base.table.th class="whitespace-nowrap border-b-0">
                                            <i data-lucide="hash" class="w-4 h-4 mr-2 text-primary"></i>
                                        </x-base.table.th>
                                        <x-base.table.th class="whitespace-nowrap border-b-0">
                                            ID NUMBER
                                        </x-base.table.th>
                                        <x-base.table.th class="whitespace-nowrap border-b-0">
                                            DEPARTMENT
                                        </x-base.table.th>
                                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                                            LOG DATE
                                        </x-base.table.th>
                                    </x-base.table.tr>
                                </x-base.table.thead>
                                <x-base.table.tbody>
                                    @foreach ($entranceData as $index => $item)
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
                                                class="border-b-0 bg-white !py-3.5 shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                                <div class="flex items-center">
                                                    <div class="flex mt-0.5 font-medium">
                                                        {{ $item->{'LRN NO.'} }}
                                                    </div>
                                                </div>
                                            </x-base.table.td>
                                            <x-base.table.td
                                                class="border-b-0 bg-white capitalize shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                                {{ $item->{'GRADE LEVEL'} }}
                                            </x-base.table.td>

                                            <x-base.table.td
                                                class="relative w-56 border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400">
                                                <div class="flex items-start">
                                                    <div class="ml-4">
                                                        <div class="flex  font-medium">
                                                            <i data-lucide="calendar"
                                                                class="w-4 h-4 mr-2 text-blue-600"></i>
                                                            {{ $item->{'LOGTIME'} }}
                                                        </div>
                                                        <div class="flex  mt-0.5 text-xs">
                                                            <i data-lucide="clock" class="w-4 h-4 mr-2 text-green-600"></i>
                                                            {{ $item->{'LOGDATE'} }}
                                                        </div>
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
                <div class="p-5 z-0">
                    <div class="flex flex-col items-center border-b border-slate-200/60 p-5 sm:flex-row">
                        <h2 class="mr-auto text-base font-medium text-red-700">
                            GATE: EXIT
                        </h2>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        @if (isset($exitData) && !empty($exitData))
                            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                                <x-base.table.thead>
                                    <x-base.table.tr>
                                        <x-base.table.th class="whitespace-nowrap border-b-0">
                                            <i data-lucide="hash" class="w-4 h-4 mr-2 text-primary"></i>
                                        </x-base.table.th>
                                        <x-base.table.th class="whitespace-nowrap border-b-0">
                                            ID NUMBER
                                        </x-base.table.th>
                                        <x-base.table.th class="whitespace-nowrap border-b-0">
                                            DEPARTMENT
                                        </x-base.table.th>
                                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                                            LOG DATE
                                        </x-base.table.th>
                                    </x-base.table.tr>
                                </x-base.table.thead>
                                <x-base.table.tbody>
                                    @foreach ($exitData as $index => $item)
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
                                                class="border-b-0 bg-white !py-3.5 shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                                <div class="flex items-center">
                                                    <div class="flex mt-0.5 font-medium">
                                                        {{ $item->{'LRN NO.'} }}
                                                    </div>
                                                </div>
                                            </x-base.table.td>
                                            <x-base.table.td
                                                class="border-b-0 bg-white capitalize shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                                {{ $item->{'GRADE LEVEL'} }}
                                            </x-base.table.td>

                                            <x-base.table.td
                                                class="relative w-56 border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400">
                                                <div class="flex items-start">
                                                    <div class="ml-4">
                                                        <div class="flex  font-medium">
                                                            <i data-lucide="calendar"
                                                                class="w-4 h-4 mr-2 text-blue-600"></i>
                                                            {{ $item->{'LOGTIME'} }}
                                                        </div>
                                                        <div class="flex  mt-0.5 text-xs">
                                                            <i data-lucide="clock" class="w-4 h-4 mr-2 text-green-600"></i>
                                                            {{ $item->{'LOGDATE'} }}
                                                        </div>
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
