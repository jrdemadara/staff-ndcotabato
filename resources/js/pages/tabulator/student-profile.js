(function () {
    "use strict";
    // Tabulator
    if ($("#tabulator").length) {
        // Setup Tabulator
        const tabulator = new Tabulator("#tabulator", {
            ajaxURL: "http://127.0.0.1:8000/student-profile-tabulator",
            ajaxConfig: {
                method: "GET", //set request type to Position
                mode: "cors", //set request mode to cors
                credentials: "same-origin",
                headers: {
                    Accept: "application/json", //tell the server we need JSON back
                    "X-Requested-With": "XMLHttpRequest", //fix to help some frameworks respond correctly to request
                    "Content-type": "application/json; charset=utf-8", //set the character encoding of the request
                    "Access-Control-Allow-Origin":
                        "http://http://127.0.0.1:8000", //the URL origin of the site making the request
                },
            },
            //progressiveLoad: "load",
            //progressiveLoadDelay: 200,
            //paginationMode: "remote",
            //filterMode: "remote",
            sortMode: "remote",
            printAsHtml: true,
            printStyled: true,
            pagination: true,
            paginationSize: 60,
            paginationSizeSelector: [10, 20, 30, 40, 100],
            layout: "fitColumns",
            responsiveLayout: "collapse",
            placeholder: "No matching records found",
            columns: [
                {
                    title: "",
                    formatter: "responsiveCollapse",
                    width: 40,
                    minWidth: 30,
                    hozAlign: "center",
                    resizable: false,
                    headerSort: false,
                },

                // For HTML table
                {
                    title: "#",
                    width: 80,
                    minWidth: 40,
                    responsive: 1,
                    field: "row",
                    vertAlign: "middle",
                    print: true,
                    download: false,
                    formatter: "rownum",
                },
                {
                    title: "FULLNAME",
                    minWidth: 200,
                    responsive: 1,
                    field: "fullname",
                    vertAlign: "middle",
                    print: true,
                    download: false,
                    formatter(cell) {
                        const response = cell.getData();
                        return `<div>
                        <div class="font-medium whitespace-nowrap">${response.fullname}</div>
                        <div class="text-xs text-slate-500 whitespace-nowrap">${response.lrn}</div>
                    </div>`;
                    },
                },
                {
                    title: "BIRTHDAY",
                    width: 50,
                    minWidth: 200,
                    field: "birthdate",
                    hozAlign: "center",
                    headerHozAlign: "center",
                    vertAlign: "middle",
                    print: true,
                    download: false,
                },
                {
                    title: "AGE",
                    width: 100,
                    minWidth: 100,
                    field: "age",
                    hozAlign: "center",
                    headerHozAlign: "center",
                    vertAlign: "middle",
                    print: true,
                    download: false,
                },
                {
                    title: "GENDER",
                    minWidth: 200,
                    field: "gender",
                    responsive: 1,
                    hozAlign: "start",
                    headerHozAlign: "start",
                    vertAlign: "middle",
                    print: true,
                    download: false,
                },
                {
                    title: "GRADE/SECTION",
                    minWidth: 200,
                    field: "grade",
                    responsive: 1,
                    hozAlign: "start",
                    headerHozAlign: "start",
                    vertAlign: "middle",
                    print: true,
                    download: false,
                    formatter(cell) {
                        const response = cell.getData();
                        return `<div>
                        <div class="font-medium whitespace-nowrap">${response.grade}</div>
                        <div class="text-xs text-slate-500 whitespace-nowrap">${response.section}</div>
                    </div>`;
                    },
                },
                {
                    title: "PARENT",
                    minWidth: 200,
                    field: "parent",
                    responsive: 1,
                    hozAlign: "start",
                    headerHozAlign: "start",
                    vertAlign: "middle",
                    print: true,
                    download: false,
                    formatter(cell) {
                        const response = cell.getData();
                        return `<div>
                        <div class="font-medium whitespace-nowrap">${response.parent}</div>
                        <div class="text-xs text-slate-500 whitespace-nowrap">${response.contact}</div>
                    </div>`;
                    },
                },
                {
                    title: "ADDRESS",
                    minWidth: 200,
                    field: "address",
                    responsive: 1,
                    hozAlign: "start",
                    headerHozAlign: "start",
                    vertAlign: "middle",
                    print: true,
                    download: false,
                },

                // For download format
                {
                    title: "LRN",
                    field: "lrn",
                    visible: false,
                    print: false,
                    download: true,
                },
                {
                    title: "FULLNAME",
                    field: "fullname",
                    visible: false,
                    print: false,
                    download: true,
                },

                {
                    title: "BIRTHDATE",
                    field: "birthdate",
                    visible: false,
                    print: false,
                    download: true,
                },
                {
                    title: "AGE",
                    field: "age",
                    visible: false,
                    print: false,
                    download: true,
                },
                {
                    title: "GENDER",
                    field: "gender",
                    visible: false,
                    print: false,
                    download: true,
                },
                {
                    title: "GRADE",
                    field: "grade",
                    visible: false,
                    print: false,
                    download: true,
                },
                {
                    title: "SECTION",
                    field: "section",
                    visible: false,
                    print: false,
                    download: true,
                },
                {
                    title: "PARENT",
                    field: "parent",
                    visible: false,
                    print: false,
                    download: true,
                },
                {
                    title: "CONTACT",
                    field: "contact",
                    visible: false,
                    print: false,
                    download: true,
                },
                {
                    title: "ADDRESS",
                    field: "address",
                    visible: false,
                    print: false,
                    download: true,
                },
            ],
        });

        tabulator.on("renderComplete", () => {
            createIcons({
                icons,
                attrs: {
                    "stroke-width": 1.5,
                },
                nameAttr: "data-lucide",
            });
        });

        // Redraw table onresize
        window.addEventListener("resize", () => {
            tabulator.redraw();
            createIcons({
                icons,
                "stroke-width": 1.5,
                nameAttr: "data-lucide",
            });
        });

        // Filter function
        function filterHTMLForm() {
            let field = $("#tabulator-html-filter-field").val();
            let type = $("#tabulator-html-filter-type").val();
            let value = $("#tabulator-html-filter-value").val();
            tabulator.setFilter(field, type, value);
        }

        // On submit filter form
        $("#tabulator-html-filter-form")[0].addEventListener(
            "keypress",
            function (event) {
                let keycode = event.keyCode ? event.keyCode : event.which;
                if (keycode == "13") {
                    event.preventDefault();
                    filterHTMLForm();
                }
            }
        );

        // On click go button
        $("#tabulator-html-filter-go").on("click", function (event) {
            filterHTMLForm();
        });

        // On reset filter form
        $("#tabulator-html-filter-reset").on("click", function (event) {
            $("#tabulator-html-filter-field").val("fullname");
            $("#tabulator-html-filter-type").val("like");
            $("#tabulator-html-filter-value").val("");
            filterHTMLForm();
        });

        // Export
        $("#tabulator-export-csv").on("click", function (event) {
            tabulator.download("csv", "student_profile.csv");
        });

        $("#tabulator-export-xlsx").on("click", function (event) {
            tabulator.download("xlsx", "student_profile.xlsx", {
                sheetName: "student_profile",
            });
        });

        // Print
        $("#tabulator-print").on("click", function (event) {
            tabulator.print();
        });
    }
})();
