/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
require('./Main');
// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
	
var $ = require( 'jquery' );
var DataTable = require( 'datatables.net' )(window, $);
 
let table = new DataTable('#myTable', {
    // config options...
});

