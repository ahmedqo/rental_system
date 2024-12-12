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
    bodyRender: (row) => row.phone + (row.secondary_phone ? (" / " + row.secondary_phone) : ""),
    bodyPdfRender: function(row) {
        return this.bodyRender(row);
    },
    bodyCsvRender: function(row) {
        return this.bodyRender(row);
    },
}, {
    name: "address",
    text: $trans("Address"),
    bodyRender: (row) => $capitalize(row.address) + ", " + $capitalize(row.city) + ", " + row.zipcode,
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
}], {}, true);