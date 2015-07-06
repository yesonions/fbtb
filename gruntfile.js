module.exports = function (grunt) {
    'use strict';
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-bowercopy');

    var userConfig = require('./build.config.js'),
        taskConfig = {
        pkg: grunt.file.readJSON("package.json"),
        meta: {
            banner: '/**\n' +
                    ' * <%= pkg.name %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %>\n' +
                    ' * <%= pkg.homepage %>\n' +
                    ' *\n' +
                    ' * Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
                    ' * Licensed <%= pkg.licenses.type %> <<%= pkg.licenses.url %>>\n' +
                    ' */\n'
        },
        changelog: {
            options: {
                dest: 'CHANGELOG.md',
                template: 'changelog.tpl'
            }
        },
        bowercopy: {
            options: {
                clean: false,
                srcPrefix: 'lib'
            },
            lib: {
                options: {
                    destPrefix: 'build/lib'
                },
                files: {
                    'durandal/': 'durandal/js/',
                    'moment/': 'moment/min/moment.min.js',
                    'require/': 'requirejs/require.js',
                    'require/require-text.js': 'requirejs-text/text.js',
                    'lodash/': 'lodash/lodash*.js',
                    'knockout/': 'knockout.js/knockout.js',
                    'knockstrap/': 'knockstrap/build/knockstrap.js',
                    'bootstrap/': 'bootstrap-sass/assets/javascripts/bootstrap*.js',
                    'jquery/': 'jquery/jquery*.*',
                    'ko.plus/': 'ko.plus/dist/*'
                }
            },
            font: {
                options: {
                    destPrefix: 'build/font'
                },
                files: {
                    '/': 'fontawesome/fonts/'
                }
            }
        },
        clean: [
            '<%= build_dir %>',
            '<%= compile_dir %>',
            '<%= package_dir %>'
        ],
        copy: {
            base: {
                src: ['**/*', '!sass/'],
                dest: 'build/',
                cwd: 'src/',
                expand: true
            }
            // lib: {
            //     src: ['**/*'],
            //     dest: 'build/lib',
            //     cwd: 'lib/',
            //     expand: true
            // }
        },
        uglify: {
            compile: {
                options: {
                    banner: '<%= meta.banner %>'
                },
                files: {
                    '<%= concat.compile_js.dest %>': '<%= concat.compile_js.dest %>'
                }
            }
        },
        jshint: {
            src: ['<%= app_files.js %>'],
            test: ['<%= app_files.jsunit %>'],
            gruntfile: ['Gruntfile.js'],
            options: {
                curly: true,
                immed: true,
                newcap: true,
                noarg: true,
                sub: true,
                boss: true,
                eqnull: true
            },
            globals: {}
        },
        compass: {
            dist: {
                options: {
                    sassDir: 'sass',
                    cssDir: './build/'
                }
            }
        },
        watch: {
            css: {
                files: '**/*.scss',
                tasks: ['compass']
            }
        }
    };

    grunt.initConfig(grunt.util._.extend(taskConfig, userConfig));


    grunt.registerTask('default', ['build','compass']);
    grunt.registerTask('build', ['copy', 'bowercopy']);
    grunt.registerTask('publish', []);

};