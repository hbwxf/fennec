webpackJsonp([4],{"+yTn":/*!*****************************************************************************!*\
  !*** ./app/Resources/client/jsx/project/helpers/removeTraitFromProject.jsx ***!
  \*****************************************************************************/
/*! no static exports found */
/*! all exports used */
function(t,e,n){(function(e){function n(t,n,a,i,o,r){var s="columns"===a?n.columns:n.rows,d=!0,c=!1,u=void 0;try{for(var l,f=s[Symbol.iterator]();!(d=(l=f.next()).done);d=!0){var m=l.value;null!=m.metadata&&(delete m.metadata[t],null!=m.metadata.trait_citations&&delete m.metadata.trait_citations[t])}}catch(t){c=!0,u=t}finally{try{!d&&f.return&&f.return()}finally{if(c)throw u}}var b=Routing.generate("api",{namespace:"edit",classname:"updateProject",dbversion:dbversion});e.ajax(b,{data:{dbversion:i,project_id:o,biom:n.toString()},method:"POST",success:r,error:function(t){return showMessageDialog(t,"danger")}})}t.exports=n}).call(e,n(/*! jquery */"7t+N"))},1:/*!************************************************************!*\
  !*** multi ./app/Resources/client/jsx/project/helpers.jsx ***!
  \************************************************************/
/*! no static exports found */
/*! all exports used */
function(t,e,n){t.exports=n(/*! ./app/Resources/client/jsx/project/helpers.jsx */"TERn")},TERn:/*!******************************************************!*\
  !*** ./app/Resources/client/jsx/project/helpers.jsx ***!
  \******************************************************/
/*! no static exports found */
/*! all exports used */
function(t,e,n){n(/*! ./helpers/addTraitToProject.jsx */"fAub"),n(/*! ./helpers/removeTraitFromProject.jsx */"+yTn")},fAub:/*!************************************************************************!*\
  !*** ./app/Resources/client/jsx/project/helpers/addTraitToProject.jsx ***!
  \************************************************************************/
/*! no static exports found */
/*! all exports used */
function(t,e,n){(function(e){function n(t,n,a,i,o,r,s,d){console.log(arguments);var c=i.getMetadata({dimension:o,attribute:["fennec",dbversion,"fennec_id"]}).map(function(t){return t in n?n[t]:null}),u=i.getMetadata({dimension:o,attribute:["fennec",dbversion,"fennec_id"]}).map(function(t){return t in a?a[t]:[]});i.addMetadata({dimension:o,attribute:t,values:c}),i.addMetadata({dimension:o,attribute:["trait_citations",t],values:u});var l=Routing.generate("api",{namespace:"edit",classname:"updateProject",dbversion:dbversion});e.ajax(l,{data:{dbversion:r,project_id:s,biom:i.toString()},method:"POST",success:d,error:function(t){return showMessageDialog(t,"danger")}})}t.exports=n}).call(e,n(/*! jquery */"7t+N"))}},[1]);