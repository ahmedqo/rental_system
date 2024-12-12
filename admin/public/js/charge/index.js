TableVisualizer($query("neo-datavisualizer"), ({
    csrf,
    patch,
    clear
}) => [{
    name: "company",
    text: $trans("Company"),
    bodyRender: (row) => row.owner ? $capitalize(row.owner.name) : empty(),
    bodyPdfRender: function(row) {
        return this.bodyRender(row);
    },
    bodyCsvRender: function(row) {
        return this.bodyRender(row);
    },
}, {
    name: "vehicle",
    text: $trans("Vehicle"),
    bodyRender: (row) => row.vehicle ? ($capitalize($trans(row.vehicle.brand)) + " " + $capitalize($trans(row.vehicle.model)) + " " + row.vehicle.year + " (" + row.vehicle.registration_number + ")") : empty(),
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
}, {
    name: "action",
    text: $trans("Actions"),
    headStyle: { width: 20, textAlign: "center" },
    bodyStyle: { width: 20, textAlign: "center" },
    bodyRender: (row) => `<action-menu target="${row.id}"csrf="${csrf}"patch="${patch}"clear="${clear}"></action-menu>`,
    headPdfStyle: function() {
        return this.headStyle
    },
    bodyPdfStyle: function() {
        return this.bodyStyle;
    },
    bodyPdfRender: () => empty(),
    bodyCsvRender: () => empty(),
}]);