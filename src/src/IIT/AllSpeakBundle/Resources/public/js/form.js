import moment from 'moment/moment'

const Form = {
    init: function() {
        const $datePickers = $('.js-datepicker');
        $datePickers.each(function () {
            const dp = $(this);
            const name = dp.attr('name');
            dp.attr('name', name+'_tmp');
            const hiddenInput = $('<input>').attr({
                type: 'hidden',
                name: name
            });
            dp.after(hiddenInput);
            dp.datepicker({
                format: {
                    toDisplay: function (date, format, language) {
                        var d = new Date(date);
                        hiddenInput.val(moment(d).format('YYYY-MM-DD'));
                        return moment(d).format('MM-YYYY');
                    },
                    toValue: function (date, format, language) {
                        var d = /\d{2}-\d{4}/.test(date) ? moment('01-' + date, 'DD-MM-YYY') : new Date(d);
                        return d;
                    }
                },
                startView: "months",
                minViewMode: "months",
                autoclose: true,
                endDate: new Date(),
                language: "it"
            });
        });
    }
};

export default Form;