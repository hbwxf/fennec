const biomPromise = require('./biom')

let biom
let getBiom = async () => {
    biom = await biomPromise
}
getBiom()

$('document').ready(() => {
    $('#project-explore-otu-metadata').click(() => {
        initTable('rows', 'observation-metadata-table')
    })
    $('#project-explore-sample-metadata').click(() => {
        initTable('columns', 'sample-metadata-table')
    })
});

const tableConfig = {
    order: [1, "desc"],
    dom: 'Bfrtip',
    buttons: [
        'colvis'
    ],
    scrollX: true,
}

const getTableData = (dimension) => {
    if(dimension !== 'columns' && dimension !== 'rows'){
        return [[],[]]
    }
    let dimMetadata = biom[dimension].map(x => {
        let key = (dimension === 'columns' ? 'Sample ID' : 'OTU ID')
        let metadata = {}
        metadata[key] =  x.id
        if(dimension === 'columns'){
            metadata["Total Count"] = _.sum(biom.getDataColumn(x.id))
        } else {
            metadata["Total Count"] = _.sum(biom.getDataRow(x.id))
        }
        for(let m of Object.keys(x.metadata)){
            if(m === 'fennec'){
                continue;
            }
            metadata[m] = x.metadata[m]
        }
        return metadata
    })
    let columns = Object.keys(dimMetadata[0]).map(x => ({data: x, title: x}))
    return [dimMetadata, columns]
}

const initTable = (dimension, id) => {
    $('#metadata-table-progress').show()
    // The timeout is used to make the busy indicator show up before the heavy computation starts
    // Web workers are a better solution to achieve this goal and avoid hanging of the interface in the future
    window.setTimeout(() => {
        let [metadata, columns] = getTableData(dimension)
        $(`#${id}`).DataTable(Object.assign({}, tableConfig, {
            data: metadata,
            columns: columns,
        }));
        $('#metadata-table-progress').hide()
    }, 5)
}