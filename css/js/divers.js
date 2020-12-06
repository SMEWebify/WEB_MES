		function openDiv(evt, divId) {
			var i, tabcontent, tablinks;
			tabcontent = document.getElementsByClassName("tabcontent");
			for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
			}
			tablinks = document.getElementsByClassName("tablinks");
			for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			}
			document.getElementById(divId).style.display = "block";
			evt.currentTarget.className += " active";
			
			
		}
		
		function openDivMenu(evt, divId) {
		  var x = document.getElementById("DivAdminListe");
		  if (x.style.display === "none") {
			x.style.display = "block";
		  } else {
			x.style.display = "none";
		  }
		}
		
		
		window.onload = function(){ 
			document.getElementById("defaultOpen").click();
		}
		
		function imprimer_page(){
			window.print();
		}

		function cocherOuDecocherTout(cochePrincipale) {
			var coches = document.getElementById('tableau_plannig').getElementsByTagName('input');
			for(var i = 0 ; i < coches.length ; i++) {
				var c = coches[i];
				if(c.type.toUpperCase() == 'CHECKBOX' & c != cochePrincipale) {
						c.checked = cochePrincipale.checked;
					}
				}
			return true;
		}

		function DeclarationQTAuto() {
				
			// initialisation des deux valeur input dans dans un array
			var valeur = document.getElementsByName('QT[]');
			var aRemplir = document.getElementsByName('QT_PRODUITE[]');
				
			// boucle sur le array de la valeur source
			for(var i = 0 ; i < aRemplir.length ; i++) {
					
				aRemplir[i].value = valeur[i].value;
			}
			return true;
		}
		
		function DeclarationTPSAuto() {
				
			// initialisation des deux valeur input dans dans un array
			var valeur = document.getElementsByName('TPS[]');
			var aRemplir = document.getElementsByName('TPS_PRODUIT[]');
				
			// boucle sur le array de la valeur source
			for(var i = 0 ; i < aRemplir.length ; i++) {
					
				aRemplir[i].value = valeur[i].value;
			}
			return true;
		}

		function Alert_modif()
		{
			alert('êtes vous sur de vouloir modifier ces lignes ?');
		}
		
