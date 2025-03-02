const mix = require('laravel-mix');

// JavaScript files
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
   .js('resources/js/common_functions.js', 'public/js')
   .js('resources/js/course-content.js', 'public/js')
   .js('resources/js/course/show-course.js', 'public/js/course')
   .js('resources/js/course/course_curriculum.js', 'public/js/course')
   .js('resources/js/profile.js', 'public/js')

   // CSS files
   .postCss('resources/css/app.css', 'public/css', [
     require('@tailwindcss/postcss'),
     require('autoprefixer'),
   ])
   .postCss('resources/css/course_instruction.css', 'public/css', [
     require('@tailwindcss/postcss'),
     require('autoprefixer'),
   ])
   .postCss('resources/css/text.css', 'public/css', [
     require('@tailwindcss/postcss'),
     require('autoprefixer'),
   ])

   // SCSS files
   .sass('resources/sass/responsive.scss', 'public/css', {
     implementation: require('sass'),
     sassOptions: {
       includePaths: ['node_modules'],
     },
   })

   // Webpack configuration
   .webpackConfig(require('./webpack.config'));