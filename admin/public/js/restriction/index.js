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
    name: "client",
    text: $trans("Client"),
    bodyRender: (row) => row.client ? (row.client.last_name.toUpperCase() + " " + $capitalize(row.client.first_name)) : empty(),
    bodyPdfRender: function(row) {
        return this.bodyRender(row);
    },
    bodyCsvRender: function(row) {
        return this.bodyRender(row);
    },
}, {
    name: "reasons",
    text: $trans("Reasons"),
    headStyle: {
        maxWidth: 300,
    },
    bodyStyle: function() {
        return this.headStyle
    },
    bodyRender: (row) => row.reasons ? $capitalize(row.reasons) : empty(),
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
    bodyRender: (row) => `<action-tools target="${row.id}"csrf="${csrf}"patch="${patch}"clear="${clear}"></action-tools>`,
    headPdfStyle: function() {
        return this.headStyle
    },
    bodyPdfStyle: function() {
        return this.bodyStyle;
    },
    bodyPdfRender: () => empty(),
    bodyCsvRender: () => empty(),
}]);