let mix      = require('laravel-mix');
const path   = require('path');
let argv     = require('yargs').argv;
let readdirp = require('readdirp');
const core   = require('./webpack/core.config');
const fs     = require('fs');
let klawSync = require('klaw-sync');
/*
 * Some config to load Handlebarsjs
 */
mix.disableNotifications();
mix.webpackConfig(core);
mix.options({ processCssUrls: false, poll: true });
// Build specific file npm run build -- --env.pkg=frontend
/**
 * Scan all folder in parent dir
 * @param p: path to folder
 */
const dirs = p => fs.readdirSync(p).filter(f => fs.statSync(path.resolve(p, f)).isDirectory());

/**
 * Scan all js/scss files in folder
 * @param p: path to folder
 */
const files = (p) => {
    return fs.readdirSync(p).filter(f => {
        let extension = f.split('.').pop();
        return fs.statSync(path.resolve(p, f)).isFile() && (extension === 'js' || extension === 'scss');
    });
};

const scanFiles = (resourcePath, prefix = 'js') => {
    let allFiles = [];
    if (fs.existsSync(resourcePath)) {
        let resultAllPaths = fs.readdirSync(resourcePath);
        resultAllPaths.forEach(function (resultPath) {
            let extension = resultPath.split('.').pop();
            let filePath = path.resolve(resourcePath, resultPath);
            if(fs.statSync(filePath).isFile() && (extension === prefix)) {
                allFiles.push({
                    filePath : filePath,
                    fileName : resultPath
                });
            }
        });
    }
    return allFiles;
}

let env            = argv.env;
let packageName    = env.pkg;
let basedir        = env.dir || "core";
let resourcePath   = `./${basedir}/${packageName}/resources/assets`;
let configs        = { js : `${resourcePath}/js/build`, scss : `${resourcePath}/scss/build` };

/**
 * Scan file build
 * @param  {[type]} key) {              results[key] [description]
 * @return {[type]}      [description]
 */
Object.keys(configs).forEach(function (key) {
    let allFiles = scanFiles(configs[key], key);
    allFiles.forEach(function (file) {
        let prefix   = key == 'js' ? key : 'css';
        let tempArr  = file.fileName.split('.').slice(0, -1);
        let fileName = [];
        Object.keys(tempArr).map(function(index) {
          fileName.push(tempArr[index]);
        });
        fileName.push(prefix);
        fileName = fileName.join('.');
        let fileBuild = path.resolve(`public/frontend/${basedir}`, packageName.toLowerCase(), `assets/${prefix}`, fileName);
        prefix == 'js' ? mix.js(file.filePath, fileBuild).sourceMaps() : mix.sass(file.filePath, fileBuild).sourceMaps();
    });
});