<?php
$rutaUrlBloque = $this->miConfigurador->getVariableConfiguracion ( 'host' ).$this->miConfigurador->getVariableConfiguracion ( 'site' ).'/blocks/gui/menuPrincipal/';
?>

function showResult(evt){
	var criterio = evt.target.value;
	if (criterio.length<4) {
		cleanResult();
		return;
	}
	setResult(criterio);
}

function cleanResult(){
	$("#livesearch").css("border","0px");
	$("#livesearch").css("display","none");
}

function setResult(criterio){
	searchResults(criterio);
	$("#livesearch").css("border","1px solid #A5ACB2");
	$("#livesearch").css("display","block");
}

function addItemResult(enlace){
	var link = "<a target='principal' href='"+enlace.url+"'>"+enlace.etiqueta+"</a><br />";
	$("#livesearch").append(link);
}

function searchResults(criterio){
	$("#livesearch").html("");
	var numEnlaces = 0;
	//enlacesRol es una variable que viene del javascript del bloque menuPrincipal
	for(var i in enlacesRol){
		var indice = enlacesRol[i].etiqueta.toUpperCase().indexOf(criterio.toUpperCase());
		if(indice > -1){
			addItemResult(enlacesRol[i]);
			numEnlaces++;
			if(numEnlaces >= numeroResultados){
				markSelected();
				return;
			}
		}
	}
	markSelected();
}

function markSelected(){
	console.log(keyPosition);
	var selectedLink = $("#livesearch a")[keyPosition];
	while(selectedLink==undefined){
		if(keyPosition>0){
			keyPosition = 0;
		} else {
			keyPosition = keyPosition - 2;
		}
		selectedLink = $("#livesearch a")[keyPosition];
	}
	console.log(selectedLink);
	$(selectedLink).attr("data-value","selected");
	$(selectedLink).css("background-color","#f00");
}

var keyPosition = 0;
var numeroResultados = 5;
function spetialNavigation(evt){
	var key = evt.key;
	if (key=="ArrowUp"){
		keyPosition--;
		if(keyPosition < 0){
			keyPosition = numeroResultados - 1;
		}
	} else if (key=="ArrowDown"){
		keyPosition++;
		if(keyPosition >= numeroResultados){
			keyPosition = 0;
		}
	}
	
}

$("#searchservice").keyup(showResult);
$("#searchservice").keypress(spetialNavigation);
$("#searchservice").parent().mouseleave(cleanResult);