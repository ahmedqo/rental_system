const filter = $query("#filter"),
    data = $query("neo-datavisualizer");

filter.addEventListener("change", e => {
    filter.parentElement.label = e.detail.data ? $trans('Show all payments') : $trans('Show pending payments');
    TableVisualizer(data, exec, {
        search: $routes[e.detail.data ? 'filter' : 'entire']
    });
});

function exec(props) {
    return [{
        name: "reference",
        text: $trans("Reference"),
        headStyle: { textAlign: "center" },
        bodyStyle: (row) => ({...bgdate(row), textAlign: "center" }),
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
    }, {
        name: "vehicle",
        text: $trans("Vehicle"),
        bodyStyle: (row) => bgdate(row),
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyRender: (row) => row.vehicle ? ($capitalize($trans(row.vehicle.brand)) + " " + $capitalize($trans(row.vehicle.model)) + " " + row.vehicle.year + " (&#x202B;" + row.vehicle.registration_number + "&#x202C;)") : empty(),
        bodyPdfRender: function(row) {
            return this.bodyRender(row);
        },
        bodyCsvRender: function(row) {
            return this.bodyRender(row);
        },
    }, {
        name: "renter",
        text: $trans("Renter"),
        bodyStyle: (row) => bgdate(row),
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyRender: (row) => {
            if (row.agency) return `<div>${$capitalize($trans("Agency"))}: ${$capitalize(row.agency.name)}</div>`;
            if (row.client) return `<div>${$capitalize($trans("Client"))}: ${row.client.last_name.toUpperCase() + " " + $capitalize(row.client.first_name)}</div>` + (row.sclient ? `<div>${$capitalize($trans("Secondary client"))}: ${row.sclient.last_name.toUpperCase() + " " + $capitalize(row.sclient.first_name)}</div>` : "");
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: (row) => {
            if (row.agency) return `${$capitalize($trans("Agency"))}: ${$capitalize(row.agency.name)}`;
            if (row.client) return `${$capitalize($trans("Client"))}: ${row.client.last_name.toUpperCase() + " " + $capitalize(row.client.first_name)}` + (row.sclient ? `, ${$capitalize($trans("Secondary client"))}: ${row.sclient.last_name.toUpperCase() + " " + $capitalize(row.sclient.first_name)}` : "");
        },
    }, {
        name: "daily_rate",
        text: $trans("Daily rate"),
        headStyle: { textAlign: "center" },
        bodyStyle: (row) => ({...bgdate(row), textAlign: "center" }),
        bodyRender: (row) => $money(+row.daily_rate, 2) + " " + $core.currency,
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        name: "total",
        text: $trans("Total"),
        headStyle: { textAlign: "center" },
        bodyStyle: (row) => ({...bgdate(row), textAlign: "center" }),
        bodyRender: (row) => $money(+row.total, 2) + " " + $core.currency,
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        name: "paid",
        text: $trans("Payment"),
        headStyle: { textAlign: "center" },
        bodyStyle: (row) => ({...bgdate(row), textAlign: "center" }),
        bodyRender: (row) => $money(+row.paid, 2) + " " + $core.currency,
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        name: "rest",
        text: $trans("Creance"),
        headStyle: { textAlign: "center" },
        bodyStyle: (row) => ({...bgdate(row), textAlign: "center" }),
        bodyRender: (row) => $money(+row.rest, 2) + " " + $core.currency,
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        name: "status",
        text: $trans("Status"),
        headStyle: { textAlign: "center" },
        bodyStyle: (row) => ({...bgdate(row), textAlign: "center" }),
        bodyRender: (row) => $capitalize($trans(row.status)),
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, actionColumn({...props, css: { body: bgdate } })];
}

TableVisualizer(data, exec, {
    search: $routes.filter
});