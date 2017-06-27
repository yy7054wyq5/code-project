var gulp = require('gulp')
var connect = require('gulp-connect')
var inject = require('gulp-inject')
var less = require('gulp-less')
var plumber = require('gulp-plumber')
var sourcemaps = require('gulp-sourcemaps')
var autoprefixer = require('gulp-autoprefixer')
var htmlmin = require('gulp-htmlmin')
var templateCache = require('gulp-angular-templatecache')
var ngAnnotate = require('gulp-ng-annotate')
var del = require('del')
var uglify = require('gulp-uglify')
var csso = require('gulp-csso')
var useref = require('gulp-useref')
var gulpif = require('gulp-if')
var revReplace = require('gulp-rev-replace')
var rev = require('gulp-rev')
var jshint = require('gulp-jshint')
var packageJSON  = require('./package')
var jshintConfig = packageJSON.jshintConfig

// 防止错误打断进程
var plumberOpt = {
  errorHandler: function (err) {
    console.log(err.toString())
    this.emit('end')
  }
}

/**
 * 启动开发环境服务器
 */
gulp.task('serve', function () {

  connect.server({
      root: ['.tmp','node_modules','src'],
      host: 'appbuilder.dev.com',
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

  // 监听文件变动并刷新
  gulp.watch(['src/less/*.less'], ['less'])
  gulp.watch(['src/view/*.html','src/view/**/*.html','src/js/*.js'], ['partials','inject'])

});


/**
 * copy
 */
gulp.task('copyimg',function () {
  var target1 = gulp.src('src/img/*.*')
  var target2 = gulp.src('src/img/footer/*.*')
  target1
    .pipe(gulp.dest('app/img'))
  target2
    .pipe(gulp.dest('app/img/footer'))
});

/**
 * 插入脚本和式样
 */

gulp.task('inject',['partials'],function () {//与页面上的inject相对应
  var target = gulp.src('src/index.html')
  var source = gulp.src([
    'src/js/md5.js',
    'src/js/app.js',
    'src/js/*.js',
    'src/css/*.css'
    ], {read: false})
  var injectSource = gulp.src('.tmp/templates.js')

  return target
    .pipe(inject(source, {ignorePath: ['.tmp','src']}))
    .pipe(inject(injectSource, {starttag: '<!-- inject:partials -->',ignorePath: '.tmp'}))
    .pipe(gulp.dest('.tmp'))
    .pipe(connect.reload())

});

/**
 * JS检查
 */
gulp.task('lint', function() {
  return gulp.src(['src/js/*.js'])
    .pipe(jshint(jshintConfig))
    .pipe(jshint.reporter('default'));
});

/**
 * 编译less
 */

gulp.task('less', function () {
  var target = gulp.src('src/less/app.less')
  var source = gulp.src([
    '!src/less/app.less',
    'src/less/*.less'
    ])

  return target
    .pipe(plumber(plumberOpt))
    .pipe(sourcemaps.init())
    .pipe(inject(source, {ignorePath: 'src', relative: true}))
    .pipe(less())
    .pipe(autoprefixer())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('src/css'))
    .pipe(connect.reload())

});

/**
 * 模版缓存至template.js
 */

gulp.task('partials', function () {
  return gulp.src(['!src/*.html', 'src/view/**/*.html','src/view/*.html'])
    .pipe(htmlmin({collapseWhitespace: true}))
    .pipe(templateCache({ module: 'appBuilder' }))
    .pipe(gulp.dest('.tmp'))
});

/**
 * 编译
 */

gulp.task('html',['favicon','copyimg'], function () {
  var injectSource = gulp.src('.tmp/templates.js')

  return gulp.src('.tmp/*.html')
    .pipe(inject(injectSource, {starttag: '<!-- inject:partials -->'}))
    .pipe(useref())//与页面上的build注释相对应
    .pipe(gulpif('**/*.js', ngAnnotate()))
    .pipe(gulpif('**/*.js', uglify()))
    .pipe(gulpif('**/*.js', rev()))
    .pipe(gulpif('**/*.css', csso()))
    .pipe(gulpif('**/*.css', rev()))
    .pipe(gulpif('**/*.html', htmlmin({collapseWhitespace: true})))
    .pipe(revReplace())
    .pipe(gulp.dest('app'))
});

gulp.task('favicon', function () {
  return gulp.src('src/favicon.ico')
    .pipe(gulp.dest('app'))
});

/**
 * 编译
 */

gulp.task('build', ['clean', 'less','partials','inject','html']);

/**
 * 清空
 */

gulp.task('clean', function () {
  return del(['app/*.*','app/**/*.*','app/**/**/*.*']);
});

/**
 * 生产环境服务器
 */

gulp.task('serve:build', function () {
  connect.server({
      root: ['app'],
      host: 'appbuilder.build',
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
gulp.task('dev',['serve','less','inject']);
// http://appbuilder.dev/#CcYgnu/index
/**
 * 生产环境
 */
gulp.task('build-serve',['serve:build','build']);
// http://appbuilder.build/#CcYgnu/index