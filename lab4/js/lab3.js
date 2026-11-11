$.fx.off = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
let enlargedA = false;

$('#lab3-demo #anim-a').on('click', function () {
    enlargedA = !enlargedA;

    $(this)
        .attr('aria-pressed', String(enlargedA))
        .stop(true, false)
        .animate({
            width: enlargedA ? 240 : 160,
            height: enlargedA ? 130 : 90
        }, 300);
});


const buttonB = $('#lab3-demo #anim-b');
let hoveredB = false;
let focusedB = false;

function updateB() {
    const enlarged = hoveredB || focusedB;

    buttonB.stop(true, false).animate({
        width: enlarged ? 220 : 160,
        height: enlarged ? 120 : 90
    }, 300);
}

buttonB.on({
    mouseenter: function () { hoveredB = true; updateB(); },
    mouseleave: function () { hoveredB = false; updateB(); },
    focus: function () { focusedB = true; updateB(); },
    blur: function () { focusedB = false; updateB(); }
});




let stepsC = 0;
const statusC = $('#lab3-demo #steps-c');

$('#lab3-demo #anim-c').on('click', function () {
    if ($(this).is(':animated') || stepsC >= 5) return;

    stepsC++;
    statusC.text('Liczba kroków C: ' + stepsC);

    $(this).animate({
        width: 160 + stepsC * 20,
        height: 90 + stepsC * 10
    }, 300);
});

$('#lab3-demo #reset-ac').on('click', function () {
    $('#lab3-demo #anim-a, #lab3-demo #anim-c')
        .stop(true, false)
        .css({ width: 160, height: 90 });

    enlargedA = false;
    $('#lab3-demo #anim-a').attr('aria-pressed', 'false');

    stepsC = 0;
    statusC.text('Liczba kroków C: 0');
});

$(function () {
    const $checkServer = $("#lab3-demo #check-server");
    const $serverResult = $("#lab3-demo #server-result");

    $checkServer.on("click", function () {
        $serverResult.text("Ładowanie...");
        $checkServer.prop("disabled", true);

        $.ajax({
            url: "status.php",
            method: "GET",
            dataType: "text",
            timeout: 5000
        })
            .done(function (response) {
                $serverResult.text(response);
            })
            .fail(function () {
                $serverResult.text(
                    "Nie udało się połączyć z serwerem. Spróbuj ponownie."
                );
            })
            .always(function () {
                $checkServer.prop("disabled", false);
            });
    });
});