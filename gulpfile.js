const { src, dest, series, parallel } = require('gulp');
const sass = require('gulp-sass');
const postcss = require("gulp-postcss");
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const rename = require("gulp-rename");

const paths = {
    sass: {
        src: './src/scss/*.scss',
        dest: './src/css/'
    },
    css: {
        src: './src/css/*.css',
        dest: './assets/css'
    }
};

const cssPlugins = [
    autoprefixer({browsers: ['last 1 version']}),
    cssnano()
];


// Define tasks after requiring dependencies
function scss() {
    // Where should gulp look for the sass files?
    // My .sass files are stored in the styles folder
    // (If you want to use scss files, simply look for *.scss files instead)
    return src(paths.sass.src, {
        sourcemaps: true
    })
    // Use sass with the files found, and log any errors
        .pipe(sass())
        .on("error", sass.logError)

        // What is the destination for the compiled file?
        .pipe(dest(paths.sass.dest));
}

function css() {
    return src(paths.css.src, {
        sourcemaps: true
    })
    // Use sass with the files found, and log any errors
        .pipe(postcss(cssPlugins))

        // What is the destination for the compiled file?
        .pipe(dest(paths.css.dest));
}

function minify(cb) {
    // body omitted
    cb();
}

// The `clean` function is not exported so it can be considered a private task.
// It can still be used within the `series()` composition.
function clean(cb) {
    // body omitted
    cb();
}

// The `build` function is exported so it is public and can be run with the `gulp` command.
// It can also be used within the `series()` composition.
function build(cb) {
    // body omitted
    cb();
}

exports.css = css;
exports.default = series(scss, css);