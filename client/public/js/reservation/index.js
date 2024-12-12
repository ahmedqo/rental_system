const filter = $query("#filter"),
    data = $query("neo-datavisualizer");

filter.addEventListener("change", e => {
    TableVisualizer(data, exec, {
        search: $routes[e.detail.data ? 'filter' : 'entire']
    });
});

function exec({
    patch,
    print,
}) {
    return [{
        name: "reference",
        text: $trans("Reference"),
        headStyle: { textAlign: "center" },
        bodyStyle: function(row) {
            return {...bgdate(row), textAlign: "center" };
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        headPdfStyle: function() {
            return this.headStyle
        },
    }, {
        name: "vehicle",
        text: $trans("Vehicle"),
        bodyStyle: function(row) {
            return bgdate(row);
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
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
        bodyStyle: function(row) {
            return bgdate(row);
        },
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
        name: "pickup",
        text: $trans("Pickup"),
        bodyStyle: function(row) {
            return bgdate(row);
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyRender: (row) => row.pickup_location ? `<div>${$capitalize($trans("Date"))}: ${$moment(row.pickup_date, $core.format + " hh:MM A")}</div><div>${$capitalize($trans("Location"))}: ${$capitalize(row.pickup_location)}</div>` : $moment(row.pickup_date, $core.format + " hh:MM A"),
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: (row) => row.pickup_location ? `${$capitalize($trans("Date"))}: ${$moment(row.pickup_date, $core.format + " hh:MM A")}, ${$capitalize($trans("Location"))}: ${$capitalize(row.pickup_location)}` : $moment(row.pickup_date, $core.format + " hh:MM A"),
    }, {
        visible: false,
        name: "dropoff",
        text: $trans("Dropoff"),
        bodyStyle: function(row) {
            return bgdate(row);
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyRender: (row) => row.dropoff_location ? `<div>${$capitalize($trans("Date"))}: ${$moment(row.dropoff_date, $core.format + " hh:MM A")}</div><div>${$capitalize($trans("Location"))}: ${$capitalize(row.dropoff_location)}</div>` : $moment(row.dropoff_date, $core.format + " hh:MM A"),
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: (row) => row.dropoff_location ? `${$capitalize($trans("Date"))}: ${$moment(row.dropoff_date, $core.format + " hh:MM A")}, ${$capitalize($trans("Location"))}: ${$capitalize(row.dropoff_location)}` : $moment(row.dropoff_date, $core.format + " hh:MM A"),
    }, {
        name: "rental_period_days",
        text: $trans("Rental period"),
        headStyle: { textAlign: "center" },
        bodyStyle: function(row) {
            return {...bgdate(row), textAlign: "center" };
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyRender: (row) => row.rental_period_days + " " + $trans('Days'),
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        visible: false,
        name: "mileage",
        text: $trans("Mileage"),
        headStyle: { textAlign: "center" },
        bodyStyle: function(row) {
            return {...bgdate(row), textAlign: "center" };
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyRender: (row) => row.mileage + " " + $trans('Km'),
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        visible: false,
        name: "fuel_level",
        text: $trans("Fuel level"),
        headStyle: { textAlign: "center" },
        bodyStyle: function(row) {
            return {...bgdate(row), textAlign: "center" };
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyRender: (row) => $money(+row.fuel_level, 2) + " %",
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        name: "status",
        text: $trans("Status"),
        headStyle: { textAlign: "center" },
        bodyStyle: function(row) {
            return {...bgdate(row), textAlign: "center" };
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyRender: (row) => $capitalize($trans(row.status)),
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        name: "action",
        text: $trans("Actions"),
        headStyle: { width: 20, textAlign: "center" },
        bodyStyle: function(row) {
            return {...bgdate(row), width: 20, textAlign: "center" };
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyRender: (row) => `<action-menu target="${row.id}"patch="${patch}"print="${print}"></action-menu>`,
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfRender: () => empty(),
        bodyCsvRender: () => empty(),
    }];
}

TableVisualizer(data, exec, {
    search: $routes.filter
});