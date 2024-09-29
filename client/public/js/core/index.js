const donut = $query("#donut"),
    chart = $query("#chart"),
    loaders = $queryAll(".loader"),
    ldonut = $query(".donut-loader"),
    lchart = $query(".chart-loader"),
    filter = $query("#filter"),
    data = $query("#data-tickets"),
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
        chart.parentElement.innerHTML = `<span class="block text-x-black font-x-thin text-lg text-center">${$trans("No data found")}</span>`;
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
    });
});

function exec({ scene }) {
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
    }, {
        name: "action",
        text: $trans("Actions"),
        headStyle: { width: 20, textAlign: "center" },
        bodyStyle: function(row) {
            return {...bgtick(row), width: 20, textAlign: "center" };
        },
        bodyPdfStyle: function(row) {
            return this.bodyStyle(row);
        },
        bodyRender: (row) => `<action-tools target="${row.id}" scene="${scene}"></action-tools>`,
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfRender: () => empty(),
        bodyCsvRender: () => empty(),
    }];
}

TableVisualizer(data, exec, {
    search: $routes.filter,
    scene: $routes.scene
});