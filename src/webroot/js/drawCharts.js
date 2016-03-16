function drawHistogram(){
    var cvterm_id = $("#cvterm_id").val();
    $.ajax({
        url: WebRoot.concat("/ajax/details/Traits"),
        data: {type_cvterm_id: cvterm_id},
        dataType: "json",
        success: function (data) {
            if(data['value_type'] === 'value'){
                var data = data['value'];
                $.each(data, function(key, value){
                    var plot_data = [{
                            x: value,
                            type: 'histogram'
                        }];
                    Plotly.newPlot('histogram', plot_data);
                });
            }
        }
    });
}

function drawPieChart(){
    var cvterm_id = $("#cvterm_id").val();
    $.ajax({
        url: WebRoot.concat("/ajax/details/Traits"),
        data: {type_cvterm_id: cvterm_id},
        dataType: "json",
        success: function (data) {
            var plot = [{
                    values: data['value']['frequency'],
                    labels: data['value']['labels'],
                    type: 'pie'
            }];
            var layout = {
                height: 700,
                width: 800
            };
            Plotly.newPlot('pieChart', plot, layout);
        }
    });
}

function drawMap(){
    var cvterm_id = $("#cvterm_id").val();
    $.ajax({
        url: WebRoot.concat("/ajax/details/Traits"),
        data: {type_cvterm_id: cvterm_id},
        dataType: "json",
        success: function (data) {
//           csvMap = generateGeographicMap(data);
            Plotly.d3.csv(WebRoot.concat("/test.csv"), function(err, rows){
                function unpack(rows, key) {
                    return rows.map(function(row) { return row[key]; });
                }

                var plot = [{
                    type: 'choropleth',
                    locationmode: 'country names',
                    locations: unpack(rows, 'labels'),
                    z: unpack(rows, 'frequency'),
                    text: unpack(rows, 'labels'),
                    autocolorscale: true
                }];

                var layout = {
                  title: 'Geographic distribution',
                  geo: {
                      projection: {
                          type: 'robinson'
                      }
                  },
                  height: 700,
                  width: 1000
                };

                Plotly.plot(map, plot, layout, {showLink: false});
            });
        }
    });
}



