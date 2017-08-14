webpackJsonp([5],{

/***/ "./app/Resources/client/jsx/organism/details.jsx":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("./app/Resources/client/jsx/organism/details/appendTraits.jsx");
__webpack_require__("./app/Resources/client/jsx/organism/details/eol.jsx");

/***/ }),

/***/ "./app/Resources/client/jsx/organism/details/appendTraits.jsx":
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($, global) {/**
 * Created by s216121 on 14.03.17.
 */

function appendTraitEntries(domElement, traitEntries, traitFormat) {
    $.ajax({
        url: Routing.generate('api', { 'namespace': 'details', 'classname': 'TraitEntries' }),
        data: {
            "dbversion": dbversion,
            "trait_entry_ids": traitEntries,
            "trait_format": traitFormat
        },
        method: "GET",
        success: function success(result) {
            $.each(result, function (key, value) {
                var realValue = value.value;
                if (value.value === null) {
                    realValue = value.value_definition;
                }
                var unitString = "";
                if (value.unit != null) {
                    unitString = " $" + value.unit + "$";
                }
                var traitCitationDiv = $('<div class="trait-citation">').text(value.citation).css({ 'font-size': '11px' });
                var originUrl = $('<a href="' + value.origin_url + '">').text(" origin");
                if (value.origin_url != "") {
                    traitCitationDiv.append(originUrl);
                }
                domElement.append($('<div>').text(realValue + unitString).append(traitCitationDiv));
            });
        }
    });
}

// export function globally
global.appendTraitEntries = appendTraitEntries;
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__("./node_modules/jquery/dist/jquery.js"), __webpack_require__("./node_modules/webpack/buildin/global.js")))

/***/ }),

/***/ "./app/Resources/client/jsx/organism/details/eol.jsx":
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {/**
 * Created by s216121 on 14.03.17.
 */
$('document').ready(function () {
    var img_template = '<a class="thumbnail" href="<%= href %>"><img src="<%= src %>"/></a><a href="<%= source %>"><div><%= rights %> <%= license %></div></a>';
    var txt_template = '<div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title"><%= title %></h3><a href="<%= href %>"><%= rights %> <%= license %></a></div><div class="panel-body"><%= body %></div></div>';
    $.ajax({
        method: "GET",
        url: "http://eol.org/api/pages/1.0.json",
        data: {
            id: eol_id,
            batch: false,
            images_per_page: 3,
            images_page: 1,
            videos_per_page: 0,
            videos_page: 1,
            sounds_per_page: 0,
            sounds_page: 1,
            maps_per_page: 0,
            maps_page: 1,
            texts_per_page: 3,
            texts_page: 1,
            iucn: true,
            subjects: "overview",
            licenses: "cc-by|cc-by-nc|cc-by-sa|cc-by-nc-sa|pd",
            details: true,
            common_names: true,
            synonyms: true,
            references: true,
            taxonomy: true,
            vetted: 0,
            cache_ttl: 60,
            language: "en"
        },
        success: function success(result) {
            console.log(result);
            $.each(result["dataObjects"], function (dob) {
                if (result["dataObjects"][dob]["dataType"] === "http://purl.org/dc/dcmitype/StillImage") {
                    var url = result["dataObjects"][dob]["eolMediaURL"];
                    var license = result["dataObjects"][dob]["license"];
                    var rights = result["dataObjects"][dob]["rights"];
                    if (typeof rights === 'undefined') {
                        rights = "(c)" + result["dataObjects"][dob]["rightsHolder"];
                    }
                    var source = result["dataObjects"][dob]["source"];
                    var img_element = _.template(img_template)({ src: url, href: url, license: license, rights: rights, source: source });
                    $('#organism-img-column').append(img_element);
                }
                if (result["dataObjects"][dob]["dataType"] === "http://purl.org/dc/dcmitype/Text") {
                    var title = result["dataObjects"][dob]["title"];
                    var body = result["dataObjects"][dob]["description"];
                    var _url = result["dataObjects"][dob]["source"];
                    var _license = result["dataObjects"][dob]["license"];
                    var _rights = result["dataObjects"][dob]["rights"];
                    if (typeof _rights === 'undefined') {
                        _rights = "(c)" + result["dataObjects"][dob]["rightsHolder"];
                    }
                    var txt_element = _.template(txt_template)({ title: title, body: body, href: _url, rights: _rights, license: _license });
                    $('#organism-txt-column').append(txt_element);
                }
            });
            $("#vernacularName").text(getBestVernacularNameEOL(result));
        },
        error: function error(jqXHR, textStatus, errorThrown) {
            showMessageDialog(errorThrown, 'danger');
        }
    }).always(function () {
        $('#loading-progress').empty();
    });
    $("#toggleCitationButton").on("click", function () {
        $(".trait-citation").toggle();
    });
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__("./node_modules/jquery/dist/jquery.js")))

/***/ }),

