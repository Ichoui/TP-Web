$(function() {
    // RATP
    function treatResult(donnees) {
        var horaire = donnees.result.schedules;
        var message;

        for (i = 0; i < horaire.length; i++) {
            // récupérer le champ message pour chaque rame envoyée par l'Api
            message = horaire[i].message;
            $('#infosRatp').append(message + '<br>');
        }

        setTimeout(60000, RatpWS);
    }

    function RatpWS() {
        $.ajax({
            type: 'GET',
            url: 'https://api-ratp.pierre-grimaud.fr/v3/schedules/metros/8/opera/A',
            datatype: 'jsons',
            success: function (data) {
                console.log(data);
                treatResult(data);
            },
            error: function (error) {
                console.log(error);
            }
        })
    }

    $('#liste').on('click', function () {
        RatpWS();
    });
});