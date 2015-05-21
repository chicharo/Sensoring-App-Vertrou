$(document).ready( function () { 
	$("#formLogin").submit( function() {	// à la soumission du formulaire						 
		$.ajax({ // fonction permettant de faire de l'ajax
		   type: "POST", // methode de transmission des données au fichier php
		   url: "../model/identification.php", // url du fichier php
		   data: 'username='+$("#username").val()+'&password='+$("#password").val(), // données à transmettre
		   success: function(msg){ // si l'appel a bien fonctionné
				if(msg==1) // si la connexion en php a fonctionnée
				{
					$("div#connexion").html("<span id=\"confirmMsg\">Connection ...</span>");
					document.location.href="../vue/dashboard.php";
					// on désactive l'affichage du formulaire et on affiche un message de bienvenue à la place
				}
				else if(msg==0)// si la connexion en php n'a pas fonctionnée
				{
					$("span#error").html("Connection error, please check your login and password.");
					// on affiche un message d'erreur dans le span prévu à cet effet
				}
				else if(msg==2){
					$("span#error").html("Blabla ca renvoie 2");
				}
				else if(msg==4){
					$("span#error").html("Bim 4");
				}
				else{
					alert(msg);
				}
		   }
		});
		return false; // permet de rester sur la même page à la soumission du formulaire
	});
});