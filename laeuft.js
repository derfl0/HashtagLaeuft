$(document).ready(function () {
    $('a.laeuft').click(function (e) {
        e.preventDefault();
            var text = e.target.text;
            var url = $(this).prop('href');
            var anchor = $(this);
            $.ajax({
                url: url
            });
            anchor.toggleClass('laeuft_bei_dir');
    });
});