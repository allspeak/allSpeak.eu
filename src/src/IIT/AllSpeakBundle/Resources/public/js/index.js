import Bootstrap from 'bootstrap/dist/css/bootstrap.css';
import mainCss from '../css/main.css';
import datepicker from 'bootstrap-datepicker/dist/js/bootstrap-datepicker';
import datepickerIt from 'bootstrap-datepicker/js/locales/bootstrap-datepicker.it';
import datepickerCss from 'bootstrap-datepicker/dist/css/bootstrap-datepicker.css';
import Form from './form';

import allSpeakLogo from "file-loader?emitFile=false!../img/allSpeakLogo.jpg";
import osrLogo from "file-loader?emitFile=false!../img/osrLogo.jpg";
import iitLogo from "file-loader?emitFile=false!../img/iitLogo.jpg";
import arislaLogo from "file-loader?emitFile=false!../img/arislaLogo.jpg";
import aislaLogo from "file-loader?emitFile=false!../img/aislaLogo.jpg";

$(document).ready(function() {
    Form.init();
});