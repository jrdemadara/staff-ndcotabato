(function () {
    "use strict";
    // Tabulator
    if ($("#tabulator").length) {
        let date = $("#tabulator-html-filter-date").val();
        // Format Date
        const [startDateStr, endDateStr] = date.split("-");
        const startDate = new Date(startDateStr);
        const endDate = new Date(endDateStr);

        startDate.setMinutes(
            startDate.getMinutes() - startDate.getTimezoneOffset()
        );
        endDate.setMinutes(endDate.getMinutes() - endDate.getTimezoneOffset());

        const formatedStartDate = startDate.toISOString().split("T")[0];
        const formatedEndDate = endDate.toISOString().split("T")[0];
        // On click submit date button
        $("#tabulator-html-filter-submit-date").on("click", function (event) {
            // Setup Tabulator
            const tabulator = new Tabulator("#tabulator", {
                ajaxURL: "https://staff.ndcotabato.info/employee-log-tabulator",
                ajaxParams: {
                    key1: formatedStartDate,
                    key2: formatedEndDate,
                },
                ajaxConfig: {
                    method: "GET",
                    mode: "cors",
                    credentials: "same-origin",
                    headers: {
                        Accept: "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-type": "application/json; charset=utf-8",
                        "Access-Control-Allow-Origin":
                            "https://staff.ndcotabato.info",
                    },
                },
                sortMode: "remote",
                groupBy: "logtype",
                groupValues: [["ENTRANCE", "EXIT"]],
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
                        title: "DEPARTMENT",
                        minWidth: 200,
                        field: "department",
                        responsive: 1,
                        hozAlign: "start",
                        headerHozAlign: "start",
                        vertAlign: "middle",
                        print: true,
                        download: false,
                    },
                    {
                        title: "LOG DATE",
                        minWidth: 200,
                        field: "logdate",
                        responsive: 1,
                        hozAlign: "start",
                        headerHozAlign: "start",
                        vertAlign: "middle",
                        print: true,
                        download: false,
                        formatter(cell) {
                            const response = cell.getData();
                            return `<div>
                        <div class="font-medium whitespace-nowrap">${response.logtime}</div>
                        <div class="text-xs text-slate-500 whitespace-nowrap">${response.logdate}</div>
                    </div>`;
                        },
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
                        title: "DEPARTMENT",
                        field: "department",
                        visible: false,
                        print: false,
                        download: true,
                    },
                    {
                        title: "LOG TIME",
                        field: "logtime",
                        visible: false,
                        print: false,
                        download: true,
                    },
                    {
                        title: "LOG DATE",
                        field: "logdate",
                        visible: false,
                        print: false,
                        download: true,
                    },
                    {
                        title: "LOG TYPE",
                        field: "logtype",
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
                tabulator.download("csv", "student_log.csv");
            });

            $("#tabulator-export-xlsx").on("click", function (event) {
                tabulator.download("xlsx", "student_log.xlsx", {
                    sheetName: "student_log",
                });
            });

            // Print
            $("#tabulator-print").on("click", function (event) {
                tabulator.print();
            });
        });
    }
})();
