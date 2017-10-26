// Initialize Firebase
var config = {
    apiKey: "AIzaSyCPJyDJltGTxoqxa28ctL_b54qQkWQ8ydU",
    authDomain: "mybox-e8c92.firebaseapp.com",
    databaseURL: "https://mybox-e8c92.firebaseio.com",
    storageBucket: "mybox-e8c92.appspot.com",
    messagingSenderId: "538405558234"
};
firebase.initializeApp(config);

firebase.database().ref('Films').on('value', function(snapshot) {
    var index = 1 ;

    listFilm    = snapshot.val() ;
    containerFilm = $('#container-films') ;
    containerFilm.html('') ;
    $.each(listFilm, function(key,val) {
        console.log(val) ;
        containerFilm.append('<p>' +
            '<span id="film-type-'+index+'">'+val.Type+'</span> ' +
            '<span id="film-titre-'+index+'">'+val.Titre+'</span> ' +
            '(<span id="film-vote-'+index+'">'+val.Vote+'</span>)' +
            '<a id="film-lien-'+index+'" href="'+val.Lien+'"  class="">lien</a>' +
            '<button onClick="sendClickPlus('+index+', \''+key+'\')" class="btn-plus btn-plus-'+index+'">+</button>' +
            '<button onClick="sendClickMoins('+index+', \''+key+'\')" class="btn-moins btn-moins-'+index+'">-</button>' +
            '<button onClick="sendClickDel('+index+', \''+key+'\')" class="btn-del btn-del-'+index+'">Supprimer</button><' +
            '/p>') ;
        index++ ;
    }) ;
});



Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

function sendClickPlus(index, key) {
    thisFilmTitre = $('#film-titre-'+index).html() ;
    thisFilmVote = $('#film-vote-'+index).html() ;
    thisFilmType = $('#film-type-'+index).html() ;
    thisFilmLien = $('#film-lien-'+index).attr('href') ;

    firebase.database().ref('Films/'+key).set({
        Titre : thisFilmTitre,
        Vote  : parseInt(thisFilmVote) +1,
        Lien : thisFilmLien,
        Type : thisFilmType
    });
}

function sendClickMoins(index, key) {
    thisFilmTitre = $('#film-titre-'+index).html() ;
    thisFilmVote = $('#film-vote-'+index).html() ;
    thisFilmType = $('#film-type-'+index).html() ;
    thisFilmLien = $('#film-lien-'+index).attr('href') ;

    firebase.database().ref('Films/'+key).set({
        Titre : thisFilmTitre,
        Vote  : parseInt(thisFilmVote) -1,
        Lien : thisFilmLien,
        Type : thisFilmType
    });
}

function sendClickDel(index, key) {
    console.log(index, key) ;
    firebase.database().ref('Films/'+key).set({}) ;
}

function addFilm(titre, lien, type) {
    firebase.database().ref('Films').push({
        Titre : titre,
        Vote  : 0,
        Lien : lien,
        Type : type
    });
}

function getNumberFilm() {
    firebase.database().ref('Films').on('value', function(snapshot) {
        listFilm = snapshot.val();
    }) ;

    return Object.size(listFilm) ;

}

jQuery(function ($) {
    $('#btn-ajout-film').on('click', function(){
        var inputTitreFilm  = $('#ajout-titre-film') ;
        var inputLienFilm   = $('#ajout-lien-film') ;
        var inputTypeFilm   = $('#ajout-type-film') ;
        var errorMessage    = $('.error-message') ;
        var isOkTitre       = true ;
        var isOkType        = true ;
        var isOkLien        = true ;

        errorMessage.empty() ;

        // Test titre
        if (inputTitreFilm.val() == '') {
            inputTitreFilm.css('border','1px solid red') ;
            inputTitreFilm.parent().append('<span class="error-message">Renseignez un titre pour le film</span>');
            isOkTitre = false ;
        }

        //Test type
        if (inputTypeFilm.val() == null) {
            inputTypeFilm.css('border','1px solid red') ;
            inputTypeFilm.parent().append('<span class="error-message">Renseignez un type pour le film</span>');
            isOkType = false ;
        }

        // Test lien
        if (inputLienFilm.val() == '') {
            inputLienFilm.css('border','1px solid red') ;
            inputLienFilm.parent().append('<span class="error-message">Renseignez un lien pour le film</span>');
            isOkLien = false ;
        }

        console.log(isOkTitre, isOkType, isOkLien) ;

        if (isOkLien && isOkTitre && isOkType) {
            inputTitreFilm.css('border','1px solid gray') ;
            inputTypeFilm.css('border','1px solid gray') ;
            inputLienFilm.css('border','1px solid gray') ;
            addFilm(inputTitreFilm.val(), inputLienFilm.val(), inputTypeFilm.val())
        } else {
            console.log('Au moins 1 ,\'est pas bon') ;
        }

    }) ;
}) ;
