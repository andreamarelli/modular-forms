
export function useTransitions() {

    // TODO: to be tested

    /**
     * Manage bar show/hide transitions
     */
    function beforeShowBar(el) {
        $(el).css("display", 'none');
    }
    function showBar(el, done) {
        $(el).slideDown(400, function () {
            $(this).css("display", 'block');
            done();
        });
    }
    function hideBar(el, done) {
        $(el).slideUp(400, function () {
            $(this).css("display", 'none');
            done();
        });
    }

    return {beforeShowBar, showBar, hideBar};
}
