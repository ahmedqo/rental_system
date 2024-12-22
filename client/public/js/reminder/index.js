TableVisualizer($query("neo-datavisualizer"), (props) => [{
    name: "vehicle",
    text: $trans("Vehicle"),
    bodyRender: (row) => row.vehicle ? ($capitalize($trans(row.vehicle.brand)) + " " + $capitalize($trans(row.vehicle.model)) + " " + row.vehicle.year + " (&#x202B;" + row.vehicle.registration_number + "&#x202C;)") : empty(),
    bodyPdfRender: function(row) {
        return this.bodyRender(row);
    },
    bodyCsvRender: function(row) {
        return this.bodyRender(row);
    },
}, {
    name: "consumable_name",
    text: $trans("Consumable name"),
    bodyRender: (row) => $capitalize($trans(row.consumable_name)),
    bodyPdfRender: function(row) {
        return this.bodyRender(row);
    },
    bodyCsvRender: function(row) {
        return this.bodyRender(row);
    },
}, {
    name: "recurrence_amount",
    text: $trans("Recurrence amount"),
    headStyle: { textAlign: "center" },
    bodyStyle: { textAlign: "center" },
    bodyRender: (row) => $money(+row.recurrence_amount, row.unit_of_measurement === "mileage" ? 2 : 0) + " " + $capitalize(row.unit_of_measurement === "mileage" ? $trans("Km") : $trans(row.unit_of_measurement)),
    headPdfStyle: function() {
        return this.headStyle
    },
    bodyPdfStyle: function() {
        return this.bodyStyle;
    },
    bodyPdfRender: function(row) { return this.bodyRender(row); },
    bodyCsvRender: function(row) { return this.bodyRender(row); },
}, {
    name: "threshold_value",
    text: $trans("Threshold value"),
    headStyle: { textAlign: "center" },
    bodyStyle: { textAlign: "center" },
    bodyRender: (row) => $money(+row.threshold_value, row.unit_of_measurement === "mileage" ? 2 : 0) + " " + $capitalize(row.unit_of_measurement === "mileage" ? $trans("Km") : $trans("hours")),
    headPdfStyle: function() {
        return this.headStyle
    },
    bodyPdfStyle: function() {
        return this.bodyStyle;
    },
    bodyPdfRender: function(row) { return this.bodyRender(row); },
    bodyCsvRender: function(row) { return this.bodyRender(row); },
}, {
    name: "view_issued_at",
    text: $trans("Next recurrence"),
    headStyle: { textAlign: "center" },
    bodyStyle: { textAlign: "center" },
    headPdfStyle: function() {
        return this.headStyle
    },
    bodyPdfStyle: function() {
        return this.bodyStyle;
    },
    bodyRender: (row) => $moment(row.view_issued_at, $core.format),
    bodyPdfRender: function(row) { return this.bodyRender(row); },
    bodyCsvRender: function(row) { return this.bodyRender(row); },
}, actionColumn(props)]);