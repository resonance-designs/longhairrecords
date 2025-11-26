/**'
 * Gulp file to concatenate and minify CSS.
 *
 * @author Richard Bakos - Resonance Designs <info@resonancedesigns.dev>
 * @version 2.1.2
 * @since 11-25-2025
 * @copyright Copyright © 2025 Resonance Designs Ltd. All rights reserved.
 * @package longhairrecords
 * @category WordPress Theme Development
 * @description This is a simple Gulp file that concatenates and minifies CSS files into one single file named styles.min.css. It also includes a watch task to automatically recompile when any of the source files change.
 * @dependencies Node.js ^v16.13.0 or higher
 * @requires npm ^8.1.0 or higher
 * @requires gulp ^5.0.1
 * @requires gulp-concat ^2.6.1
 * @requires gulp-clean-css ^4.3.0
 * @requires gulp-uglify ^3.0.2
 * @link https://github.com/resonance-designs/longhairrecords
 *
 */

const gulp = require('gulp');
const concat = require('gulp-concat');
const cleanCSS = require('gulp-clean-css');

// Manually specify the order of CSS files
const cssFrontFiles = [
    'wp-content/themes/longhairrecords/css/custom.css'
];

const cssAdminFiles = [
    'wp-content/themes/longhairrecords/css/admin-menu.css'
];

// Task: concat & minify CSS
function frontCSS() {
    return gulp.src(cssFrontFiles)
        .pipe(concat('styles.min.css'))
        .pipe(cleanCSS({ compatibility: 'ie8' }))
        .pipe(gulp.dest('wp-content/themes/longhairrecords/css'));
}

function adminCSS() {
    return gulp.src(cssAdminFiles)
        .pipe(concat('admin.min.css'))
        .pipe(cleanCSS({ compatibility: 'ie8' }))
        .pipe(gulp.dest('wp-content/themes/longhairrecords/css'));
}

// Watch task
function watchFiles() {
    gulp.watch(cssFrontFiles, frontCSS);
    gulp.watch(cssAdminFiles, adminCSS);
}

// Default: build all once, then watch
exports.default = gulp.series(
    gulp.parallel(frontCSS, adminCSS),
    watchFiles
);

// Export individual tasks if needed
exports.frontcss = frontCSS;
exports.admincss = adminCSS;
exports.watch = watchFiles;
