const chart = $query("#chart"),
    loaders = $queryAll(".loader"),
    lchart = $query(".chart-loader"),
    filter = $query("#filter"),
    data = $query("#data-tickets"),
    remove = $query('meta[name=rtl]'),
    rtl = +remove.content;

remove.remove();

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

TableVisualizer($query("#data-popular"), () => [{
        name: "owner",
        text: $trans("Company"),
    }, {
        name: "vehicle",
        text: $trans("Vehicle"),
    }, {
        name: "paid",
        text: $trans("Payment"),
        headStyle: { textAlign: "center" },
        bodyStyle: { textAlign: "center" },
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyRender: (row) => $money(+row.paid, 2) + " " + $core.currency,
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        name: "rest",
        text: $trans("Creance"),
        headStyle: { textAlign: "center" },
        bodyStyle: { textAlign: "center" },
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyRender: (row) => $money(+row.rest, 2) + " " + $core.currency,
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    },
    {
        name: "mileage",
        text: $trans("Mileage"),
        headStyle: { textAlign: "center" },
        bodyStyle: { textAlign: "center" },
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyRender: (row) => row.mileage + " " + $trans('Km'),
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    },
    {
        name: "period",
        text: $trans("Rental period"),
        headStyle: { textAlign: "center" },
        bodyStyle: { textAlign: "center" },
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyRender: (row) => row.period + " " + $trans('Days'),
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    },
]);

filter.addEventListener("change", e => {
    TableVisualizer(data, exec, {
        search: $routes[e.detail.data ? 'filter' : 'entire'],
        scene: $routes.scene
    }, true);
});

function exec() {
    return [{
        name: "reference",
        text: $trans("Reference"),
        headStyle: { textAlign: "center" },
        bodyStyle: function(row) {
            return {...bgtick(row), textAlign: "center" };
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        headPdfStyle: function() {
            return this.headStyle
        },
    }, {
        name: "subject",
        text: $trans("Subject"),
        bodyStyle: function(row) {
            return bgtick(row);
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyRender: (row) => $capitalize(row.subject),
        bodyPdfRender: function(row) {
            return this.bodyRender(row);
        },
        bodyCsvRender: function(row) {
            return this.bodyRender(row);
        },
    }, {
        name: "category",
        text: $trans("Category"),
        bodyStyle: function(row) {
            return bgtick(row);
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyRender: (row) => $capitalize($trans(row.category)),
        bodyPdfRender: function(row) {
            return this.bodyRender(row);
        },
        bodyCsvRender: function(row) {
            return this.bodyRender(row);
        },
    }, {
        name: "status",
        text: $trans("Status"),
        headStyle: { textAlign: "center" },
        bodyStyle: function(row) {
            return {...bgtick(row), textAlign: "center" };
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
    }];
}

TableVisualizer(data, exec, {
    search: $routes.filter,
    scene: $routes.scene
}, true);