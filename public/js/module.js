$(document).ready(function () {
    $('.dupa-triggerable').on('click', function (e) {
        e.preventDefault();
        alert(1);
        return false;
    });
});