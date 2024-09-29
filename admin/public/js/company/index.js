TableVisualizer($query("neo-datavisualizer"), ({
    csrf,
    patch,
    scene,
    clear
}) => [{
        name: "status",
        text: $trans("Status"),
        headStyle: {
            fontSize: "0px",
            paddingInlineEnd: "0px"
        },
        bodyStyle: {
            paddingInlineEnd: "0px"
        },
        headPdfStyle: function() {
            return this.headStyle;
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyRender: (row) => `<span style="width:1rem;height:1rem;display:block;background:${row.status !== 'active' ? "#ff674d" : "#71ea76"};border-radius:9999px;margin:auto;"></spam>`,
        bodyPdfRender: function(row) {
            return this.bodyRender(row);
        },
        bodyCsvRender: (row) => $capitalize($trans(row.status)),
    }, {
        name: "logo",
        text: $trans('Logo'),
        headStyle: { width: 20, textAlign: "center" },
        bodyStyle: { width: 20, textAlign: "center" },
        headPdfStyle: function() {
            return this.headStyle;
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyRender: (row) => `<img part="image" style="margin:auto;display:block;width:4rem;aspect-ratio:1/1;object-fit:contain;object-position:center;background:rgb(209 209 209);" src="${$routes.base + (row.image ? row.image.storage : '')}" />`,
        bodyPdfRender: function(row) {
            return this.bodyRender(row);
        },
        bodyCsvRender: function(row) {
            return $routes.base + (row.image ? row.image.storage : '');
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
        name: "email",
        text: $trans("Email"),
    }, {
        name: "phone",
        text: $trans("Phone"),
    }, {
        visible: false,
        name: "ice_number",
        text: $trans("ICE number"),
        bodyRender: (row) => row.ice_number.toUpperCase(),
        bodyPdfRender: function(row) {
            return this.bodyRender(row);
        },
        bodyCsvRender: function(row) {
            return this.bodyRender(row);
        },
    }, {
        visible: false,
        name: "license_number",
        text: $trans("License number"),
        bodyRender: (row) => row.license_number.toUpperCase(),
        bodyPdfRender: function(row) {
            return this.bodyRender(row);
        },
        bodyCsvRender: function(row) {
            return this.bodyRender(row);
        },
    }, {
        visible: false,
        name: "address",
        text: $trans("Address"),
        bodyRender: (row) => $capitalize(row.address) + ", " + $capitalize(row.city) + ", " + row.zipcode,
        bodyPdfRender: function(row) {
            return this.bodyRender(row);
        },
        bodyCsvRender: function(row) {
            return this.bodyRender(row);
        },
    },
    {
        name: "representative",
        text: $trans("Representative"),
        bodyRender: (row) => `<div>${$capitalize($trans("Full name"))}: ${row.representative ? (row.representative.last_name.toUpperCase() + " " + $capitalize(row.representative.first_name)) : empty()}</div><div>${$capitalize($trans("Email"))}: ${row.representative ? row.representative.email : empty()}</div><div>${$capitalize($trans("Phone"))}: ${row.representative ? row.representative.phone : empty()}</div>`,
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: (row) => `${$capitalize($trans("Full name"))}: ${row.representative ? (row.representative.last_name.toUpperCase() + " " + $capitalize(row.representative.first_name)) : empty()}, ${$capitalize($trans("Email"))}: ${row.representative ? row.representative.email : empty()}, ${$capitalize($trans("Phone"))}: ${row.representative ? row.representative.phone : empty()}`
    },
    {
        name: "action",
        text: $trans("Actions"),
        headStyle: { width: 20, textAlign: "center" },
        bodyStyle: { width: 20, textAlign: "center" },
        bodyRender: (row) => `<action-tools target="${row.id}"csrf="${csrf}"patch="${patch}"scene="${scene}"clear="${clear}"></action-tools>`,
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyPdfRender: () => empty(),
        bodyCsvRender: () => empty(),
    }
]);