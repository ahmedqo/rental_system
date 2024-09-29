const condition = $query("[name=condition]"),
    paths = $queryAll(".path"),
    print = $query("#print");

JSON.parse(condition.content).forEach(({ parts, color }) => {
    parts && parts.forEach(part => {
        $queryAll("#" + part).forEach(path => {
            path.style.fill = color;
        });
    });
});

condition.remove();