//slider ze zdjeciami
function hide()
{
	$("#slider").fadeOut(500);
}

var number = Math.floor(Math.random()*5) + 1;
function change()
{
	number++; if(number>5) number=1;

	var plik = "<img src=\"img/slider/zdjecie" + number + ".jpg\"/>";
	
	document.getElementById("slider").innerHTML= plik;
	$("#slider").fadeIn(500);
	setTimeout("change()", 6000);
	setTimeout("hide()", 4500);
}


localStorage.clear();
//funkcja zmienia rozmiar trzcionki
function setFont(){

	var trzcionka = 'normalna';

	if (window.localStorage) 
	{ 
		if (localStorage.clickcount) 
			{ localStorage.clickcount = Number(localStorage.clickcount) + 1;} 	
		else { localStorage.clickcount = 1; }

		if(localStorage.clickcount % 2 == 0){ 
			trzcionka = 'normalna';
		}
		else { trzcionka = 'powiekszona';}

		window.localStorage.setItem('trzcionka', trzcionka);

		var news_style = document.getElementById("content");

		if(trzcionka == 'normalna'){
			
			news_style.style.fontSize = "16px";

		}
		else{
			news_style.style.fontSize = "22px";
		}
	}
}

function count_clicks() 
{
if (window.localStorage) 
{ 
	if (localStorage.clickcount) 
	{
	 localStorage.clickcount = Number(localStorage.clickcount) + 1;
	} 
	else { localStorage.clickcount = 1; }

var div1 = document.getElementById("foto1");
var div2 = document.getElementById("foto2");
var div3 = document.getElementById("foto3");

}
var klik = localStorage.getItem("clickcount");
if (klik==1)
document.getElementById("klikniecia").innerHTML = "Kliknąłeś już raz nasze zdjęcia!";
else
document.getElementById("klikniecia").innerHTML = "Kliknąłeś już " + klik + " razy nasze zdjęcia!";
}

//zegar
var start = new Date();

function licz()
{
var stop = new Date();
var roznica_czasow = stop.getTime() - start.getTime(); 
document.getElementById("licznik").innerHTML = Math.round(roznica_czasow/1000);

setTimeout("licz()", 100);
}

function czysc()
{
	sessionStorage.removeItem("Message");
}


var x = document.createElement("input");
function ocen() 
{	
	
	x.setAttribute("type", "range");
	x.setAttribute("min", "0");
	x.setAttribute("max", "10");
	document.getElementById("Range").appendChild(x);
	var suwak_style = document.getElementById("Range");
	suwak_style.style.marginTop = "20px";
	suwak_style.style.border = "#128870 solid 3px";
	suwak_style.style.width = "129px";
	suwak_style.style.float ="left";

	
	document.getElementById("Range").onchange = function wartosc()	{ 
	document.getElementById("demo").innerHTML = x.value;
	var wartosc_style = document.getElementById("demo");
	wartosc_style.style.float = "left";
	wartosc_style.style.marginLeft = "30px";
	wartosc_style.style.marginTop = "20px";
	wartosc_style.style.fontSize = "25px";

	}

}

function wynik_oceny()
{
	if(x.value >7){
	document.getElementById("ocena").innerHTML = "Dziękujemy za tak wysoką ocenę!";
	}
	else if(x.value >4 && x.value <=7){
	document.getElementById("ocena").innerHTML = "Dziękujemy za twoją ocenę! Będziemy pracować nad naszą stroną dalej :)";
	}
	else if(x.value <=4 && x.value >=0){
	document.getElementById("ocena").innerHTML = "Dziękujemy za twoją ocenę! Podziel się z nami swoimi przemyśleniami na temat działania strony. Napisz do nas:)";
	}
	else{
	document.getElementById("ocena").innerHTML = "Spróbuj jeszcze raz";
	}
	var ocena_style = document.getElementById("ocena");
	ocena_style.style.fontSize = "20px";
}

function odliczanie()
{
	var dzisiaj = new Date();
		
	var dzien = dzisiaj.getDate();
	var miesiac = dzisiaj.getMonth()+1;
	var rok = dzisiaj.getFullYear();
		
	var godzina = dzisiaj.getHours();
	if (godzina<10) godzina = "0"+godzina;
		
	var minuta = dzisiaj.getMinutes();
	if (minuta<10) minuta = "0"+minuta;
	
	var sekunda = dzisiaj.getSeconds();
	if (sekunda<10) sekunda = "0"+sekunda;
		
	document.getElementById("zegar").innerHTML = 
	dzien+"/"+miesiac+"/"+rok+" | "+godzina+":"+minuta+":"+sekunda;
		 
	 setTimeout("odliczanie()",1000);
}