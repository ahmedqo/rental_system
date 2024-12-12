const filter = $query("#filter"),
    data = $query("neo-datavisualizer");

filter.addEventListener("change", e => {
    TableVisualizer(data, exec, {
        search: $routes[e.detail.data ? 'filter' : 'entire']
    });
});

function exec({
    patch,
}) {
    return [{
        name: "reference",
        text: $trans("Reference"),
        headStyle: { textAlign: "center" },
        bodyStyle: { textAlign: "center" },
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyRender: (row) => row.reservation.reference,
        bodyPdfRender: function(row) {
            return this.bodyRender(row);
        },
        bodyCsvRender: function(row) {
            return this.bodyRender(row);
        },
    }, {
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
        name: "renter",
        text: $trans("Renter"),
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
        name: "mileage",
        text: $trans("Mileage"),
        headStyle: { textAlign: "center" },
        bodyStyle: { textAlign: "center" },
        bodyRender: (row) => row.mileage + " " + $trans('Km'),
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        name: "fuel_level",
        text: $trans("Fuel level"),
        headStyle: { textAlign: "center" },
        bodyStyle: { textAlign: "center" },
        bodyRender: (row) => $money(+row.fuel_level, 2) + " %",
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        name: "penalties",
        text: $trans("Penalties"),
        headStyle: { textAlign: "center" },
        bodyStyle: { textAlign: "center" },
        bodyRender: (row) => $money(+JSON.parse(row.penalties).reduce((a, e) => a + e.cost, 0), 2) + " " + $core.currency,
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        name: "status",
        text: $trans("Status"),
        headStyle: { textAlign: "center" },
        bodyStyle: { textAlign: "center" },
        bodyRender: (row) => $capitalize($trans(row.status)),
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        name: "action",
        text: $trans("Actions"),
        headStyle: { width: 20, textAlign: "center" },
        bodyStyle: { width: 20, textAlign: "center" },
        bodyRender: (row) => `<action-menu target="${row.id}"patch="${patch}"></action-menu>`,
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyPdfRender: () => empty(),
        bodyCsvRender: () => empty(),
    }];
}

TableVisualizer(data, exec, {
    search: $routes.filter
});