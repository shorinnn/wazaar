var gulp = require('gulp');
var concatCss = require('gulp-concat-css');
var minifycss = require('gulp-minify-css');
var rename = require('gulp-rename');
var rev = require('gulp-rev');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var revOutdated     = require('gulp-rev-outdated');
var rimraf          = require('rimraf');
var through         = require('through2');
var path            = require('path'); 

gulp.task('js', function(){
    /**** Separate files ***********/
//    gulp.src('./public/js/main.js')
//    .pipe(uglify())
//    .pipe(gulp.dest('./public/assets/js'))
//    .pipe(rev())
//    .pipe(gulp.dest('./public/assets/js'))
//    .pipe(rev.manifest('./public/assets/rev-manifest.json',{ merge:true }))
//    .pipe(gulp.dest(''));
    
    /**** / Separate files ***********/
    
    /****** core files ***************/
    return gulp.src( [
        './public/plugins/zero-clipboard/ZeroClipboard.min.js',
        './public/js/jquery.bootstrap-growl.min.js',
        './public/js/lang/parsley/en.js',
        './public/js/lang/parsley/ja.js',
        './public/js/parsley.min.js',
        './public/js/forms.js',
        './public/js/validations.js',
        './public/js/courses.js',
        './public/js/cocoriumTracker.js',
        './public/js/Sortable.min.js',
        './public/js/pluralize.js',
        './public/js/jquery.mousewheel.js',
        './public/js/jquery.jscrollpane.min.js',
        './public/js/main.js',
        './public/js/messages.js',
        './public/js/slick.js',
        './public/js/lang/en.js',
        './public/js/lang/ja.js',
        './public/js/messages.js',
        './public/js/lang/en.js',
        './public/js/jquery.tinycarousel.js',
        './public/js/jquery.videobackground.js',
        './public/js/bootstrap-datepicker.js',
        './public/js/mailcheck.min.js',
        './public/js/bootbox.js'
        ] )
    .pipe(uglify())
    .pipe(concat('core.min.js'))
    .pipe(gulp.dest('./public/js-assets'))
    .pipe(rev())
    .pipe(gulp.dest('./public/js-assets'))
    .pipe(rev.manifest('./public/assets/rev-manifest.json',{ merge:true }))
    .pipe(gulp.dest(''));
    
});

gulp.task('css', function(){
    return gulp.src(['./public/css/*.css', './plugins/slider/css/slider.css' ])
        .pipe(concatCss("all.css"))
        .pipe(minifycss())
        .pipe(rename('all.min.css'))
        .pipe(gulp.dest('./public/css-assets'))
        .pipe(rev())
        .pipe(gulp.dest('./public/css-assets'))
        .pipe(rev.manifest('./public/assets/rev-manifest.json',{
             merge:true
        }))
        .pipe(gulp.dest(''));
//        .pipe(revDel( { dest:'./public/assets/css' } ) );
});

function cleaner() {
    return through.obj(function(file, enc, cb){
        rimraf( path.resolve( (file.cwd || process.cwd()), file.path), function (err) {
            if (err) {
                this.emit('error', new gutil.PluginError('Cleanup old files', err));
            }
            this.push(file);
            cb();
        }.bind(this));
    });
}

gulp.task('clean', [ 'js', 'css' ], function() {
    gulp.src( ['./public/css-assets/*.*'], {read: false})
        .pipe( revOutdated(1) ) // leave 1 latest asset file for every file name prefix. 
        .pipe( cleaner() );
    gulp.src( ['./public/js-assets/*.*'], {read: false})
        .pipe( revOutdated(1) ) // leave 1 latest asset file for every file name prefix. 
        .pipe( cleaner() );
    gulp.src( ['./public/assets/**/*.*'], {read: false})
        .pipe( revOutdated(1) ) // leave 1 latest asset file for every file name prefix. 
        .pipe( cleaner() );
    return;
});

gulp.task('default', function() {
    gulp.run('clean');
    
//    gulp.watch( [ './public/css/*.css', './public/js/*.js' ], function(){
//        gulp.run('clean');
//    });
//    
//    gulp.watch('./public/js/*.js', function(){
//        gulp.run( 'js', function(){
//            gulp.run('clean');
//        });
//    });
});