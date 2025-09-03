var xx="hola";
var xy=1;


var c = new Array();
var tama=[];
var v1=[];
var v2=[];
var v3=[];
var v4=[];
var t1=[];
var t2=[];
var t3=[];
var t4=[];
var oc=[];

var xd = document.querySelectorAll(".tamaño");
xd.forEach(function	(element){
	tama.push(element.value);
});

var oilc = document.querySelectorAll(".oilChart");
oilc.forEach(function	(element){
	oc.push(element);
});

var valores1 = document.querySelectorAll(".valor1");
valores1.forEach(function	(element){
	v1.push(element.value);
});

var valores2 = document.querySelectorAll(".valor2");
valores2.forEach(function	(element){
	v2.push(element.value);
});

var valores3 = document.querySelectorAll(".valor3");
valores3.forEach(function	(element){
	v3.push(element.value);
});

var valores4 = document.querySelectorAll(".valor4");
valores4.forEach(function	(element){
	v4.push(element.value);
});

var titu1 = document.querySelectorAll(".titulo1");
titu1.forEach(function	(element){
	t1.push(element.value);
});

var titu2 = document.querySelectorAll(".titulo2");
titu2.forEach(function	(element){
	t2.push(element.value);
});

var titu3 = document.querySelectorAll(".titulo3");
titu3.forEach(function	(element){
	t3.push(element.value);
});

var titu4 = document.querySelectorAll(".titulo4");
titu4.forEach(function	(element){
	t4.push(element.value);
});

//console.log(let);
//console.log(let);
alert(tama)
//console.log(v2);
//var x=0;
for (var x = 0; x < 10; x++) {
				console.log(x);	
				console.log(tama[x]);
				console.log("--");
				c[x] = tama[x];

				if (c[x] == 3) {
			
					var valor1 = document.getElementsByClassName("valor1")[x].value;
					var valor2 = document.getElementsByClassName("valor2")[x].value;
					var valor3 = document.getElementsByClassName("valor3")[x].value;

					var titulo1 = document.getElementsByClassName("titulo1")[x].value;
					var titulo2 = document.getElementsByClassName("titulo2")[x].value;
					var titulo3 = document.getElementsByClassName("titulo3")[x].value;

					var oilCanvas = document.getElementsByClassName("oilChart")[x];

					Chart.defaults.global.defaultFontFamily = "Lato";
					Chart.defaults.global.defaultFontSize = 18;

					var oilData = {
					    labels: [
					        titulo1,
					        titulo2,
					        titulo3
					    ],
					    datasets: [
					        {
					            data: [valor1, valor2, valor3],
					            backgroundColor: [
					                "#FF6384",
					                "#567845",
					                "#84FF63"
					            ]
					        }]
					};

					var pieChart = new Chart(oilCanvas, {
					type: 'pie',
					data: oilData
					}); 
			    
				} else if (c[x] == 4) {

					var valor1 = document.getElementsByClassName("valor1")[x].value;
					var valor2 = document.getElementsByClassName("valor2")[x].value;
					var valor3 = document.getElementsByClassName("valor3")[x].value;
					var valor4 = document.getElementsByClassName("valor4")[x].value;
		
					var titulo1 = document.getElementsByClassName("titulo1")[x].value;
					var titulo2 = document.getElementsByClassName("titulo2")[x].value;
					var titulo3 = document.getElementsByClassName("titulo3")[x].value;
					var titulo4 = document.getElementsByClassName("titulo4")[x].value;
	
					

					var oilCanvas = document.getElementsByClassName("oilChart")[x];

					Chart.defaults.global.defaultFontFamily = "Lato";
					Chart.defaults.global.defaultFontSize = 18;

					var oilData = {
					    labels: [
					        titulo1,
					        titulo2,
					        titulo3,
					        titulo4
					    ],
					    datasets: [
					        {
					            data: [valor1, valor2, valor3, valor4],
					            backgroundColor: [
					                "#FF6384",
					                "#567845",
					                "#84FF63",
					                "purple"
					            ]
					        }]
					};

					var pieChart = new Chart(oilCanvas, {
					type: 'pie',
					data: oilData
					}); 

				} else if (c[x] == 5) {


					var valor1 = document.getElementsByClassName("valor1")[x].value;
					var valor2 = document.getElementsByClassName("valor2")[x].value;
					var valor3 = document.getElementsByClassName("valor3")[x].value;
					var valor4 = document.getElementsByClassName("valor4")[x].value;
					var valor5 = document.getElementsByClassName("valor5")[x].value;


					var titulo1 = document.getElementsByClassName("titulo1")[x].value;
					var titulo2 = document.getElementsByClassName("titulo2")[x].value;
					var titulo3 = document.getElementsByClassName("titulo3")[x].value;
					var titulo4 = document.getElementsByClassName("titulo4")[x].value;				
					var titulo5 = document.getElementsByClassName("titulo5")[x].value;
				
					var oilCanvas = document.getElementsByClassName("oilChart")[x];

					Chart.defaults.global.defaultFontFamily = "Lato";
					Chart.defaults.global.defaultFontSize = 18;

					var oilData = {
					    labels: [
					        titulo1,
					        titulo2,
					        titulo3,
					        titulo4,
					        titulo5
					    ],
					    datasets: [
					        {
					            data: [valor1, valor2, valor3, valor4, valor5],
					            backgroundColor: [
					                "#FF6384",
					                "#567845",
					                "#84FF63",
					                "purple",
					                "deepskyblue"
					            ]
					        }]
					};

					var pieChart = new Chart(oilCanvas, {
					type: 'pie',
					data: oilData
					}); 

				} else if (c[x] == 22) {
			
					var valor1 = v1[x];
					var valor2 = v2[x];
					

					var titulo1 = t1[x];
					var titulo2 = t2[x];
					

					//var oilCanvas = oc[x];
					var oilCanvas =document.getElementsByClassName("oilChart")[x];

					//Chart.defaults.global.defaultFontFamily = "Lato";
					//Chart.defaults.global.defaultFontSize = 18;

					var oilData = {
					    labels: [
					        titulo1,
					        titulo2
					        
					    ],
					    datasets: [
					        {
					            data: [valor1, valor2],
					            backgroundColor: [
					                "#FF6384",
					                "#567845"
					                
					            ]
					        }]
					};

					var pieChart = new Chart(oilCanvas, {
					type: 'pie',
					data: oilData
					}); 
			    
				} else if (c[x] == 2) {
					console.log(c[x]);
					console.log("--");
			
					var valor1 = v1[x];
					var valor2 = v2[x];
					

					var titulo1 = t1[x];
					var titulo2 = t2[x];
					

					//var oilCanvas = oc[x];
					//var oilCanvas =;

					//Chart.defaults.global.defaultFontFamily = "Lato";
					//Chart.defaults.global.defaultFontSize = 18;

					//var oilData = ;

					var pieChart = new Chart(oc[x], {
					type: 'pie',
					data: {
					    labels: [
					        titulo1,
					        titulo2
					        
					    ],
					    datasets: [
					        {
					            data: [valor1, valor2],
					            backgroundColor: [
					                "#FF6384",
					                "#567845"
					                
					            ]
					        }]
					}
					});
                    //oc[x].className = "MyClass";
                    
					///break;
				}
				//let clase = document.getElementsByClassName('.oilChart');
				
			}