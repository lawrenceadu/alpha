/* eslint-env node */
'use strict';

const gulp   = require('gulp');
const uglify = require("gulp-uglify");
const sass   = require("gulp-sass");
const babel  = require("gulp-babel");

gulp.task("compress", function (cb) {
    return gulp
        .src("./assets/src/app.js")
        .pipe(babel({ presets: ["@babel/preset-env"].map(require.resolve) }))
        .pipe(uglify())
        .pipe(gulp.dest("./assets/js"));
});

gulp.task('sass', function () {
    return gulp
        .src('./assets/src/**/*.scss')
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        .pipe(gulp.dest('./assets/css'));
});

gulp.task('watch', function () {
    gulp.watch("./assets/src/app.js", gulp.parallel(['compress']));
    gulp.watch("./assets/src/**/*.scss", gulp.parallel(["sass"]));
});

gulp.task("default", gulp.parallel(["watch"]));
