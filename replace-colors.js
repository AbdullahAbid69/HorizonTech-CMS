import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const targetColor = '#0d6efd';
const colorPatterns = [
  /#0000FF/gi, // Blue
  /#00FFFF/gi, // Cyan
  /#ADD8E6/gi, // Light Blue
  /#87CEEB/gi, // Sky Blue
  /#4682B4/gi, // Steel Blue
  /\bblue\b/gi,
  /\bcyan\b/gi,
  /#74ebd5/gi,
  /#acb6e5/gi,
  /#acb6e5/gi,
  /#1C355E/gi,
  /#4B49AC/gi
];

const replaceColorsInFile = (filePath) => {
  const content = fs.readFileSync(filePath, 'utf8');
  let updatedContent = content;

  colorPatterns.forEach((pattern) => {
    updatedContent = updatedContent.replace(pattern, targetColor);
  });

  if (content !== updatedContent) {
    fs.writeFileSync(filePath, updatedContent, 'utf8');
    console.log(`Updated colors in: ${filePath}`);
  }
};

const traverseDirectory = (dir) => {
  fs.readdirSync(dir).forEach((file) => {
    const fullPath = path.join(dir, file);
    if (fs.statSync(fullPath).isDirectory()) {
      traverseDirectory(fullPath);
    } else if (fullPath.endsWith('.css') || fullPath.endsWith('.js')) {
      replaceColorsInFile(fullPath);
    }
  });
};

// Replace colors in the "public" directory
traverseDirectory(path.join(__dirname, 'public'));