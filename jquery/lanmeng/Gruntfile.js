'ues strict';
module.exports = function(grunt) {
  require('load-grunt-tasks')(grunt);
  //任务配置
  grunt.initConfig({
    //config:config;
      pkg: grunt.file.readJSON('package.json'),
      jshint: {
          all: ['public/js/loongjoy.*.js']
      },
      concat: {  
          options: { 
              banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
          },  
          dist: {  
            src: ['resources/assets/js/mine/app.js','resources/assets/js/mine/*.js'],
            dest: 'resources/assets/js/mine.js'//合并文件
          }  
      }, 
      uglify: {
        options: {
          banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
        },
        my_target: {
              files: {
                'public/js/loongjoy.js': ['public/js/loongjoy.bak.js'],
                'public/js/oconfirm.js': ['resources/assets/js/oconfirm.js'],//订单
                'public/js/mine.js': ['resources/assets/js/mine.js']//个人中心
              }
        }
      },
      cssmin: {
          options: {
              shorthandCompacting: false,
              roundingPrecision: -1
          },
          build: {
              files: {
                  'public/css/loongjoy.css': ['public/css/loongjoy.bak.css'],
                  'public/css/mine.css': ['public/css/mine.bak.css'],
                  'public/css/bootstrap.min.css': ['public/css/bootstrap.css']
              }
          }
      },
      watch:{
          start:{
              files:[
                'public/css/loongjoy.bak.css',
                'public/css/bootstrap.css',
                'public/js/loongjoy.bak.js',
                'public/css/mine.bak.css',
                'resources/assets/js/*.js',
                'resources/assets/js/mine/*.js'
                ],
              tasks:['default'],
              options: {
                    livereload: true
              }
          }
      }
    });

  //注册任务
  grunt.registerTask('js',['jshint']);
  grunt.registerTask('default',['concat','cssmin','uglify']);

};