const fs = require('fs');
const path = require('path');

const jsDir = path.join(__dirname, 'assets', 'Js');

fs.readdirSync(jsDir).forEach(file => {
    if (file.endsWith('.js')) {
        const filePath = path.join(jsDir, file);
        let content = fs.readFileSync(filePath, 'utf8');
        
        // Regex to replace alert(...) with window.showToast(...)
        const newContent = content.replace(/\balert\s*\(/g, 'window.showToast(');
        
        if (content !== newContent) {
            fs.writeFileSync(filePath, newContent, 'utf8');
            console.log(`Updated ${file}`);
        }
    }
});
