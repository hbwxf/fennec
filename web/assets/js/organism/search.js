webpackJsonp([7],{4:/*!************************************************************!*\
  !*** multi ./app/Resources/client/jsx/organism/search.jsx ***!
  \************************************************************/
/*! no static exports found */
/*! all exports used */
function(n,e,i){n.exports=i(/*! ./app/Resources/client/jsx/organism/search.jsx */"n7DZ")},bKX1:/*!******************************************************************!*\
  !*** ./app/Resources/client/jsx/organism/search/quickSearch.jsx ***!
  \******************************************************************/
/*! no static exports found */
/*! all exports used */
function(n,e,i){(function(n){n(document).ready(function(){n("#search_organism").autocomplete({position:{my:"right top",at:"right bottom"},source:function(e,i){var t=e.term;n.ajax({url:Routing.generate("api_listing_organisms",{dbversion:dbversion,limit:500,search:t}),dataType:"json",success:function(n){i(n.map(function(n){return n.value=n.scientificName,n}))}})},minLength:3}),n("#search_organism").data("ui-autocomplete")._renderItem=function(e,i){var t=Routing.generate("organism_details",{dbversion:dbversion,fennec_id:i.fennecId}),a="<a href='"+t+"'><span style='display:inline-block; width: 100%; font-style: italic;'>"+i.scientificName+"</span></a>";return n("<li>").append(a).appendTo(e)},n("#btn_search_organism").click(function(){var e=n("#search_organism").val(),i=Routing.generate("organism_result",{dbversion:dbversion,limit:500,search:e});window.location.href=i}),n("#search_organism").keyup(function(e){13==e.keyCode&&n("#btn_search_organism").click()})})}).call(e,i(/*! jquery */"7t+N"))},n7DZ:/*!******************************************************!*\
  !*** ./app/Resources/client/jsx/organism/search.jsx ***!
  \******************************************************/
/*! no static exports found */
/*! all exports used */
function(n,e,i){i(/*! ./search/quickSearch.jsx */"bKX1")}},[4]);