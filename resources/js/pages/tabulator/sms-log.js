(function () {
    "use strict";
    // Tabulator
    if ($("#tabulator").length) {
        let date = $("#tabulator-html-filter-date").val();
        // Format Date
        const [startDateStr, endDateStr] = date.split("-");
        const startDate = new Date(startDateStr);
        const endDate = new Date(endDateStr);

        const formatedStartDate = startDate.toISOString().split("T")[0];
        const formatedEndDate = endDate.toISOString().split("T")[0];
        // On click submit date button
        $("#tabulator-html-filter-submit-date").on("click", function (event) {
            // Setup Tabulator
            const tabulator = new Tabulator("#tabulator", {
                ajaxURL: "https://staff.ndcotabato.info/sms-log-tabulator",
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
                        title: "MESSAGE",
                        minWidth: 300,
                        responsive: 1,
                        field: "message",
                        vertAlign: "middle",
                        print: false,
                        download: false,
                        formatter(cell) {
                            const response = cell.getData();
                            return `<div>
                        <div class="flex items-center justify-center">
                            <i data-lucide="message-circle" class="w-4 h-4 mr-2 text-primary"></i>
                            ${response.message}
                        </div>
                    </div>`;
                        },
                    },
                    {
                        title: "CONTACT NUMBER",
                        width: 200,
                        minWidth: 100,
                        field: "contactno",
                        responsive: 1,
                        hozAlign: "start",
                        headerHozAlign: "start",
                        vertAlign: "middle",
                        print: false,
                        download: false,
                        formatter(cell) {
                            const response = cell.getData();
                            return `<div>
                        <div class="flex items-center justify-center">
                            <i data-lucide="smartphone" class="w-4 h-4 mr-2 text-warning"></i>
                            ${response.contactno}
                        </div>
                    </div>`;
                        },
                    },
                    {
                        title: "LOG DATE",
                        width: 200,
                        minWidth: 100,
                        field: "datecreated",
                        responsive: 1,
                        hozAlign: "start",
                        headerHozAlign: "start",
                        vertAlign: "middle",
                        print: false,
                        download: false,
                        formatter(cell) {
                            const response = cell.getData();
                            return `<div>
                        <div class="flex items-center justify-center">
                            <i data-lucide="calendar" class="w-4 h-4 mr-2 text-blue-600"></i>
                            ${response.datecreated}
                        </div>
                        <div class="flex items-center justify-center">
                            <i data-lucide="send" class="w-4 h-4 mr-2 text-green-600"></i>
                            ${response.datetimesend}
                        </div>
                    </div>`;
                        },
                    },

                    // For download format
                    {
                        title: "MESSAGE",
                        field: "message",
                        visible: false,
                        print: true,
                        download: true,
                    },
                    {
                        title: "CONTACT NUMBER",
                        field: "contactno",
                        visible: false,
                        print: true,
                        download: true,
                    },
                    {
                        title: "SMS DRAWER",
                        field: "smsdrawer",
                        visible: false,
                        print: false,
                        download: true,
                    },
                    {
                        title: "DATE CREATED",
                        field: "datecreated",
                        visible: false,
                        print: true,
                        download: true,
                    },
                    {
                        title: "DATE TIME SEND",
                        field: "datetimesend",
                        visible: false,
                        print: true,
                        download: true,
                    },
                    {
                        title: "LOG TYPE",
                        field: "logtype",
                        visible: false,
                        print: true,
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
