(function($) {
	'use strict';

    $(document).ready(function() {
        $(document).on('focus', '.inboxino-persian-datepicker', function() {
            $(this).pDatepicker({
                initialValue : false,
                autoClose: true,
                formatter: function(timestamp) {
                    const date = new Date(timestamp);
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                },
            });
        });
    });

})(jQuery);
