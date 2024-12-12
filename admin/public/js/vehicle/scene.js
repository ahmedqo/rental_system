const donut = $query("#donut"),
    chart = $query("#chart"),
    loaders = $queryAll(".loader"),
    ldonut = $query(".donut-loader"),
    lchart = $query(".chart-loader"),
    remove = [$query('meta[name=count]'), $query('meta[name=rtl]')],
    counts = JSON.parse(remove[0].content),
    rtl = +remove[1].content;

remove.forEach(r => r.remove());

function flip(arr) {
    return rtl ? arr.reverse() : arr
}

function zero(arr) {
    return arr.some(e => e !== 0);
}

loaders.forEach(loader => {
    setTimeout(() => {
        loader.remove();
    }, Math.floor(Math.random() * 500) + 500);
});

new Chart(donut, {
    type: "doughnut",
    data: {
        labels: flip([$trans("Payments"), $trans("Charges")]),
        datasets: [{
            data: flip(counts),
            borderWidth: 1,
            backgroundColor: flip(["rgb(34 197 94)", "rgb(239 68 68)"]),
            borderColor: flip(["rgb(34 197 94)", "rgb(239 68 68)"]),
        }, ]
    },
    options: {
        responsive: true,
        cutout: '70%',
        plugins: {
            legend: {
                display: false
            },
        },
        animation: {
            onComplete: () => {
                ldonut.remove();
            }
        }
    }
});

(async() => {
    const data = await getData($routes.chart);
    if (!zero(data['creances']) && !zero(data['payments']) && !zero(data['charges'])) {
        chart.parentElement.innerHTML = notFound();
    } else {
        data['keys'] = data['keys'].map(e => $trans(e));
        new Chart(chart, {
            data: {
                labels: flip(data['keys']),
                datasets: [
                    ...(zero(data['creances']) ? [{
                        order: 2,
                        type: "bar",
                        borderWidth: 2,
                        label: $trans('Creance'),
                        data: flip(data['creances']),
                        backgroundColor: "rgb(234 179 8)",
                        borderColor: "rgb(234 179 8)",
                    }] : []),
                    ...(zero(data['payments']) ? [{
                        order: 2,
                        type: "bar",
                        borderWidth: 2,
                        label: $trans('Payments'),
                        data: flip(data['payments']),
                        backgroundColor: "rgb(34 197 94)",
                        borderColor: "rgb(34 197 94)",
                    }] : []),
                    ...(zero(data['charges']) ? [{
                        order: 1,
                        type: "line",
                        borderWidth: 2,
                        label: $trans('Charges'),
                        data: flip(data['charges']),
                        backgroundColor: "rgb(239 68 68)",
                        borderColor: "rgb(239 68 68)",
                    }] : []),
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        position: rtl ? "right" : "left"
                    }
                },
                animation: {
                    onComplete: () => {
                        lchart.remove();
                    }
                }
            }
        });
    }
})();

const filterReservations = $query("#filter-reservations"),
    filterRecoveries = $query("#filter-recoveries"),
    filterPayments = $query("#filter-payments"),
    dataReservations = $query("#data-reservations"),
    dataRecoveries = $query("#data-recoveries"),
    dataPayments = $query("#data-payments");

filterReservations.addEventListener("change", e => {
    TableVisualizer(dataReservations, execReservations, {
        search: $routes[e.detail.data ? 'filterReservations' : 'entireReservations'],
        patch: $routes.patchReservation,
        scene: $routes.sceneReservation,
    }, true);
});

filterRecoveries.addEventListener("change", e => {
    TableVisualizer(dataRecoveries, execRecoveries, {
        search: $routes[e.detail.data ? 'filterRecoveries' : 'entireRecoveries'],
        patch: $routes.patchRecovery
    });
});

filterPayments.addEventListener("change", e => {
    TableVisualizer(dataPayments, execPayments, {
        search: $routes[e.detail.data ? 'filterPayments' : 'entirePayments'],
        patch: $routes.patchPayment
    });
});

function execReservations({ patch }) {
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
        bodyRender: (row) => `<action-menu target="${row.id}"patch="${patch}"></action-menu>`,
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfRender: () => empty(),
        bodyCsvRender: () => empty(),
    }];
}

function execRecoveries({ patch }) {
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
        bodyRender: (row) => row.reference,
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
        bodyStyle: function(row) {
            if ((new Date(row.dropoff_date)).getTime() < (new Date).getTime() && row.status === "pending") return { background: "#ffc4c0", width: 20, textAlign: "center" };
            return { width: 20, textAlign: "center" };
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyRender: (row) => `<action-menu target="${row.id}"patch="${patch}"></action-menu>`,
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfRender: () => empty(),
        bodyCsvRender: () => empty(),
    }];
}

function execPayments({ patch }) {
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
        bodyRender: (row) => row.reference,
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
        name: "daily_rate",
        text: $trans("Daily rate"),
        headStyle: { textAlign: "center" },
        bodyStyle: { textAlign: "center" },
        bodyRender: (row) => $money(+row.daily_rate, 2) + " " + $core.currency,
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        name: "total",
        text: $trans("Total"),
        headStyle: { textAlign: "center" },
        bodyStyle: { textAlign: "center" },
        bodyRender: (row) => $money(+row.total, 2) + " " + $core.currency,
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        name: "paid",
        text: $trans("Payment"),
        headStyle: { textAlign: "center" },
        bodyStyle: { textAlign: "center" },
        bodyRender: (row) => $money(+row.paid, 2) + " " + $core.currency,
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        name: "rest",
        text: $trans("Creance"),
        headStyle: { textAlign: "center" },
        bodyStyle: { textAlign: "center" },
        bodyRender: (row) => $money(+row.rest, 2) + " " + $core.currency,
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
        bodyStyle: function(row) {
            if ((new Date(row.dropoff_date)).getTime() < (new Date).getTime() && row.status === "pending") return { background: "#ffc4c0", width: 20, textAlign: "center" };
            return { width: 20, textAlign: "center" };
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyRender: (row) => `<action-menu target="${row.id}"patch="${patch}"></action-menu>`,
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfRender: () => empty(),
        bodyCsvRender: () => empty(),
    }];
}

TableVisualizer(dataReservations, execReservations, {
    search: $routes.filterReservations,
    patch: $routes.patchReservation,
    scene: $routes.sceneReservation,
}, true);

TableVisualizer(dataRecoveries, execRecoveries, {
    search: $routes.filterRecoveries,
    patch: $routes.patchRecovery
});

TableVisualizer(dataPayments, execPayments, {
    search: $routes.filterPayments,
    patch: $routes.patchPayment
});

TableVisualizer($query("#data-charges"), ({
    csrf,
    patch,
    clear
}) => [{
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
}], {
    search: $routes.entireCharges,
    patch: $routes.patchCharge,
    clear: $routes.clearCharge,
});