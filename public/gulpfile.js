
var gulp = require('gulp'); // Собственно gulp
var sass = require('gulp-sass'); // Sass-компилятор

var postcss = require('gulp-postcss'); // Пост-обработка CSS
var minifyCSS = require('gulp-csso'); // CSS минификатор
var autoprefixer = require('autoprefixer'); // Добавление вендорных префиксов
var sourcemaps = require('gulp-sourcemaps'); // карты исходного кода

var concat = require('gulp-concat'); // объединение набора файлов в один

var livereload = require('gulp-livereload');


/****************************************************
*********************** SASS ************************
****************************************************/

gulp.task( 'sass', function() {
	// Настройки для вендорных префиксов
	var plugins = [
		autoprefixer({
			browsers: ['last 4 versions', 'ie >= 10', 'iOS >= 8']
		}),
	];
	return gulp.src( 'sass/screen.scss' )
		.pipe( sourcemaps.init() )
		.pipe( sass() )
		.pipe( postcss( plugins ) )
		.pipe( sourcemaps.write( '.' ) )
		.pipe( gulp.dest( 'css' ) )
		.pipe(livereload());
});

gulp.task('reload', function() {
	livereload();
});

gulp.task( 'watch', function() {
	livereload.listen();
	gulp.watch( 'sass/**/*.scss', ['sass'] );
	gulp.watch( 'js/**/*.js', ['reload'] );
});
