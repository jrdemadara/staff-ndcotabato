@extends('../layouts/' . $layout)

@section('subhead')
    <title>Student Log - Notre Dame of Cotabato</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex flex-col items-center sm:flex-row">
        <h2 class="mr-auto text-lg font-medium">Student Log</h2>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box mt-5 p-5">
        <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
            <form class="sm:mr-auto xl:flex" id="tabulator-html-filter-form">
                <div class="items-center sm:mr-4 sm:flex">
                    <label class="mr-2 w-12 flex-none xl:w-auto xl:flex-initial">
                        Date Range
                    </label>
                    <x-base.litepicker class="mt-2 w-full sm:w-52 sm:mt-0" id="tabulator-html-filter-date" />
                </div>
                <div class="items-center sm:mr-4 sm:flex">
                    <label class="mr-2 w-12 flex-none xl:w-auto xl:flex-initial">
                        Field
                    </label>
                    <x-base.form-select class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full" id="tabulator-html-filter-field">
                        <option value="fullname">Name</option>
                        <option value="grade">Grade</option>
                        <option value="section">Section</option>
                        <option value="address">Address</option>
                        <option value="parent">Parent</option>
                        <option value="age">Age</option>
                        <option value="gender">Gender</option>
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
                    <x-base.form-input class="mt-2 sm:mt-0 sm:w-40 2xl:w-full" id="tabulator-html-filter-value"
                        type="text" placeholder="Search..." />
                </div>
                <div class="mt-2 xl:mt-0">
                    <x-base.button class="w-full sm:w-16" id="tabulator-html-filter-go" type="button" variant="primary">
                        Go
                    </x-base.button>
                    <x-base.button class="mt-2 w-full sm:mt-0 sm:ml-1 sm:w-16" id="tabulator-html-filter-reset"
                        type="button" variant="secondary">
                        Reset
                    </x-base.button>
                </div>
            </form>
            <div class="mt-5 flex sm:mt-0">
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
            </div>
        </div>
        <div class="scrollbar-hidden overflow-x-auto">
            <div class="mt-5" id="tabulator"></div>
        </div>
    </div>
    <!-- END: HTML Table Data -->
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
        @vite('resources/js/pages/tabulator/student-log.js')
    @endpush
@endonce
