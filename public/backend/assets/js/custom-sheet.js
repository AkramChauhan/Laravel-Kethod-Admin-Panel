const daysOfWeek = [
    "sunday",
    "monday",
    "tuesday",
    "wednesday",
    "thursday",
    "friday",
    "saturday",
];
const shortDays = ["sun", "mon", "tue", "wed", "thu", "fri", "sat"];
const months = [
    "january",
    "february",
    "march",
    "april",
    "may",
    "june",
    "july",
    "august",
    "september",
    "october",
    "november",
    "december",
];
const shortMonths = [
    "jan",
    "feb",
    "mar",
    "apr",
    "may",
    "jun",
    "jul",
    "aug",
    "sep",
    "oct",
    "nov",
    "dec",
];

function load_spreadsheet(container, data, columns, cells) {
    const hot = new Handsontable(container, {
        licenseKey: "non-commercial-and-evaluation",
        data: data,
        autoFill: true,
        rowHeaders: true,
        // formulas: {
        //   engine: HyperFormula
        // },
        manualColumnResize: true,
        contextMenu: true,
        filters: true,
        colHeaders: true,
        dropdownMenu: true,
        colWidths: 100,
        afterInit: function () {
            this.selectCell(0, 0); // Select the first cell (0,0)
        },

        afterGetColHeader: function (col, TH) {
            if (col >= Object.keys(data[0]).length) {
                // Check if it's not the first column
                // Find and remove the dropdown menu button if it exists
                const button = TH.querySelector(".changeType");
                if (button) {
                    button.style.display = "none"; // Hide or remove the dropdown button
                }
            }
        },
        // colHeaders: ['Date', 'Name', 'InFlow', 'OutFlow', 'Category', '', '', '', '', '', ''], // Set column headers
        columns: columns,
        cells: cells,
        minRows: 100,
        customBorders: true,
        renderAllRows: true,
        rowHeights: 30,
        height: "78vh",
        width: "100%",
    });

    hot.addHook(
        "beforeAutofill",
        function (selectionData, sourceRange, targetRange, direction) {
            let sequenceArray,
                isConsistent = true,
                increment,
                reverse = false;
            let inputData = selectionData[0][0].toLowerCase();
            const rowCount = targetRange.to.row - targetRange.from.row + 1;
            const colCount = targetRange.to.col - targetRange.from.col + 1;

            if (
                daysOfWeek.includes(inputData) ||
                shortDays.includes(inputData)
            ) {
                sequenceArray = daysOfWeek.includes(inputData)
                    ? daysOfWeek
                    : shortDays;
            } else if (
                months.includes(inputData) ||
                shortMonths.includes(inputData)
            ) {
                sequenceArray = months.includes(inputData)
                    ? months
                    : shortMonths;
            } else if (!isNaN(inputData)) {
                // Numeric sequence logic
                if (selectionData.length > 1 && !isNaN(selectionData[1][0])) {
                    increment =
                        Number(selectionData[1][0]) -
                        Number(selectionData[0][0]);
                    for (let i = 1; i < selectionData.length - 1; i++) {
                        if (
                            Number(selectionData[i + 1][0]) -
                                Number(selectionData[i][0]) !==
                            increment
                        ) {
                            isConsistent = false;
                            break;
                        }
                    }
                } else {
                    increment = 1; // Default increment for single value
                }
            } else {
                // For any other input, just repeat the value
                repeatSelection(selectionData, rowCount, colCount, targetRange);
                return false; // Prevent default behavior
            }

            if (sequenceArray) {
                if (selectionData.length > 1) {
                    let firstValueIndex = sequenceArray.indexOf(
                        selectionData[0][0].toLowerCase()
                    );
                    let secondValueIndex = sequenceArray.indexOf(
                        selectionData[1][0].toLowerCase()
                    );
                    reverse = firstValueIndex > secondValueIndex;
                    for (let i = 1; i < selectionData.length; i++) {
                        if (
                            sequenceArray[
                                (firstValueIndex + i * (reverse ? -1 : 1)) %
                                    sequenceArray.length
                            ] !== selectionData[i][0].toLowerCase()
                        ) {
                            isConsistent = false;
                            break;
                        }
                    }
                }
                increment = isConsistent ? 1 : 0;
                increment *= reverse ? -1 : 1;
            } else if (!isNaN(inputData)) {
                if (selectionData.length > 1 && !isNaN(selectionData[1][0])) {
                    increment =
                        Number(selectionData[1][0]) -
                        Number(selectionData[0][0]);
                    for (let i = 1; i < selectionData.length - 1; i++) {
                        if (
                            Number(selectionData[i + 1][0]) -
                                Number(selectionData[i][0]) !==
                            increment
                        ) {
                            isConsistent = false;
                            break;
                        }
                    }
                } else {
                    increment = 1; // Default increment for single value
                }
            }

            // Common autofill logic
            if (isConsistent) {
                let startValue = sequenceArray
                    ? sequenceArray.indexOf(
                          selectionData[
                              selectionData.length - 1
                          ][0].toLowerCase()
                      )
                    : Number(selectionData[selectionData.length - 1][0]);
                startValue += increment;
                fillRange(
                    startValue,
                    increment,
                    rowCount,
                    colCount,
                    targetRange,
                    sequenceArray,
                    selectionData
                );
            } else {
                repeatSelection(selectionData, rowCount, colCount, targetRange);
            }

            return false; // Prevent the default autofill behavior
        }
    );

    hot.addHook("afterSelectionEnd", (r, c) => updateCellDisplay(r, c));

    function toA1Notation(row, col) {
        const colLabel = Handsontable.helper.spreadsheetColumnLabel(col); // Get column label (A, B, C, ...)
        return colLabel + (row + 1); // Add 1 because rows are zero-indexed
    }

    function updateCellDisplay(row, col) {
        const cellData = hot.getDataAtCell(row, col);
        const cellAddress = toA1Notation(row, col);
        $(".currentCellValue").val(cellData);
        $(".currentCellAddress").html(cellAddress);
    }

    function fillRange(
        startValue,
        increment,
        rowCount,
        colCount,
        targetRange,
        sequenceArray,
        selectionData
    ) {
        // Prepare a batch update array
        let updates = [];

        for (let i = 0; i < rowCount; i++) {
            for (let j = 0; j < colCount; j++) {
                let value;
                if (sequenceArray) {
                    const sequenceIndex =
                        (startValue + i * colCount + j) % sequenceArray.length;
                    value = sequenceArray[sequenceIndex];

                    // Capitalization logic (optimized)
                    const originalValue =
                        selectionData[i % selectionData.length][
                            j % selectionData[0].length
                        ];
                    const isUpperCase =
                        originalValue[0] === originalValue[0].toUpperCase();
                    value = isUpperCase
                        ? value.charAt(0).toUpperCase() + value.slice(1)
                        : value;
                } else {
                    value = startValue + increment * (i * colCount + j);
                }

                // Add to batch updates
                updates.push([
                    targetRange.from.row + i,
                    targetRange.from.col + j,
                    value,
                ]);
            }
        }

        // Apply all updates in a single call
        hot.setDataAtCell(updates);
    }

    function repeatSelection(selectionData, rowCount, colCount, targetRange) {
        for (let i = 0; i < rowCount; i++) {
            for (let j = 0; j < colCount; j++) {
                const value =
                    selectionData[i % selectionData.length][
                        j % selectionData[0].length
                    ];
                hot.setDataAtCell(
                    targetRange.from.row + i,
                    targetRange.from.col + j,
                    value
                );
            }
        }
    }

    function toggleCellStyle(className) {
        const selected = hot.getSelectedRange();
        if (selected) {
            for (
                let row = Math.max(selected[0].from.row, 0);
                row <= selected[0].to.row;
                row++
            ) {
                for (
                    let col = Math.max(selected[0].from.col, 0);
                    col <= selected[0].to.col;
                    col++
                ) {
                    // Skip invalid indexes
                    if (row < 0 || col < 0) {
                        continue;
                    }

                    let cellMeta = hot.getCellMeta(row, col);
                    cellMeta.className = cellMeta.className || "";

                    // Toggle the specified class
                    if (cellMeta.className.includes(className)) {
                        cellMeta.className = cellMeta.className
                            .replace(className, "")
                            .trim();
                    } else {
                        cellMeta.className += ` ${className}`;
                    }
                }
            }
            hot.render();
        }
    }

    updateCellDisplay(0, 0);

    $(".spreadsheet-toolbar-button").on("click", function () {
        let action = $(this).attr("data-action");
        let action_class = $(this).attr("data-action-class");
        toggleCellStyle(action_class);
    });
}

document.addEventListener(
    "mousedown",
    function (event) {
        const handsontableContainer = document.getElementById(
            "handsontable-container"
        );
        if (!handsontableContainer.contains(event.target)) {
            // Click is outside Handsontable
            event.stopImmediatePropagation();
        }
    },
    true
);
