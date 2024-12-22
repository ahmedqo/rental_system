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
    name: "name",
    text: $trans("Name"),
    bodyRender: (row) => $capitalize(row.name),
    bodyPdfRender: function(row) {
        return this.bodyRender(row);
    },
    bodyCsvRender: function(row) {
        return this.bodyRender(row);
    },
}, {
    name: "cost",
    text: $trans("Cost"),
    headStyle: { textAlign: "center" },
    bodyStyle: { textAlign: "center" },
    bodyRender: (row) => $money(+row.cost, 2) + " " + $core.currency,
    headPdfStyle: function() {
        return this.headStyle
    },
    bodyPdfStyle: function() {
        return this.bodyStyle;
    },
    bodyPdfRender: function(row) { return this.bodyRender(row); },
    bodyCsvRender: function(row) { return this.bodyRender(row); },
}, {
    name: "details",
    text: $trans("Details"),
    headStyle: {
        maxWidth: 300,
    },
    bodyStyle: function() {
        return this.headStyle
    },
    bodyRender: (row) => row.details ? row.details : empty(),
    bodyPdfRender: function(row) {
        return this.bodyRender(row);
    },
    bodyCsvRender: function(row) {
        return this.bodyRender(row);
    },
}, actionColumn(props)]);