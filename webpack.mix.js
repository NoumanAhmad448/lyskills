const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
*/

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/bootstrap.js', 'public/js')
    .js('resources/js/course_category.js', 'public/js')
    .js('resources/js/course_instruction.js', 'public/js')
    .js('resources/js/course_time_selection.js', 'public/js')
    .js('resources/js/course_title.js', 'public/js')
    .js('resources/js/main.js', 'public/js')
    .js('resources/js/users.js', 'public/js')
    .js('resources/js/edit_user.js', 'public/js')
    .js('resources/js/fade_out_msg.js', 'public/js')
    .js('resources/js/dashboard.js', 'public/js')
    .js('resources/js/target_ur_students.js', 'public/js')
    .js('resources/js/landing_page.js', 'public/js')
    .js('resources/js/price.js', 'public/js')
    .js('resources/js/promotion.js', 'public/js')
    .js('resources/js/message.js', 'public/js')
    .js('resources/js/admin_courses.js', 'public/js')
        
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .postCss('resources/css/course_instruction.css', 'public/css', [
        require('postcss-import')
    ])
    .postCss('resources/css/text.css', 'public/css', [
        require('postcss-import')
    ]).
        sass('resources/sass/responsive.scss', 'public/css')

    .webpackConfig(require('./webpack.config'));


