searchable($query("neo-autocomplete[name=client]"), $routes.search, function(data) {
    return data.map(row => {
        return {
            ...row,
            name: row.last_name.toUpperCase() + " " + $capitalize(row.first_name) + (row.restriction ? " (" + $capitalize($trans('banned')) + ")" : "")
        }
    });
});