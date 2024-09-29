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
    const regex = /__\(['"]([^'"]+)['"]\)/g;
    const matches = [];
    let match;

    while (match = regex.exec(content)) {
        matches.push(match[1]);
    }

    return matches;
};

// Function to extract text between __('')
const extractText2 = (content) => {
    const regex = /\$trans\(['"]([^'"]+)['"]\)/g;
    const matches = [];
    let match;

    while (match = regex.exec(content)) {
        matches.push(match[1]);
    }

    return matches;
};

// Main function
const extractTextFromFiles = (dir, js) => {
    const files = readFiles(dir);
    const result = {};

    files.forEach(file => {
        const content = fs.readFileSync(file, 'utf8');
        const matches = (js ? extractText2 : extractText)(content);
        if (matches.length) {
            result[file] = matches;
        }
    });

    return result;
};

if (process.argv.includes('--js')) {
    const directoryPath = ['public/js'];
    var data = {};
    directoryPath.forEach(path => {
        const extractedText = extractTextFromFiles(path, true);
        Object.values(extractedText).reduce((a, e) => [...a, ...e], []).forEach(dd => {
            data[dd] = dd;
        });
    });

    fs.writeFileSync("./js.json", JSON.stringify(data, null, 2), 'utf8');
} else {
    const directoryPath = ['app/Http/Controllers', 'resources/views'];
    var data = {};
    directoryPath.forEach(path => {
        const extractedText = extractTextFromFiles(path);
        Object.values(extractedText).reduce((a, e) => [...a, ...e], []).forEach(dd => {
            data[dd] = dd;
        });
    });

    fs.writeFileSync("./locale.json", JSON.stringify(data, null, 2), 'utf8');
}