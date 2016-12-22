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
        containerFilm.append('<p><span id="film-titre-'+index+'">'+val.Titre+'</span> (<span id="film-vote-'+index+'">'+val.Vote+'</span>)<button onClick="sendClickPlus('+index+', \''+key+'\')" class="btn-plus btn-plus-'+index+'">+</button><button onClick="sendClickMoins('+index+', \''+key+'\')" class="btn-moins btn-moins-'+index+'">-</button><button onClick="sendClickDel('+index+', \''+key+'\')" class="btn-del btn-del-'+index+'">Supprimer</button></p>')
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

    firebase.database().ref('Films/'+key).set({
        Titre : thisFilmTitre,
        Vote  : parseInt(thisFilmVote) +1
    });
}

function sendClickMoins(index, key) {
    thisFilmTitre = $('#film-titre-'+index).html() ;
    thisFilmVote = $('#film-vote-'+index).html() ;

    firebase.database().ref('Films/'+key).set({
        Titre : thisFilmTitre,
        Vote  : parseInt(thisFilmVote) -1
    });
}

function sendClickDel(key) {
    firebase.database().ref('Films/Film '+key).set({}) ;
}

function addFilm(titre) {
    var nbFilm = parseInt(getNumberFilm()) +1 ;
    firebase.database().ref('Films/Film '+nbFilm).set({
        Titre : titre,
        Vote  : 0
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
        var errorMessage    = $('.error-message') ;

        if (inputTitreFilm.val() != '') {
            if(errorMessage.length == 0){
                errorMessage.empty() ;
                inputTitreFilm.css('border','1px solid black') ;
            }

            addFilm(inputTitreFilm.val()) ;
        } else {
            inputTitreFilm.css('border','1px solid red') ;
            if(errorMessage.length == 0){
                inputTitreFilm.parent().append('<span class="error-message">Renseignez un titre pour le film</span>');
            }
        }

    }) ;
}) ;