/***/ 3:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./app/Resources/client/jsx/organism/details.jsx");


/***/ })

},[3]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hcHAvUmVzb3VyY2VzL2NsaWVudC9qc3gvb3JnYW5pc20vZGV0YWlscy5qc3giLCJ3ZWJwYWNrOi8vLy4vYXBwL1Jlc291cmNlcy9jbGllbnQvanN4L29yZ2FuaXNtL2RldGFpbHMvYXBwZW5kVHJhaXRzLmpzeCIsIndlYnBhY2s6Ly8vLi9hcHAvUmVzb3VyY2VzL2NsaWVudC9qc3gvb3JnYW5pc20vZGV0YWlscy9lb2wuanN4Il0sIm5hbWVzIjpbInJlcXVpcmUiLCJhcHBlbmRUcmFpdEVudHJpZXMiLCJkb21FbGVtZW50IiwidHJhaXRFbnRyaWVzIiwidHJhaXRGb3JtYXQiLCIkIiwiYWpheCIsInVybCIsIlJvdXRpbmciLCJnZW5lcmF0ZSIsImRhdGEiLCJkYnZlcnNpb24iLCJtZXRob2QiLCJzdWNjZXNzIiwicmVzdWx0IiwiZWFjaCIsImtleSIsInZhbHVlIiwicmVhbFZhbHVlIiwidmFsdWVfZGVmaW5pdGlvbiIsInVuaXRTdHJpbmciLCJ1bml0IiwidHJhaXRDaXRhdGlvbkRpdiIsInRleHQiLCJjaXRhdGlvbiIsImNzcyIsIm9yaWdpblVybCIsIm9yaWdpbl91cmwiLCJhcHBlbmQiLCJnbG9iYWwiLCJyZWFkeSIsImltZ190ZW1wbGF0ZSIsInR4dF90ZW1wbGF0ZSIsImlkIiwiZW9sX2lkIiwiYmF0Y2giLCJpbWFnZXNfcGVyX3BhZ2UiLCJpbWFnZXNfcGFnZSIsInZpZGVvc19wZXJfcGFnZSIsInZpZGVvc19wYWdlIiwic291bmRzX3Blcl9wYWdlIiwic291bmRzX3BhZ2UiLCJtYXBzX3Blcl9wYWdlIiwibWFwc19wYWdlIiwidGV4dHNfcGVyX3BhZ2UiLCJ0ZXh0c19wYWdlIiwiaXVjbiIsInN1YmplY3RzIiwibGljZW5zZXMiLCJkZXRhaWxzIiwiY29tbW9uX25hbWVzIiwic3lub255bXMiLCJyZWZlcmVuY2VzIiwidGF4b25vbXkiLCJ2ZXR0ZWQiLCJjYWNoZV90dGwiLCJsYW5ndWFnZSIsImNvbnNvbGUiLCJsb2ciLCJkb2IiLCJsaWNlbnNlIiwicmlnaHRzIiwic291cmNlIiwiaW1nX2VsZW1lbnQiLCJfIiwidGVtcGxhdGUiLCJzcmMiLCJocmVmIiwidGl0bGUiLCJib2R5IiwidHh0X2VsZW1lbnQiLCJnZXRCZXN0VmVybmFjdWxhck5hbWVFT0wiLCJlcnJvciIsImpxWEhSIiwidGV4dFN0YXR1cyIsImVycm9yVGhyb3duIiwic2hvd01lc3NhZ2VEaWFsb2ciLCJhbHdheXMiLCJlbXB0eSIsIm9uIiwidG9nZ2xlIl0sIm1hcHBpbmdzIjoiOzs7OztBQUFBLG1CQUFBQSxDQUFRLDhEQUFSO0FBQ0EsbUJBQUFBLENBQVEscURBQVIsRTs7Ozs7OztBQ0RBOzs7O0FBSUEsU0FBU0Msa0JBQVQsQ0FBNEJDLFVBQTVCLEVBQXdDQyxZQUF4QyxFQUFzREMsV0FBdEQsRUFBa0U7QUFDOURDLE1BQUVDLElBQUYsQ0FBTztBQUNIQyxhQUFLQyxRQUFRQyxRQUFSLENBQWlCLEtBQWpCLEVBQXdCLEVBQUMsYUFBYSxTQUFkLEVBQXlCLGFBQWEsY0FBdEMsRUFBeEIsQ0FERjtBQUVIQyxjQUFNO0FBQ0YseUJBQWFDLFNBRFg7QUFFRiwrQkFBbUJSLFlBRmpCO0FBR0YsNEJBQWdCQztBQUhkLFNBRkg7QUFPSFEsZ0JBQVEsS0FQTDtBQVFIQyxpQkFBUyxpQkFBU0MsTUFBVCxFQUFnQjtBQUNyQlQsY0FBRVUsSUFBRixDQUFPRCxNQUFQLEVBQWUsVUFBVUUsR0FBVixFQUFlQyxLQUFmLEVBQXNCO0FBQ2pDLG9CQUFJQyxZQUFZRCxNQUFNQSxLQUF0QjtBQUNBLG9CQUFHQSxNQUFNQSxLQUFOLEtBQWdCLElBQW5CLEVBQXdCO0FBQ3BCQyxnQ0FBWUQsTUFBTUUsZ0JBQWxCO0FBQ0g7QUFDRCxvQkFBSUMsYUFBYSxFQUFqQjtBQUNBLG9CQUFHSCxNQUFNSSxJQUFOLElBQWMsSUFBakIsRUFBc0I7QUFDbEJELGlDQUFhLE9BQU1ILE1BQU1JLElBQVosR0FBa0IsR0FBL0I7QUFDSDtBQUNELG9CQUFJQyxtQkFBbUJqQixFQUFFLDhCQUFGLEVBQWtDa0IsSUFBbEMsQ0FBdUNOLE1BQU1PLFFBQTdDLEVBQXVEQyxHQUF2RCxDQUEyRCxFQUFDLGFBQWEsTUFBZCxFQUEzRCxDQUF2QjtBQUNBLG9CQUFJQyxZQUFZckIsZ0JBQWNZLE1BQU1VLFVBQXBCLFNBQW9DSixJQUFwQyxDQUF5QyxTQUF6QyxDQUFoQjtBQUNBLG9CQUFHTixNQUFNVSxVQUFOLElBQW9CLEVBQXZCLEVBQTBCO0FBQ3RCTCxxQ0FBaUJNLE1BQWpCLENBQXdCRixTQUF4QjtBQUNIO0FBQ0R4QiwyQkFBVzBCLE1BQVgsQ0FBa0J2QixFQUFFLE9BQUYsRUFBV2tCLElBQVgsQ0FBZ0JMLFlBQVVFLFVBQTFCLEVBQXNDUSxNQUF0QyxDQUE2Q04sZ0JBQTdDLENBQWxCO0FBQ0gsYUFmRDtBQWdCSDtBQXpCRSxLQUFQO0FBMkJIOztBQUVEO0FBQ0FPLE9BQU81QixrQkFBUCxHQUE0QkEsa0JBQTVCLEM7Ozs7Ozs7O0FDbkNBOzs7QUFHQUksRUFBRSxVQUFGLEVBQWN5QixLQUFkLENBQW9CLFlBQVU7QUFDMUIsUUFBSUMsZUFBZSx3SUFBbkI7QUFDQSxRQUFJQyxlQUFlLGtOQUFuQjtBQUNBM0IsTUFBRUMsSUFBRixDQUFPO0FBQ0hNLGdCQUFRLEtBREw7QUFFSEwsYUFBSyxtQ0FGRjtBQUdIRyxjQUFNO0FBQ0Z1QixnQkFBSUMsTUFERjtBQUVGQyxtQkFBTyxLQUZMO0FBR0ZDLDZCQUFpQixDQUhmO0FBSUZDLHlCQUFhLENBSlg7QUFLRkMsNkJBQWlCLENBTGY7QUFNRkMseUJBQWEsQ0FOWDtBQU9GQyw2QkFBaUIsQ0FQZjtBQVFGQyx5QkFBYSxDQVJYO0FBU0ZDLDJCQUFlLENBVGI7QUFVRkMsdUJBQVcsQ0FWVDtBQVdGQyw0QkFBZ0IsQ0FYZDtBQVlGQyx3QkFBWSxDQVpWO0FBYUZDLGtCQUFNLElBYko7QUFjRkMsc0JBQVUsVUFkUjtBQWVGQyxzQkFBVSx3Q0FmUjtBQWdCRkMscUJBQVMsSUFoQlA7QUFpQkZDLDBCQUFjLElBakJaO0FBa0JGQyxzQkFBVSxJQWxCUjtBQW1CRkMsd0JBQVksSUFuQlY7QUFvQkZDLHNCQUFVLElBcEJSO0FBcUJGQyxvQkFBUSxDQXJCTjtBQXNCRkMsdUJBQVcsRUF0QlQ7QUF1QkZDLHNCQUFVO0FBdkJSLFNBSEg7QUE0QkgzQyxpQkFBUyxpQkFBU0MsTUFBVCxFQUFnQjtBQUNyQjJDLG9CQUFRQyxHQUFSLENBQVk1QyxNQUFaO0FBQ0FULGNBQUVVLElBQUYsQ0FBT0QsT0FBTyxhQUFQLENBQVAsRUFBOEIsVUFBVTZDLEdBQVYsRUFBZTtBQUN6QyxvQkFBRzdDLE9BQU8sYUFBUCxFQUFzQjZDLEdBQXRCLEVBQTJCLFVBQTNCLE1BQTJDLHdDQUE5QyxFQUF1RjtBQUNuRix3QkFBSXBELE1BQU1PLE9BQU8sYUFBUCxFQUFzQjZDLEdBQXRCLEVBQTJCLGFBQTNCLENBQVY7QUFDQSx3QkFBSUMsVUFBVTlDLE9BQU8sYUFBUCxFQUFzQjZDLEdBQXRCLEVBQTJCLFNBQTNCLENBQWQ7QUFDQSx3QkFBSUUsU0FBUy9DLE9BQU8sYUFBUCxFQUFzQjZDLEdBQXRCLEVBQTJCLFFBQTNCLENBQWI7QUFDQSx3QkFBRyxPQUFPRSxNQUFQLEtBQWtCLFdBQXJCLEVBQWlDO0FBQzdCQSxpQ0FBUyxRQUFNL0MsT0FBTyxhQUFQLEVBQXNCNkMsR0FBdEIsRUFBMkIsY0FBM0IsQ0FBZjtBQUNIO0FBQ0Qsd0JBQUlHLFNBQVNoRCxPQUFPLGFBQVAsRUFBc0I2QyxHQUF0QixFQUEyQixRQUEzQixDQUFiO0FBQ0Esd0JBQUlJLGNBQWNDLEVBQUVDLFFBQUYsQ0FBV2xDLFlBQVgsRUFBeUIsRUFBQ21DLEtBQUszRCxHQUFOLEVBQVc0RCxNQUFNNUQsR0FBakIsRUFBc0JxRCxTQUFTQSxPQUEvQixFQUF3Q0MsUUFBUUEsTUFBaEQsRUFBd0RDLFFBQVFBLE1BQWhFLEVBQXpCLENBQWxCO0FBQ0F6RCxzQkFBRSxzQkFBRixFQUEwQnVCLE1BQTFCLENBQWlDbUMsV0FBakM7QUFDSDtBQUNELG9CQUFHakQsT0FBTyxhQUFQLEVBQXNCNkMsR0FBdEIsRUFBMkIsVUFBM0IsTUFBMkMsa0NBQTlDLEVBQWlGO0FBQzdFLHdCQUFJUyxRQUFRdEQsT0FBTyxhQUFQLEVBQXNCNkMsR0FBdEIsRUFBMkIsT0FBM0IsQ0FBWjtBQUNBLHdCQUFJVSxPQUFPdkQsT0FBTyxhQUFQLEVBQXNCNkMsR0FBdEIsRUFBMkIsYUFBM0IsQ0FBWDtBQUNBLHdCQUFJcEQsT0FBTU8sT0FBTyxhQUFQLEVBQXNCNkMsR0FBdEIsRUFBMkIsUUFBM0IsQ0FBVjtBQUNBLHdCQUFJQyxXQUFVOUMsT0FBTyxhQUFQLEVBQXNCNkMsR0FBdEIsRUFBMkIsU0FBM0IsQ0FBZDtBQUNBLHdCQUFJRSxVQUFTL0MsT0FBTyxhQUFQLEVBQXNCNkMsR0FBdEIsRUFBMkIsUUFBM0IsQ0FBYjtBQUNBLHdCQUFHLE9BQU9FLE9BQVAsS0FBa0IsV0FBckIsRUFBaUM7QUFDN0JBLGtDQUFTLFFBQU0vQyxPQUFPLGFBQVAsRUFBc0I2QyxHQUF0QixFQUEyQixjQUEzQixDQUFmO0FBQ0g7QUFDRCx3QkFBSVcsY0FBY04sRUFBRUMsUUFBRixDQUFXakMsWUFBWCxFQUF5QixFQUFDb0MsT0FBT0EsS0FBUixFQUFlQyxNQUFNQSxJQUFyQixFQUEyQkYsTUFBTTVELElBQWpDLEVBQXNDc0QsUUFBUUEsT0FBOUMsRUFBc0RELFNBQVNBLFFBQS9ELEVBQXpCLENBQWxCO0FBQ0F2RCxzQkFBRSxzQkFBRixFQUEwQnVCLE1BQTFCLENBQWlDMEMsV0FBakM7QUFDSDtBQUNKLGFBeEJEO0FBeUJBakUsY0FBRSxpQkFBRixFQUFxQmtCLElBQXJCLENBQTBCZ0QseUJBQXlCekQsTUFBekIsQ0FBMUI7QUFDSCxTQXhERTtBQXlESDBELGVBQU8sZUFBVUMsS0FBVixFQUFpQkMsVUFBakIsRUFBNkJDLFdBQTdCLEVBQTBDO0FBQzdDQyw4QkFBa0JELFdBQWxCLEVBQStCLFFBQS9CO0FBQ0g7QUEzREUsS0FBUCxFQTRER0UsTUE1REgsQ0E0RFUsWUFBVTtBQUNoQnhFLFVBQUUsbUJBQUYsRUFBdUJ5RSxLQUF2QjtBQUNILEtBOUREO0FBK0RBekUsTUFBRSx1QkFBRixFQUEyQjBFLEVBQTNCLENBQThCLE9BQTlCLEVBQXVDLFlBQVU7QUFDN0MxRSxVQUFFLGlCQUFGLEVBQXFCMkUsTUFBckI7QUFDSCxLQUZEO0FBR0gsQ0FyRUQsRSIsImZpbGUiOiJvcmdhbmlzbS9kZXRhaWxzLmpzIiwic291cmNlc0NvbnRlbnQiOlsicmVxdWlyZSgnLi9kZXRhaWxzL2FwcGVuZFRyYWl0cy5qc3gnKVxucmVxdWlyZSgnLi9kZXRhaWxzL2VvbC5qc3gnKVxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyAuL2FwcC9SZXNvdXJjZXMvY2xpZW50L2pzeC9vcmdhbmlzbS9kZXRhaWxzLmpzeCIsIi8qKlxuICogQ3JlYXRlZCBieSBzMjE2MTIxIG9uIDE0LjAzLjE3LlxuICovXG5cbmZ1bmN0aW9uIGFwcGVuZFRyYWl0RW50cmllcyhkb21FbGVtZW50LCB0cmFpdEVudHJpZXMsIHRyYWl0Rm9ybWF0KXtcbiAgICAkLmFqYXgoe1xuICAgICAgICB1cmw6IFJvdXRpbmcuZ2VuZXJhdGUoJ2FwaScsIHsnbmFtZXNwYWNlJzogJ2RldGFpbHMnLCAnY2xhc3NuYW1lJzogJ1RyYWl0RW50cmllcyd9KSxcbiAgICAgICAgZGF0YToge1xuICAgICAgICAgICAgXCJkYnZlcnNpb25cIjogZGJ2ZXJzaW9uLFxuICAgICAgICAgICAgXCJ0cmFpdF9lbnRyeV9pZHNcIjogdHJhaXRFbnRyaWVzLFxuICAgICAgICAgICAgXCJ0cmFpdF9mb3JtYXRcIjogdHJhaXRGb3JtYXRcbiAgICAgICAgfSxcbiAgICAgICAgbWV0aG9kOiBcIkdFVFwiLFxuICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbihyZXN1bHQpe1xuICAgICAgICAgICAgJC5lYWNoKHJlc3VsdCwgZnVuY3Rpb24gKGtleSwgdmFsdWUpIHtcbiAgICAgICAgICAgICAgICB2YXIgcmVhbFZhbHVlID0gdmFsdWUudmFsdWU7XG4gICAgICAgICAgICAgICAgaWYodmFsdWUudmFsdWUgPT09IG51bGwpe1xuICAgICAgICAgICAgICAgICAgICByZWFsVmFsdWUgPSB2YWx1ZS52YWx1ZV9kZWZpbml0aW9uO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICBsZXQgdW5pdFN0cmluZyA9IFwiXCJcbiAgICAgICAgICAgICAgICBpZih2YWx1ZS51bml0ICE9IG51bGwpe1xuICAgICAgICAgICAgICAgICAgICB1bml0U3RyaW5nID0gXCIgJFwiKyB2YWx1ZS51bml0ICtcIiRcIlxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICBsZXQgdHJhaXRDaXRhdGlvbkRpdiA9ICQoJzxkaXYgY2xhc3M9XCJ0cmFpdC1jaXRhdGlvblwiPicpLnRleHQodmFsdWUuY2l0YXRpb24pLmNzcyh7J2ZvbnQtc2l6ZSc6ICcxMXB4J30pXG4gICAgICAgICAgICAgICAgbGV0IG9yaWdpblVybCA9ICQoYDxhIGhyZWY9XCIke3ZhbHVlLm9yaWdpbl91cmx9XCI+YCkudGV4dChcIiBvcmlnaW5cIilcbiAgICAgICAgICAgICAgICBpZih2YWx1ZS5vcmlnaW5fdXJsICE9IFwiXCIpe1xuICAgICAgICAgICAgICAgICAgICB0cmFpdENpdGF0aW9uRGl2LmFwcGVuZChvcmlnaW5VcmwpXG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGRvbUVsZW1lbnQuYXBwZW5kKCQoJzxkaXY+JykudGV4dChyZWFsVmFsdWUrdW5pdFN0cmluZykuYXBwZW5kKHRyYWl0Q2l0YXRpb25EaXYpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfSk7XG59XG5cbi8vIGV4cG9ydCBmdW5jdGlvbiBnbG9iYWxseVxuZ2xvYmFsLmFwcGVuZFRyYWl0RW50cmllcyA9IGFwcGVuZFRyYWl0RW50cmllcztcblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gLi9hcHAvUmVzb3VyY2VzL2NsaWVudC9qc3gvb3JnYW5pc20vZGV0YWlscy9hcHBlbmRUcmFpdHMuanN4IiwiLyoqXG4gKiBDcmVhdGVkIGJ5IHMyMTYxMjEgb24gMTQuMDMuMTcuXG4gKi9cbiQoJ2RvY3VtZW50JykucmVhZHkoZnVuY3Rpb24oKXtcbiAgICBsZXQgaW1nX3RlbXBsYXRlID0gJzxhIGNsYXNzPVwidGh1bWJuYWlsXCIgaHJlZj1cIjwlPSBocmVmICU+XCI+PGltZyBzcmM9XCI8JT0gc3JjICU+XCIvPjwvYT48YSBocmVmPVwiPCU9IHNvdXJjZSAlPlwiPjxkaXY+PCU9IHJpZ2h0cyAlPiA8JT0gbGljZW5zZSAlPjwvZGl2PjwvYT4nO1xuICAgIGxldCB0eHRfdGVtcGxhdGUgPSAnPGRpdiBjbGFzcz1cInBhbmVsIHBhbmVsLWRlZmF1bHRcIj48ZGl2IGNsYXNzPVwicGFuZWwtaGVhZGluZ1wiPjxoMyBjbGFzcz1cInBhbmVsLXRpdGxlXCI+PCU9IHRpdGxlICU+PC9oMz48YSBocmVmPVwiPCU9IGhyZWYgJT5cIj48JT0gcmlnaHRzICU+IDwlPSBsaWNlbnNlICU+PC9hPjwvZGl2PjxkaXYgY2xhc3M9XCJwYW5lbC1ib2R5XCI+PCU9IGJvZHkgJT48L2Rpdj48L2Rpdj4nO1xuICAgICQuYWpheCh7XG4gICAgICAgIG1ldGhvZDogXCJHRVRcIixcbiAgICAgICAgdXJsOiBcImh0dHA6Ly9lb2wub3JnL2FwaS9wYWdlcy8xLjAuanNvblwiLFxuICAgICAgICBkYXRhOiB7XG4gICAgICAgICAgICBpZDogZW9sX2lkLFxuICAgICAgICAgICAgYmF0Y2g6IGZhbHNlLFxuICAgICAgICAgICAgaW1hZ2VzX3Blcl9wYWdlOiAzLFxuICAgICAgICAgICAgaW1hZ2VzX3BhZ2U6IDEsXG4gICAgICAgICAgICB2aWRlb3NfcGVyX3BhZ2U6IDAsXG4gICAgICAgICAgICB2aWRlb3NfcGFnZTogMSxcbiAgICAgICAgICAgIHNvdW5kc19wZXJfcGFnZTogMCxcbiAgICAgICAgICAgIHNvdW5kc19wYWdlOiAxLFxuICAgICAgICAgICAgbWFwc19wZXJfcGFnZTogMCxcbiAgICAgICAgICAgIG1hcHNfcGFnZTogMSxcbiAgICAgICAgICAgIHRleHRzX3Blcl9wYWdlOiAzLFxuICAgICAgICAgICAgdGV4dHNfcGFnZTogMSxcbiAgICAgICAgICAgIGl1Y246IHRydWUsXG4gICAgICAgICAgICBzdWJqZWN0czogXCJvdmVydmlld1wiLFxuICAgICAgICAgICAgbGljZW5zZXM6IFwiY2MtYnl8Y2MtYnktbmN8Y2MtYnktc2F8Y2MtYnktbmMtc2F8cGRcIixcbiAgICAgICAgICAgIGRldGFpbHM6IHRydWUsXG4gICAgICAgICAgICBjb21tb25fbmFtZXM6IHRydWUsXG4gICAgICAgICAgICBzeW5vbnltczogdHJ1ZSxcbiAgICAgICAgICAgIHJlZmVyZW5jZXM6IHRydWUsXG4gICAgICAgICAgICB0YXhvbm9teTogdHJ1ZSxcbiAgICAgICAgICAgIHZldHRlZDogMCxcbiAgICAgICAgICAgIGNhY2hlX3R0bDogNjAsXG4gICAgICAgICAgICBsYW5ndWFnZTogXCJlblwiXG4gICAgICAgIH0sXG4gICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uKHJlc3VsdCl7XG4gICAgICAgICAgICBjb25zb2xlLmxvZyhyZXN1bHQpO1xuICAgICAgICAgICAgJC5lYWNoKHJlc3VsdFtcImRhdGFPYmplY3RzXCJdLCBmdW5jdGlvbiAoZG9iKSB7XG4gICAgICAgICAgICAgICAgaWYocmVzdWx0W1wiZGF0YU9iamVjdHNcIl1bZG9iXVtcImRhdGFUeXBlXCJdID09PSBcImh0dHA6Ly9wdXJsLm9yZy9kYy9kY21pdHlwZS9TdGlsbEltYWdlXCIpe1xuICAgICAgICAgICAgICAgICAgICBsZXQgdXJsID0gcmVzdWx0W1wiZGF0YU9iamVjdHNcIl1bZG9iXVtcImVvbE1lZGlhVVJMXCJdO1xuICAgICAgICAgICAgICAgICAgICBsZXQgbGljZW5zZSA9IHJlc3VsdFtcImRhdGFPYmplY3RzXCJdW2RvYl1bXCJsaWNlbnNlXCJdO1xuICAgICAgICAgICAgICAgICAgICBsZXQgcmlnaHRzID0gcmVzdWx0W1wiZGF0YU9iamVjdHNcIl1bZG9iXVtcInJpZ2h0c1wiXTtcbiAgICAgICAgICAgICAgICAgICAgaWYodHlwZW9mIHJpZ2h0cyA9PT0gJ3VuZGVmaW5lZCcpe1xuICAgICAgICAgICAgICAgICAgICAgICAgcmlnaHRzID0gXCIoYylcIityZXN1bHRbXCJkYXRhT2JqZWN0c1wiXVtkb2JdW1wicmlnaHRzSG9sZGVyXCJdO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIGxldCBzb3VyY2UgPSByZXN1bHRbXCJkYXRhT2JqZWN0c1wiXVtkb2JdW1wic291cmNlXCJdO1xuICAgICAgICAgICAgICAgICAgICBsZXQgaW1nX2VsZW1lbnQgPSBfLnRlbXBsYXRlKGltZ190ZW1wbGF0ZSkoe3NyYzogdXJsLCBocmVmOiB1cmwsIGxpY2Vuc2U6IGxpY2Vuc2UsIHJpZ2h0czogcmlnaHRzLCBzb3VyY2U6IHNvdXJjZX0pO1xuICAgICAgICAgICAgICAgICAgICAkKCcjb3JnYW5pc20taW1nLWNvbHVtbicpLmFwcGVuZChpbWdfZWxlbWVudCk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGlmKHJlc3VsdFtcImRhdGFPYmplY3RzXCJdW2RvYl1bXCJkYXRhVHlwZVwiXSA9PT0gXCJodHRwOi8vcHVybC5vcmcvZGMvZGNtaXR5cGUvVGV4dFwiKXtcbiAgICAgICAgICAgICAgICAgICAgbGV0IHRpdGxlID0gcmVzdWx0W1wiZGF0YU9iamVjdHNcIl1bZG9iXVtcInRpdGxlXCJdO1xuICAgICAgICAgICAgICAgICAgICBsZXQgYm9keSA9IHJlc3VsdFtcImRhdGFPYmplY3RzXCJdW2RvYl1bXCJkZXNjcmlwdGlvblwiXTtcbiAgICAgICAgICAgICAgICAgICAgbGV0IHVybCA9IHJlc3VsdFtcImRhdGFPYmplY3RzXCJdW2RvYl1bXCJzb3VyY2VcIl07XG4gICAgICAgICAgICAgICAgICAgIGxldCBsaWNlbnNlID0gcmVzdWx0W1wiZGF0YU9iamVjdHNcIl1bZG9iXVtcImxpY2Vuc2VcIl07XG4gICAgICAgICAgICAgICAgICAgIGxldCByaWdodHMgPSByZXN1bHRbXCJkYXRhT2JqZWN0c1wiXVtkb2JdW1wicmlnaHRzXCJdO1xuICAgICAgICAgICAgICAgICAgICBpZih0eXBlb2YgcmlnaHRzID09PSAndW5kZWZpbmVkJyl7XG4gICAgICAgICAgICAgICAgICAgICAgICByaWdodHMgPSBcIihjKVwiK3Jlc3VsdFtcImRhdGFPYmplY3RzXCJdW2RvYl1bXCJyaWdodHNIb2xkZXJcIl07XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgbGV0IHR4dF9lbGVtZW50ID0gXy50ZW1wbGF0ZSh0eHRfdGVtcGxhdGUpKHt0aXRsZTogdGl0bGUsIGJvZHk6IGJvZHksIGhyZWY6IHVybCwgcmlnaHRzOiByaWdodHMsIGxpY2Vuc2U6IGxpY2Vuc2V9KTtcbiAgICAgICAgICAgICAgICAgICAgJCgnI29yZ2FuaXNtLXR4dC1jb2x1bW4nKS5hcHBlbmQodHh0X2VsZW1lbnQpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgJChcIiN2ZXJuYWN1bGFyTmFtZVwiKS50ZXh0KGdldEJlc3RWZXJuYWN1bGFyTmFtZUVPTChyZXN1bHQpKTtcbiAgICAgICAgfSxcbiAgICAgICAgZXJyb3I6IGZ1bmN0aW9uIChqcVhIUiwgdGV4dFN0YXR1cywgZXJyb3JUaHJvd24pIHtcbiAgICAgICAgICAgIHNob3dNZXNzYWdlRGlhbG9nKGVycm9yVGhyb3duLCAnZGFuZ2VyJyk7XG4gICAgICAgIH1cbiAgICB9KS5hbHdheXMoZnVuY3Rpb24oKXtcbiAgICAgICAgJCgnI2xvYWRpbmctcHJvZ3Jlc3MnKS5lbXB0eSgpO1xuICAgIH0pO1xuICAgICQoXCIjdG9nZ2xlQ2l0YXRpb25CdXR0b25cIikub24oXCJjbGlja1wiLCBmdW5jdGlvbigpe1xuICAgICAgICAkKFwiLnRyYWl0LWNpdGF0aW9uXCIpLnRvZ2dsZSgpO1xuICAgIH0pXG59KTtcblxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyAuL2FwcC9SZXNvdXJjZXMvY2xpZW50L2pzeC9vcmdhbmlzbS9kZXRhaWxzL2VvbC5qc3giXSwic291cmNlUm9vdCI6IiJ9