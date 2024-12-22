TableVisualizer($query("neo-datavisualizer"), (props) => [{
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
}, actionColumn(props)]);