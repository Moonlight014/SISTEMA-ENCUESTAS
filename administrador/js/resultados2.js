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

console.log(tama);
//console.log(v2);
console.log(t1);
//console.log(t2);
//console.log(let);
//alert(tama)
//console.log(v2);
//var x=document.getElementsByClassName("subida")[0].value;    
for (var x = 0; x < tama.length; x++) {
				console.log(x);	
				console.log(tama[x]);
				console.log("--");

                if (x == 0) {
					var pieChart = new Chart(oc[x], {
					type: 'pie',
					data: {
					    labels: t1,
					    datasets: [
					        {data:v1,
					            backgroundColor: [
					                "#FF6384",
					                "#567845"   
					            ]
					        }]
					}
					});
				}  
                if (x == 1){
					var oilCanvas = oc[x];
					//Chart.defaults.global.defaultFontFamily = "Lato";
					//Chart.defaults.global.defaultFontSize = 18;
					var oilData = {
					    labels:t2,
					    datasets: [
					        {
					            data: v2,
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
				} 
                if (x == 2){
					var oilCanvas = oc[x];
					//Chart.defaults.global.defaultFontFamily = "Lato";
					//Chart.defaults.global.defaultFontSize = 18;
					var oilData = {
					    labels:t3,
					    datasets: [
					        {
					            data: v3,
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
				} 
                if (x == 3){
					var oilCanvas = oc[x];
					//Chart.defaults.global.defaultFontFamily = "Lato";
					//Chart.defaults.global.defaultFontSize = 18;
					var oilData = {
					    labels:t4,
					    datasets: [
					        {
					            data: v4,
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
				} 
                if (x == 4){
					var oilCanvas = oc[x];
					//Chart.defaults.global.defaultFontFamily = "Lato";
					//Chart.defaults.global.defaultFontSize = 18;
					var oilData = {
					    labels:t5,
					    datasets: [
					        {
					            data: v5,
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
				} 
				
			}