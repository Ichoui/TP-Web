$(function () {
    var $depart = $('#depart');
    var $arrivee = $('#arrivee');
    var $date = $('#date');
    var $nbColis = $('#nbColis');

    function error(champ) {
        champ.css({"border-color": "red"});

    }
    function resetError() {
        $depart.css({"border-color": "initial"});
        $arrivee.css({"border-color": "initial"});
        $date.css({"border-color": "initial"});
        $nbColis.css({"border-color": "initial"});
    }

    function verifier(champ) {
        if (champ.val() === "") {
            console.log("Le champ " + champ["0"].attributes["0"].textContent.toUpperCase() + " doit être rempli");
            error(champ);
            return false;
        }
    }

    function isString(champ) {

    }

    function isNotNull(champ) {
        if (champ.val() <= 0) {
            console.log("Le champ " + champ["0"].attributes["0"].textContent.toUpperCase() + " doit être strictement supérieur à 0");
            error(champ);
            return false;
        }
    }

    function compareVille(depart, arrivee) {
        if (depart.val() === arrivee.val()) {
            console.log("La ville de départ et la ville d'arrivée sont les même.");
            error(depart);
            error(arrivee);
            return false;
        }
    }

    function compareDate(day) {
        var dayVal = day.val();
        var daySelected = new Date(dayVal);
        var today = new Date();

        if (daySelected < today) {
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();

            if (dd < 10) {
                dd = '0' + dd
            }
            if (mm < 10) {
                mm = '0' + mm
            }

            today = yyyy + "-" + mm + "-" + dd;
            console.log("Date du jour : " + today);
            console.log("Date select : " + dayVal);

            error(day);
            console.log("Il faut choisir une date d+1");
            return false;
        }

    }

    $('#submit-trajet').on('click', function (e) {
        e.preventDefault();

        resetError();

        isString($depart);
        isString($arrivee);

        verifier($depart);
        verifier($arrivee);
        verifier($date);
        verifier($nbColis);

        compareVille($depart, $arrivee);
        compareDate($date);
        isNotNull($nbColis);

    });
});