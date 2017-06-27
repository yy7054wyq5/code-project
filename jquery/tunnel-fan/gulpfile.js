var gulp = require('gulp')
var connect = require('gulp-connect')
var inject = require('gulp-inject')
var less = require('gulp-less')
var sourcemaps = require('gulp-sourcemaps')
var autoprefixer = require('gulp-autoprefixer')
var del = require('del')
var uglify = require('gulp-uglify')
var useref = require('gulp-useref')
var gulpif = require('gulp-if')
var revReplace = require('gulp-rev-replace')
var rev = require('gulp-rev')
var open = require('gulp-open')
var plumber = require('gulp-plumber')
var csso = require('gulp-csso')
/**
 * 启动开发环境服务器
 */

gulp.task('connect', function () {
  connect.server({
    root: ['.tmp', 'src'],
    host: 'localhost',
    port: 80,
    livereload: true,
    //代理请求
    middleware: function (connect, opt) {
      var Proxy = require('gulp-connect-proxy-with-headers')
      var proxy = new Proxy(opt);
      return [proxy];
    }
  });
});

/*
* 监听文件变动并刷新
*/

gulp.task('watch', function () {
  gulp.watch(['src/*.less'], ['less', 'inject']);
  gulp.watch(['src/*.html', 'src/*.js', 'src/modal/**/*.html', 'src/modal/**/*.js'], ['inject']);
});

/**
 * 向页面插入脚本、式样和模态框内容html
 */

gulp.task('inject', ['less'], function () { //与页面上的inject相对应
  var target = gulp.src('src/index.html');
  var source = gulp.src([
    'src/*.js',
    'src/modal/**/*.js',
    '.tmp/css/*.css'], {
      read: false
    });
  var html = gulp.src('src/modal/**/*.html');
  return target
    .pipe(inject(html, {
      starttag: '<!-- inject:footer:{{ext}} -->',
      transform: function (filePath, file) {
        // return file contents as string 
        return file.contents.toString('utf8')
      }
    }))
    .pipe(inject(source, {
      ignorePath: ['.tmp', 'src']
    }))
    .pipe(gulp.dest('.tmp'))
    .pipe(connect.reload())

});

/**
 * 编译less
 */

gulp.task('less', function () {
  var target = gulp.src('src/*.less')
  return target
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(less())
    .pipe(autoprefixer())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('.tmp/css'))
});

/*
* 静态文件转移
*/

gulp.task('assets', function () {
  gulp.src(['src/favicon.ico'])
    .pipe(gulp.dest('dist'));
  gulp.src('src/img/*.png')
    .pipe(gulp.dest('dist/img'));
  gulp.src('src/img/layer/*.png')
    .pipe(gulp.dest('dist/img/layer'));  
});

/**
 * 清空
 */

gulp.task('clean', function () {
  return del(['dist', '.tmp']);
});

/**
 * 生产环境服务器
 */

gulp.task('serve:build', function () {
  connect.server({
    root: ['dist'],
    host: 'localhost',
    port: 80,
    livereload: true,
    //代理请求
    middleware: function (connect, opt) {
      var Proxy = require('gulp-connect-proxy-with-headers')
      //opt.route = '/proxy';
      var proxy = new Proxy(opt);
      return [proxy];
    }
  })
});

/**
 * 开发模式
 */

gulp.task('dev', ['inject', 'connect', 'watch'], function () {
  gulp.src('.tmp')
    .pipe(open({ uri: 'http://localhost/#fan', app: 'chrome' }));
});

/**
 * 编译
 */
gulp.task('build', ['less', 'inject', 'assets'], function () {
  return gulp.src('.tmp/*.html')
    .pipe(useref()) //与页面上的build注释相对应
    .pipe(gulpif('**/*.js', uglify()))
    .pipe(gulpif('**/*.js', rev()))
    .pipe(sourcemaps.init())
    .pipe(gulpif('**/*.css', csso()))
    .pipe(sourcemaps.write())
    .pipe(gulpif('**/*.css', rev()))
    .pipe(revReplace())
    .pipe(gulp.dest('dist'))
});

/**
 * 生产环境
 */
gulp.task('build-serve', ['serve:build', 'html']);