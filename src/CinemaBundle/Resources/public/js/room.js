
String.prototype.capitalizeFirstLetter = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
} ;

jQuery(function ($) {
    var box = {
        cinema : {
            //Déclaration variable
            type  : null,
            principalfilm : null,
            principalfilmKey : null,
            otherfilms : null,
            ref   : null,

            init : function() {
                console.log('init cinema');
                // Initialize Firebase
                var config = {
                    apiKey: "AIzaSyCPJyDJltGTxoqxa28ctL_b54qQkWQ8ydU",
                    authDomain: "mybox-e8c92.firebaseapp.com",
                    databaseURL: "https://mybox-e8c92.firebaseio.com",
                    storageBucket: "mybox-e8c92.appspot.com",
                    messagingSenderId: "538405558234"
                };

                firebase.initializeApp(config);

                box.cinema.ref = firebase.database().ref("Films");

                box.cinema.category() ;
                box.cinema.lastFilm() ;
                box.cinema.otherFilm() ;
            },


            category : function() {
                box.cinema.type = $('h1 span#type-salle').html();
            },

            lastFilm : function() {
                box.cinema.ref.orderByChild("Type").equalTo(box.cinema.type.capitalizeFirstLetter()).limitToFirst(1).on("child_added", function(snapshot) {
                    box.cinema.principalfilm = snapshot.val() ;
                    box.cinema.principalfilmKey = snapshot.key ;
                    box.cinema.renderPrincipal() ;
                });
            },

            otherFilm : function() {
                box.cinema.ref.orderByChild("Type").equalTo(box.cinema.type.capitalizeFirstLetter()).on("child_added", function(snapshot) {
                    box.cinema.otherfilms = snapshot.val() ;
                    box.cinema.renderOther() ;
                });
            },

            renderPrincipal : function() {
                console.log('principal') ;
                console.log(box.cinema.principalfilm) ;
                console.log(box.cinema.principalfilmKey) ;
            },

            renderOther : function() {
                console.log('other') ;
                console.log(box.cinema.otherfilms) ;
            }

        }
    } ;

    $(document).ready(function(){
        if($('h1 span#type-salle').length > 0) {
            box.cinema.init() ;
        }
    }) ;
});