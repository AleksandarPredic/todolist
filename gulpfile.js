var gulp = require('gulp'),
	uglify = require('gulp-uglify'),
	rename = require('gulp-rename'),
	sass = require('gulp-sass'),
	sourcemaps = require('gulp-sourcemaps'),
	livereload = require('gulp-livereload'),
	changedInPlace = require('gulp-changed-in-place'),
	autoprefixer = require('gulp-autoprefixer');

// Paths and tasks
var scriptsPath = 'resources/assets/js/**/*.js',
    scriptsTask = 'scripts',
    scssPath = 'resources/assets/scss/**/*.scss',
    scssTask = 'styles',
    changedInPlacePath = 'resources/assets/**/*',
    changedInPlaceTask = 'changedInPlace';

// Error handler - not used in this example
function errorLog(error) {
    console.error.bind(error);
    this.emit('end');
}

/**
 * scripts task
 * Uglify, add suffix .min,
 */
 gulp.task(scriptsTask, function(){
    return gulp.src(scriptsPath)
        .pipe(rename({
        suffix: '.min'
        }))
        .pipe(uglify())
        .pipe(gulp.dest('public/assets/js'))
        .pipe(livereload());
 });

/**
 * styles task
 * Compile sass to css
 */
gulp.task(scssTask, function(){
	return gulp.src(scssPath)
		.pipe(autoprefixer({
			browsers: ['> 5%', 'Last 2 versions', ]
		}))
		.pipe(rename({
		suffix: '.min'
		}))
		.pipe(sourcemaps.init())
		.pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
		.pipe(sourcemaps.write('maps/'))
		.pipe(gulp.dest('public/assets/css'))
		.pipe(livereload());
});

/**
 * changedInPlace task
 * Trigger live reload when file in wp change
 */
gulp.task(changedInPlaceTask, function(){
    return gulp.src(changedInPlacePath)
        .pipe(changedInPlace())
        .pipe(livereload());
});

/**
 * changedInPlace task
 * Trigger live reload when file in wp change
 */
gulp.task('copyMaterialLite', function(){
    return gulp.src([
            'node_modules/material-design-lite/material.min.css',
            'node_modules/material-design-lite/material.min.css.map',
            'node_modules/material-design-lite/material.min.js.map',
            'node_modules/material-design-lite/material.min.js',
        ])
        .pipe(gulp.dest('public/assets/vendor/material-design-lite'));
});

/**
 * watch task
 * Watches js changes
 * It will call scripts task every time some file is changed in js folder
 */
gulp.task('watch', function(){
    livereload.listen(); // Start livereload and listen
    gulp.watch(scriptsPath, [scriptsTask]);
    gulp.watch(scssPath, [scssTask]);
    gulp.watch(changedInPlacePath, [changedInPlaceTask]);
});

/**
 * Global list of tasks to run when in console we type gulp
 */
gulp.task('default', [scriptsTask, scssTask, 'copyMaterialLite','watch']);