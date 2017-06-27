'ues strict';
module.exports = function(grunt) {
  require('load-grunt-tasks')(grunt);
  //任务配置
  grunt.initConfig({
    //config:config;
      pkg: grunt.file.readJSON('package.json'),
      jshint: {
          all: ['js/modules/*.js','js/page.js']
      },
      concat: {
          options: {
            stripBanners: true,
            // banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' +
            //   '<%= grunt.template.today("yyyy-mm-dd") %> */',
            banner: ''
          },
          public: {
                  files: {
                        'js/loongjoy.js': ['js/modules/*.module.js'],
                        'js/main.js': [
                          'js/hack_start.js',
                          'js/page/main.js',
                          'js/page/index.js',
                          'js/page/*.js',
                          'js/hack_end.js'
                        ]
                  },
          },
      },
      copy: {
        main: {
          expand: true,
          cwd: 'js/',
          src: ['loongjoy.js','main.js'],
          dest: '../../public/dist/js/',
          flatten: true,
          filter: 'isFile',
        },
      },
      uglify: {
        options: {
          banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
        },
        build: {
            files: {
                '../../public/dist/js/main.min.js': ['js/main.js',],//全局文件以及页面调用JS
                '../../public/dist/js/loongjoy.min.js': ['js/loongjoy.js']
            }
        }
      },
      autoprefixer: {
          options: {
            // Task-specific options go here. 
              browserslist:['last 2 versions','ie8','ie9'],
          },
          css : {
                src : [
                  "css/main.css",
                  "css/loongjoy.css"
                ]
          }
      },
      cssmin: {
          options: {
              shorthandCompacting: false,
              roundingPrecision: -1
          },
          build: {
              files: {
                '../../public/dist/css/assist.min.css': ['css/assist.css'],
                '../../public/dist/css/main.min.css': ['css/main.css'],
                '../../public/dist/css/loongjoy.min.css': ['js/loongjoy.css']
              }
          }
      },
      watch: {
          configFiles:{
              files:['Gruntfile.js']
          },
          files: [
            'js/*.js',
            'less/*.less',
            'js/modules/*.js',
            'js/modules/*.module.js',
            'js/modules/*.module.less',
            'js/modules/*.less',
            'js/page/*.js'
          ],
          tasks: ['default'],
          options: {
              livereload: true
          }
      },
      less: {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
          development: {
              files: {
                "css/assist.css": "less/assist.less",
                "css/main.css": "less/main.less",
                "js/loongjoy.css": "js/modules/a_loongjoy.module.less"
              }
            }
      },
      sprite:{
            all: {
              src: ['../../public/dist/img/sprite/*.png'],
              dest: '../../public/dist/img/sprite/spritesheet.png',
              destCss: '../../public/dist/img/sprite/sprites.css'
            }
      },
      // filerev: {
      //     options: {
      //       algorithm: 'md5',
      //       length: 8
      //     },
      //     js: {
      //       src: '../../public/dist/js/*.min.js'
      //     }
      //   }
    });

  //注册任务
  grunt.registerTask('js',['jshint']);
  grunt.registerTask('default',['less','autoprefixer','cssmin','concat','jshint','uglify','copy']);
  grunt.registerTask('grunt-spritesmith');
};

