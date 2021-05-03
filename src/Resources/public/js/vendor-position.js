(function ($) {
    'use strict';

    $.fn.extend({
        moveVendor(positionInput) {
            const vendorRows = [];
            const element = this;

            element.api({
                method: 'PUT',
                beforeSend(settings) {
                    /* eslint-disable-next-line no-param-reassign */
                    settings.data = {
                        vendors: vendorRows,
                        _csrf_token: element.data('csrf-token'),
                    };

                    return settings;
                },
                onSuccess() {
                    window.location.reload();
                },
            });

            positionInput.on('input', (event) => {
                const input = $(event.currentTarget);
                const vendorId = input.data('id');
                const row = vendorRows.find(({ id }) => id === vendorId);

                if (!row) {
                    vendorRows.push({
                        id: vendorId,
                        position: input.val(),
                    });
                } else {
                    row.position = input.val();
                }
            });
        }
    });
})(jQuery);

(function($) {
    $(document).ready(function () {
        $('.odiseo-update-vendors').moveVendor($('.odiseo-vendor-position'));
    });
})(jQuery);
