/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
import $ from 'jquery';

$("#test-newlist").css('display', 'none')

$('#displayNewList').click(function() {
    if ($("#test-newlist").css('display') == 'none'){
        $("#test-newlist").css('display', '')
    }else {
        $("#test-newlist").css('display', 'none')
    }
})