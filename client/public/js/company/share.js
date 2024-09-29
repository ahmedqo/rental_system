const image = $query("[name=image]"),
    transfer = $query("neo-imagetransfer");

transfer.default = [{
    src: image.content
}];

image.remove();