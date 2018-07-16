/* eslint-env node */
'use strict';

const gulp = require('gulp');
const uglify = require("gulp-uglify");
const sass = require("gulp-sass");
const pump = require("pump");
const babel = require("gulp-babel");
const path = require("path");

gulp.task("default", ["watch"]);

gulp.task("compress", function (cb) {
    return gulp
        .src("./assets/src/app.js")
        .pipe(babel({ presets: ["babel-preset-es2015", "babel-preset-es2016", "babel-preset-es2017"].map(require.resolve) }))
        .pipe(uglify())
        .pipe(gulp.dest("./assets/js"));
});

// sass preprocessor
gulp.task('sass', function () {
    return gulp
        .src('./assets/src/**/*.scss')
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        .pipe(gulp.dest('./assets/css'));
});

gulp.task('watch', function () {
    gulp.watch("./assets/src/app.js", ['compress']);
    gulp.watch("./assets/src/**/*.scss", ["sass"]);
}); 