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

        <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
            <form class="sm:mr-auto xl:flex" id="tabulator-html-filter-form">
                <div class="items-center sm:mr-4 mb-2 md:mb-0 sm:flex">
                    <x-base.button class="w-full sm:w-auto" data-tw-toggle="modal" data-tw-target="#datepicker-modal-preview" href="#" as="a" variant="primary">
                        Select Date Range
                    </x-base.button>
                </div>
                <div class="items-center sm:mr-4 sm:flex">
                    <label class="mr-2 w-12 flex-none xl:w-auto xl:flex-initial">
                        Field
                    </label>
                    <x-base.form-select class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full" id="tabulator-html-filter-field">
                        <option value="fullname">Fullname</option>
                        <option value="department">Department</option>
                        <option value="logdate">Log Date</option>
                        <option value="logtime">Log Time</option>
                    </x-base.form-select>
                </div>
                <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                    <label class="mr-2 w-12 flex-none xl:w-auto xl:flex-initial">
                        Type
                    </label>
                    <x-base.form-select class="mt-2 w-full sm:mt-0 sm:w-auto" id="tabulator-html-filter-type">
                        <option value="like">like</option>
                        <option value="=">=</option>
                        <option value="<">&lt;</option>
                        <option value="<=">&lt;=</option>
                        <option value=">">&gt;</option>
                        <option value=">=">&gt;=</option>
                        <option value="!=">!=</option>
                    </x-base.form-select>
                </div>
                <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                    <label class="mr-2 w-12 flex-none xl:w-auto xl:flex-initial">
                        Value
                    </label>
                    <x-base.form-input class="mt-2 sm:mt-0 sm:w-40 2xl:w-full" id="tabulator-html-filter-value" type="text" placeholder="Search..." />
                </div>
                <div class="mt-2 xl:mt-0">
                    <x-base.button class="w-full sm:w-16" id="tabulator-html-filter-go" type="button" variant="primary">
                        Go
                    </x-base.button>
                    <x-base.button class="mt-2 w-full sm:mt-0 sm:ml-1 sm:w-16" id="tabulator-html-filter-reset" type="button" variant="secondary">
                        Reset
                    </x-base.button>
                </div>
            </form>
            <div class="mt-3 flex items-center space-x-2 sm:ml-auto sm:mt-0">
                <x-base.button class="flex items-center w-36 bg-blue-200 text-slate-600 dark:text-slate-300">
                    <x-base.lucide class="mr-2 hidden h-4 w-4 sm:block" icon="Users" />
                    Employees: <span class="font-bold ml-2">50</span>
                </x-base.button>
                <x-base.button class="flex items-center w-36 bg-green-200 text-slate-600 dark:text-slate-300">
                    <x-base.lucide class="mr-2 hidden h-4 w-4 sm:block" icon="Log-in" />
                    Ins: <span class="font-bold ml-2">50</span>
                </x-base.button>
                <x-base.button class="flex items-center w-36 bg-red-200 text-slate-600 dark:text-slate-300">
                    <x-base.lucide class="mr-2 hidden h-4 w-4 sm:block" icon="Log-out" />
                    Outs: <span class="font-bold ml-2">50</span>
                </x-base.button>
            </div>
            {{-- <div class="mt-5 flex sm:mt-0">
                <x-base.button class="mr-2 w-1/2 sm:w-auto" id="tabulator-print" variant="outline-secondary">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="Printer" /> Print
                </x-base.button>
                <x-base.menu class="w-1/2 sm:w-auto">
                    <x-base.menu.button class="w-full sm:w-auto" as="x-base.button" variant="outline-secondary">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="FileText" /> Export
                        <x-base.lucide class="ml-auto h-4 w-4 sm:ml-2" icon="ChevronDown" />
                    </x-base.menu.button>
                    <x-base.menu.items class="w-40">
                        <x-base.menu.item id="tabulator-export-csv">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="FileText" /> Export CSV
                        </x-base.menu.item>
                        <x-base.menu.item id="tabulator-export-xlsx">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="FileText" /> Export
                            XLSX
                        </x-base.menu.item>
                    </x-base.menu.items>
                </x-base.menu>
            </div> --}}
        </div>

        <div class="scrollbar-hidden overflow-x-auto">
            <div class="mt-5" id="tabulator"></div>
        </div>
    </div>
    <!-- END: HTML Table Data -->
    <!-- BEGIN: Modal Content -->
    <x-base.dialog id="datepicker-modal-preview">
        <x-base.dialog.panel>
            <!-- BEGIN: Modal Header -->
            <x-base.dialog.title>
                <h2 class="mr-auto text-base font-medium">
                    Select Date Range
                </h2>
            </x-base.dialog.title>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <x-base.dialog.description class="flex">
                <x-base.litepicker class="mt-2 w-max sm:w-full sm:mt-0" id="tabulator-html-filter-date" />
            </x-base.dialog.description>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <x-base.dialog.footer class="text-right">
                <x-base.button class="mr-1 w-20" data-tw-dismiss="modal" type="button" variant="outline-secondary">
                    Cancel
                </x-base.button>
                <x-base.button class="w-20" type="button" variant="primary" id="tabulator-html-filter-submit-date">
                    Submit
                </x-base.button>
            </x-base.dialog.footer>
            <!-- END: Modal Footer -->
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Modal Content -->
@endsection

@once
    @push('vendors')
        @vite('resources/js/vendor/tabulator/index.js')
        @vite('resources/js/vendor/lucide/index.js')
        @vite('resources/js/vendor/xlsx/index.js')
    @endpush
@endonce

@once
    @push('scripts')
        @vite('resources/js/pages/tabulator/employee-log.js')
    @endpush
@endonce
