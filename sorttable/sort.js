var TableIDvalue = "indextable";
var TableLastSortedColumn = -1;
//var clicked = false;
function SortTable() {
/*if (clicked = false) {
//SortTable(arguments[0], arguments[1], 'N');
clicked = true;
} else {
  clicked = false;
}*/
var sortColumn = parseInt(arguments[1]);
var type = arguments.length > 2 ? arguments[2] : 'T';
var dateformat = arguments.length > 3 ? arguments[3] : '';
var table = document.getElementById(TableIDvalue);
var tbody = table.getElementsByTagName("tbody")[0];
var rows = tbody.getElementsByTagName("tr");
var arrayOfRows = new Array();
type = type.toUpperCase();
dateformat = dateformat.toLowerCase();
for(var i=0, len=rows.length; i<len; i++) {
 arrayOfRows[i] = new Object;
 arrayOfRows[i].oldIndex = i;
 var celltext = rows[i].getElementsByTagName("td")[sortColumn].innerHTML.replace(/<[^>]*>/g,"");
 if( type=='D' ) { arrayOfRows[i].value = GetDateSortingKey(dateformat,celltext); }
 else {
 var re = type=="N" ? /[^\.\-\+\d]/g : /[^a-zA-Z0-9]/g;
 arrayOfRows[i].value = celltext.replace(re,"").substr(0,25).toLowerCase();
 }
 }
if (sortColumn == TableLastSortedColumn) { arrayOfRows.reverse(); }
else {
 TableLastSortedColumn = sortColumn;
 switch(type) {
 case "N" : arrayOfRows.sort(CompareRowOfNumbers); break;
 case "D" : arrayOfRows.sort(CompareRowOfNumbers); break;
 default : arrayOfRows.sort(CompareRowOfText);
 }
 }
var newTableBody = document.createElement("tbody");
for(var i=0, len=arrayOfRows.length; i<len; i++) {
 newTableBody.appendChild(rows[arrayOfRows[i].oldIndex].cloneNode(true));
 }
table.replaceChild(newTableBody,tbody);
} // function SortTable()
function CompareRowOfText(a,b) {
var aval = a.value;
var bval = b.value;
return( aval == bval ? 0 : (aval > bval ? 1 : -1) );
} // function CompareRowOfText()
function CompareRowOfNumbers(a,b) {
var aval = /\d/.test(a.value) ? parseFloat(a.value) : 0;
var bval = /\d/.test(b.value) ? parseFloat(b.value) : 0;
return( aval == bval ? 0 : (aval > bval ? 1 : -1) );
} // function CompareRowOfNumbers()
function GetDateSortingKey(format,text) {
if( format.length < 1 ) { return ""; }
format = format.toLowerCase();
text = text.toLowerCase();
text = text.replace(/^[^a-z0-9]*/,"",text);
text = text.replace(/[^a-z0-9]*$/,"",text);
if( text.length < 1 ) { return ""; }
text = text.replace(/[^a-z0-9]+/g,",",text);
var date = text.split(",");
if( date.length < 3 ) { return ""; }
var d=0, m=0, y=0;
for( var i=0; i<3; i++ ) {
 var ts = format.substr(i,1);
 if( ts == "d" ) { d = date[i]; }
 else if( ts == "m" ) { m = date[i]; }
 else if( ts == "y" ) { y = date[i]; }
 }
if( d < 10 ) { d = "0" + d; }
if( /[a-z]/.test(m) ) {
 m = m.substr(0,3);
 switch(m) {
 case "jan" : m = 1; break;
 case "feb" : m = 2; break;
 case "mar" : m = 3; break;
 case "apr" : m = 4; break;
 case "may" : m = 5; break;
 case "jun" : m = 6; break;
 case "jul" : m = 7; break;
 case "aug" : m = 8; break;
 case "sep" : m = 9; break;
 case "oct" : m = 10; break;
 case "nov" : m = 11; break;
 case "dec" : m = 12; break;
 default : m = 0;
 }
 }
if( m < 10 ) { m = "0" + m; }
y = parseInt(y);
if( y < 100 ) { y = parseInt(y) + 2000; }
return "" + String(y) + "" + String(m) + "" + String(d) + "";
} // function GetDateSortingKey()
