$(document).ready(function(){
    //autocomplete for trait search
     $("#search_trait").autocomplete({
        position: {
           my: "right top", at: "right bottom"
        },
        source: function (request, response) {
            var search = request.term;
            $.ajax({
                url: WebRoot.concat("/ajax/listing/Traits"),
                data: {term:  request.term, search: search, limit: 500},
                dataType: "json",
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 3
    });

    $("#search_trait").data("ui-autocomplete")._renderItem = function (ul, item) {
        var li = $("<li>")
                .append("<a href='"+WebRoot+"/trait/details/byId/"+item.type_cvterm_id+"' class='fancybox' data-fancybox-type='ajax'><span style='display:inline-block; width: 100%; font-style: italic;'>" + item.name + "</span></a>")
                .appendTo(ul);
        return li;
    };
});

