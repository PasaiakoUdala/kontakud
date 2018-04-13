/**
 * egutegia31
 * Created by iibarguren on 3/13/17.
 */

var babel = require('gulp-babel'),
    concat = require('gulp-concat'),
    cssnano = require('gulp-cssnano'),
    del = require('del'),
    gulp = require('gulp'),
    merge = require('merge-stream'),
    minify = require('gulp-minify')
    ;

var config = {
    imgPath:  './app/Resources/assets/img',
    cssPath:  './app/Resources/assets/css',
    sassPath: './app/Resources/assets/scss',
    jsDir:    './app/Resources/assets/js',
    yarnDir:  './node_modules'

};


var paths = {
    npm: './node_modules',
    sass: ['./app/Resources/assets/scss/app.scss', './app/Resources/assets/js/font-awesome/scss/font-awesome.scss'],
    js: './app/Resources/assets/js',
    svg: './app/Resources/assets/svg',
    buildCss: './web/css',
    buildJs: './web/js',
    buildSvg: './web/svg'
};

myFonts = [
    config.yarnDir + '/font-awesome/fonts/**.*',
    config.yarnDir + '/bootstrap/fonts/**.*'
];

myJS = [
    config.yarnDir + "/bootstrap/dist/js/bootstrap.min.js",
    config.jsDir   + "/charts/charts.js",
    config.yarnDir + "/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js",
    config.yarnDir + "/bootstrap-datepicker/dist/locales/bootstrap-datepicker.eu.min.js",
    config.jsDir   + "/app.js"
];

myJSNoBabel = [
    config.yarnDir + "/jquery/dist/jquery.min.js",
    config.jsDir   + "/datatables/datatables.min.js",
    config.jsDir + "/bootbox/bootbox.min.js",
    config.yarnDir + "/bootstrap/dist/js/bootstrap.min.js"

];

myCSS = [
    config.yarnDir + '/bootstrap/dist/css/bootstrap.min.css',
    config.yarnDir + '/bootstrap/dist/css/bootstrap-theme.min.css',
    config.yarnDir + '/font-awesome/css/font-awesome.min.css',
    config.yarnDir + '/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css',
    config.cssPath + '/datatables/datatables.min.css',
    config.cssPath + '/app.css'
];

myIMG = [
    config.imgPath + "/spinner-gif-13.gif"
];


gulp.task('clean', function () {
    return del(['web/css/*','web/js/*','web/fonts/*']);
});

gulp.task('icons', function () {
    return gulp.src(myFonts).pipe(gulp.dest('./web/fonts'));

});

// JS
gulp.task('js:dev', function () {
    gulp.src(myJSNoBabel).pipe(gulp.dest('web/js/'));
    return gulp.src(myJS)
        .pipe(babel({presets: ['es2015']}))
        .pipe(gulp.dest('web/js/'));
});

gulp.task('js:prod', function () {
    gulp.src(myJSNoBabel).pipe(gulp.dest('web/js/'));
    return gulp.src(myJS)
               .pipe(babel({presets: ['es2015']}))
               .pipe(minify())
               .pipe(concat('app.min.js'))
               .pipe(gulp.dest('web/js/'));
});


gulp.task('css:dev', function () {
    gulp.src(myIMG).pipe(gulp.dest('web/img/'));
    gulp.src(myCSS).pipe(gulp.dest('web/css/'));
});

gulp.task('css:prod', function () {
    gulp.src(myIMG).pipe(gulp.dest('web/img/'));
    return merge (
        gulp.src(myCSS)
            .pipe(cssnano({keepSpecialComments: 1,rebase: false}))

        ).pipe(concat('app.min.css')).pipe(gulp.dest(paths.buildCss));
});

gulp.task('watch', function () {
    gulp.watch(myCSS, ['css:dev']);
    gulp.watch(myJS, ['js:dev'])
});

gulp.task('dev', ['icons', 'js:dev', 'css:dev']);

gulp.task('prod', ['clean','icons', 'js:prod', 'css:prod']);

gulp.task('default', ['clean', 'icons', 'js:dev', 'css:dev', 'watch']);