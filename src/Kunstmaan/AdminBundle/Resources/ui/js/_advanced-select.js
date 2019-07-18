var kunstmaanbundles = kunstmaanbundles || {};

kunstmaanbundles.advancedSelect = (function (window, undefined) {

    var init;

    init = function () {
        $('.js-advanced-select').select2({
            templateResult: function (option) {
                if (!option.element) {
                    return option.text;
                }

                var element = $(option.element);

                if (element.css('display') === 'none') {
                    return false;
                }

                return option.text;
            }
        });
    };

    return {
        init: init
    };

})(window);
