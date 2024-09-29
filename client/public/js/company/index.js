TableVisualizer($query("neo-datavisualizer"), ({
    csrf,
    patch,
    clear
}) => [{
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
        bodyRender: (row) => `<img part="image" style="margin:auto;display:block;width:4rem;aspect-ratio:1/1;object-fit:contain;object-position:center;background:rgb(209 209 209);" src="${window.location.origin + "/storage/IMAGES/" + row.image.storage}" />`,
        bodyPdfRender: function(row) {
            return this.bodyRender(row);
        },
        bodyCsvRender: function(row) {
            return window.location.origin + "/storage/IMAGES/" + row.image.storage;
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
        bodyRender: (row) => `<div>${$capitalize($trans("Name"))}: ${row.representative.last_name.toUpperCase() + " " + $capitalize(row.representative.first_name)}</div><div>${$capitalize($trans("Email"))}: ${row.representative.email}</div><div>${$capitalize($trans("Phone"))}: ${row.representative.phone}</div>`,
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: (row) => `${$capitalize($trans("Name"))}: ${row.representative.last_name.toUpperCase() + " " + $capitalize(row.representative.first_name)}, ${$capitalize($trans("Email"))}: ${row.representative.email}, ${$capitalize($trans("Phone"))}: ${row.representative.phone}`
    },
    {
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
    }
]);