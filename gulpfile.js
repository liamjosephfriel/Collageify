var gulp = require('gulp'),
    less = require('gulp-less'),
    uglify = require('gulp-uglify')
    cssmin = require('gulp-cssmin'),
    sass = require('gulp-sass')
    output_folder = './public/min/',
    sass.compiler = require('node-sass');
 
gulp.task('less', function() {
    var less_file = './css/style.less';
    
    return gulp.src(less_file)
        .pipe(less().on('error', function (err) {
            console.log(err);
        }))
        .pipe(cssmin().on('error', function (err) {
            console.log(err);
        }))
        .pipe(gulp.dest(output_folder));
});

gulp.task('js', function() {
    var js_files = ['./js/*.js', './node_modules/html2canvas/dist/html2canvas.js', './node_modules/bootstrap/dist/js/bootstrap.bundle.js'];

    return gulp.src(js_files)
          .pipe(uglify())
          .pipe(gulp.dest(output_folder));
});

gulp.task('sass', function () {
    var sass_file = './node_modules/bootstrap/scss/bootstrap.scss';

    return gulp.src(sass_file)
        .pipe(sass().on('error', sass.logError))
        .pipe(cssmin().on('error', function (err) {
            console.log(err);
        }))
        .pipe(gulp.dest(output_folder));
});


gulp.task('default', gulp.series('less', 'js', 'sass'));