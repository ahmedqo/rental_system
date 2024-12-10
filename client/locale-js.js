import fs from 'fs';
import path from 'path';

// Function to read all files recursively from a directory
const readFiles = (dir, fileList = []) => {
    const st = fs.statSync(dir);

    if (st.isDirectory()) {
        const files = fs.readdirSync(dir);

        files.forEach(file => {
            const filePath = path.join(dir, file);
            const stat = fs.statSync(filePath);

            if (stat.isDirectory()) {
                readFiles(filePath, fileList);
            } else if (stat.isFile()) {
                fileList.push(filePath);
            }
        });
    } else if (st.isFile()) {
        fileList.push(dir);
    }

    return fileList;
};

// Function to extract text between __('')
const extractText = (content) => {
    const regex = /[@$]trans\(\s*['"`]((?:[^'"`]|\\['"`]|"(?:[^"\\]|\\.)*")*?)['"`]\s*,?\s*[\)|\[]/g;
    const matches = content.matchAll(regex);
    const params = Array.from(matches, match => match[1]);
    return params;
};

// Main function
const extractTextFromFiles = (dir, js) => {
    const result = {},
        files = fs.statSync(dir).isFile() ? [dir] : readFiles(dir);

    files.forEach(file => {
        const content = fs.readFileSync(file, 'utf8');
        const matches = extractText(content);
        if (matches.length) {
            result[file] = matches;
            matches.forEach(dd => console.log(`found: "${dd}" in ${file}`));
        }
    });

    return result;
};

function main() {
    const dictionary = {},
        args = process.argv,
        ends = args.includes("--view") ? '.js' : '',
        base = args.includes("--view") ? 'public/js' : '';

    const enter = args.indexOf("--enter") !== -1 ? [args[args.indexOf("--enter") + 1] + ends] : ['public/js'],
        leave = args.indexOf("--leave") !== -1 ? args[args.indexOf("--leave") + 1] : "locale-js";

    enter.forEach(_path => {
        const extractedText = extractTextFromFiles(path.join(base, _path));
        Object.values(extractedText).reduce((carry, current) => [...carry, ...current], []).forEach(text => {
            text = text.replace(/[\r\n\t]/g, "").replace(/\\(?=['"`])/g, '');
            dictionary[text] = text;
        });
    });

    fs.writeFileSync("./lang/" + leave + ".json", JSON.stringify(dictionary, null, 2), 'utf8');
    console.log(`completed successfully with ${Object.keys(dictionary).length} strings found`);
}

main();