var gulp  = require('gulp'),
    jshint = require('gulp-jshint'),
    concat = require('gulp-concat'),
    replace = require('gulp-replace'),
    gutil = require('gulp-util');

var environment = gutil.env.type || "development";
var backendUrl= "http://api.blog",
    frontendUrl= "http://blog",
    productionBackendUrl= "http://backend.jeancarlomachado.com.br",
    productionFrontendUrl= "http://jeancarlomachado.com.br";


// create a default task and just log a message
gulp.task('default', ['build-js', 'build-html', 'build-css'], function() {
    gutil.log("Environment: " +  environment);
});

gulp.task('build-js', function() {
	return gulp.src('src/js/**/*.js')
		.pipe(concat('main.js'))
		.pipe(replace('BLOG_BACKEND_URL', (environment === 'production') ? productionBackendUrl : backendUrl ))
		.pipe(replace('BLOG_FRONTEND_URL', (environment === 'production') ? productionFrontendUrl : frontendUrl ))
		.pipe(gulp.dest('dist/'));
});

gulp.task('build-css', function() {
	return gulp.src('src/css/**/*.css')
		.pipe(gulp.dest('dist/'));
});

gulp.task('build-html', function() {
	return gulp.src('src/**/*.html')
		.pipe(gulp.dest('dist/'));
});

gulp.task('jshint', function() {
	return gulp.src('src/js/**/*.js')
		.pipe(jshint())
		.pipe(jshint.reporter('jshint-stylish'));
});

gulp.task('watch', function() {
	gulp.watch('src/js/**/*.js', ['jshint', 'build-js']);
	gulp.watch('src/**/*.html', ['build-html']);
	gulp.watch('src/css/**/*.css', ['build-css']);
});
