webpackJsonp([6],{6:/*!*********************************************************!*\
  !*** multi ./app/Resources/client/jsx/trait/search.jsx ***!
  \*********************************************************/
/*! no static exports found */
/*! all exports used */
function(t,e,i){t.exports=i(/*! ./app/Resources/client/jsx/trait/search.jsx */"U3YH")},Q8uE:/*!***************************************************************!*\
  !*** ./app/Resources/client/jsx/trait/search/quickSearch.jsx ***!
  \***************************************************************/
/*! no static exports found */
/*! all exports used */
function(t,e,i){(function(t){t(document).ready(function(){t("#search_trait").autocomplete({position:{my:"right top",at:"right bottom"},source:function(e,i){var n=e.term;t.ajax({url:Routing.generate("api_listing_traits",{dbversion:dbversion,limit:500,search:n}),dataType:"json",success:function(t){i(t.map(function(t){return t.value=t.type,t}))}})},minLength:3}),t("#search_trait").data("ui-autocomplete")._renderItem=function(e,i){var n=Routing.generate("trait_details",{dbversion:dbversion,trait_type_id:i.traitTypeId}),a="<a href='"+n+"'><span style='display:inline-block; width: 100%; font-style: italic;'>"+i.value+"</span></a>";return t("<li>").append(a).appendTo(e)},t("#btn_search_trait").click(function(){var e=t("#search_trait").val(),i=Routing.generate("trait_result",{dbversion:dbversion,limit:500,search:e});window.location.href=i}),t("#search_trait").keyup(function(e){13==e.keyCode&&t("#btn_search_trait").click()})})}).call(e,i(/*! jquery */"7t+N"))},U3YH:/*!***************************************************!*\
  !*** ./app/Resources/client/jsx/trait/search.jsx ***!
  \***************************************************/
/*! no static exports found */
/*! all exports used */
function(t,e,i){i(/*! ./search/quickSearch.jsx */"Q8uE")}},[6]);