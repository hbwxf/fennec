-- custom input data
INSERT INTO full_webuser_data (project,oauth_id,provider,import_date,import_filename) VALUES ('{
    "id": "table_1",
    "format": "Biological Observation Matrix 2.1.0",
    "format_url": "http://biom-format.org",
    "matrix_type": "sparse",
    "generated_by": "BIOM-Format 2.1",
    "date": "2016-05-03T08:13:41.848780",
    "type": "OTU table",
    "matrix_element_type": "float",
    "shape": [10, 5],
    "data": [[0,0,120.0],[3,1,12.0],[5,2,20.0],[7,3,12.7],[8,4,16.0]],
    "rows": [
        {"id": "OTU_1", "metadata": {}},
        {"id": "OTU_2", "metadata": {}},
        {"id": "OTU_3", "metadata": {}},
        {"id": "OTU_4", "metadata": {}},
        {"id": "OTU_5", "metadata": {}},
        {"id": "OTU_6", "metadata": {}},
        {"id": "OTU_7", "metadata": {}},
        {"id": "OTU_8", "metadata": {}},
        {"id": "OTU_9", "metadata": {}},
        {"id": "OTU_10", "metadata": {}}
    ],
    "columns": [
        {"id": "Sample_1", "metadata": {}},
        {"id": "Sample_2", "metadata": {}},
        {"id": "Sample_3", "metadata": {}},
        {"id": "Sample_4", "metadata": {}},
        {"id": "Sample_5", "metadata": {}}
    ]
}','listingProjectsTestUser','listingProjectsTestUser','2016-05-17 10:00:52.627236+00','listingProjectsTestFile.biom');

-- dataset for ProjectRemoveTest
INSERT INTO full_webuser_data (project,oauth_id,provider,import_date) VALUES ('{
    "id": "table_1",
    "format": "Biological Observation Matrix 2.1.0",
    "format_url": "http://biom-format.org",
    "matrix_type": "sparse",
    "generated_by": "BIOM-Format 2.1",
    "date": "2016-05-03T08:13:41.848780",
    "type": "OTU table",
    "matrix_element_type": "float",
    "shape": [10, 5],
    "data": [[0,0,120.0],[3,1,12.0],[5,2,20.0],[7,3,12.7],[8,4,16.0]],
    "rows": [
        {"id": "OTU_1", "metadata": {}},
        {"id": "OTU_2", "metadata": {}},
        {"id": "OTU_3", "metadata": {}},
        {"id": "OTU_4", "metadata": {}},
        {"id": "OTU_5", "metadata": {}},
        {"id": "OTU_6", "metadata": {}},
        {"id": "OTU_7", "metadata": {}},
        {"id": "OTU_8", "metadata": {}},
        {"id": "OTU_9", "metadata": {}},
        {"id": "OTU_10", "metadata": {}}
    ],
    "columns": [
        {"id": "Sample_1", "metadata": {}},
        {"id": "Sample_2", "metadata": {}},
        {"id": "Sample_3", "metadata": {}},
        {"id": "Sample_4", "metadata": {}},
        {"id": "Sample_5", "metadata": {}}
    ]
}','ProjectRemoveTestUser','ProjectRemoveTestUser','2016-05-17 10:00:52.627236+00');

-- dataset for DetailsProjectsTest
INSERT INTO full_webuser_data (project,oauth_id,provider,import_date) VALUES ('{
    "id": "table_1",
    "format": "Biological Observation Matrix 2.1.0",
    "format_url": "http://biom-format.org",
    "matrix_type": "sparse",
    "generated_by": "BIOM-Format 2.1",
    "date": "2016-05-03T08:13:41.848780",
    "type": "OTU table",
    "matrix_element_type": "float",
    "shape": [10, 5],
    "data": [[0,0,120.0],[3,1,12.0],[5,2,20.0],[7,3,12.7],[8,4,16.0]],
    "rows": [
        {"id": "OTU_1", "metadata": {}},
        {"id": "OTU_2", "metadata": {}},
        {"id": "OTU_3", "metadata": {}},
        {"id": "OTU_4", "metadata": {}},
        {"id": "OTU_5", "metadata": {}},
        {"id": "OTU_6", "metadata": {}},
        {"id": "OTU_7", "metadata": {}},
        {"id": "OTU_8", "metadata": {}},
        {"id": "OTU_9", "metadata": {}},
        {"id": "OTU_10", "metadata": {}}
    ],
    "columns": [
        {"id": "Sample_1", "metadata": {}},
        {"id": "Sample_2", "metadata": {}},
        {"id": "Sample_3", "metadata": {}},
        {"id": "Sample_4", "metadata": {}},
        {"id": "Sample_5", "metadata": {}}
    ]
}','detailsProjectsTestUser','detailsProjectsTestUser','2016-05-17 10:00:52.627236+00');

-- custom input data
INSERT INTO full_webuser_data (project,oauth_id,provider,import_date) VALUES ('{
    "id": "table_2",
    "format": "Biological Observation Matrix 2.1.0",
    "format_url": "http://biom-format.org",
    "matrix_type": "sparse",
    "generated_by": "BIOM-Format 2.1",
    "date": "2016-05-03T08:13:41.848780",
    "type": "OTU table",
    "matrix_element_type": "float",
    "shape": [5, 2],
    "data": [[0,0,120.0],[3,1,12.0],[5,2,20.0],[7,3,12.7],[8,4,16.0]],
    "rows": [
        {"id": "OTU_1", "metadata": {}},
        {"id": "OTU_2", "metadata": {}},
        {"id": "OTU_3", "metadata": {}},
        {"id": "OTU_4", "metadata": {}},
        {"id": "OTU_5", "metadata": {}}
    ],
    "columns": [
        {"id": "Sample_1", "metadata": {}},
        {"id": "Sample_2", "metadata": {}}
    ]
}','detailsProjectsTestUser','detailsProjectsTestUser','2016-05-17 10:00:52.627236+00');

-- project for listingOverviewTestUser
INSERT INTO full_webuser_data (project,oauth_id,provider,import_date) VALUES ('{
    "id": "table",
    "format": "Biological Observation Matrix 2.1.0",
    "format_url": "http://biom-format.org",
    "matrix_type": "sparse",
    "generated_by": "BIOM-Format 2.1",
    "date": "2016-10-06T08:07:40.838383",
    "type": "OTU table",
    "matrix_element_type": "float",
    "shape": [5, 2],
    "data": [[0,0,120.0],[3,1,12.0],[5,2,20.0],[7,3,12.7],[8,4,16.0]],
    "rows": [
        {"id": "OTU_1", "metadata": {}},
        {"id": "OTU_2", "metadata": {}},
        {"id": "OTU_3", "metadata": {}},
        {"id": "OTU_4", "metadata": {}},
        {"id": "OTU_5", "metadata": {}}
    ],
    "columns": [
        {"id": "Sample_1", "metadata": {}},
        {"id": "Sample_2", "metadata": {}}
    ]
}','listingOverviewTestUser','listingOverviewTestUser','2016-10-06 08:07:40.838383+00');

-- project for listingOverviewTestUser
INSERT INTO full_webuser_data (project,oauth_id,provider,import_date) VALUES ('{
    "id": "table",
    "format": "Biological Observation Matrix 2.1.0",
    "format_url": "http://biom-format.org",
    "matrix_type": "sparse",
    "generated_by": "BIOM-Format 2.1",
    "date": "2016-10-06T08:07:40.838383",
    "type": "OTU table",
    "matrix_element_type": "float",
    "shape": [5, 2],
    "data": [[0,0,120.0],[3,1,12.0],[5,2,20.0],[7,3,12.7],[8,4,16.0]],
    "rows": [
        {"id": "OTU_1", "metadata": {"fennec_organism_id": null}},
        {"id": "OTU_2", "metadata": {"fennec_organism_id": 3}},
        {"id": "OTU_3", "metadata": {}},
        {"id": "OTU_4", "metadata": {"fennec_organism_id": 3}},
        {"id": "OTU_5", "metadata": {"fennec_organism_id": 42}}
    ],
    "columns": [
        {"id": "Sample_1", "metadata": {}},
        {"id": "Sample_2", "metadata": {}}
    ]
}','detailsOrganismsOfProjectTestUser','detailsOrganismsOfProjectTestUser','2016-10-06 08:07:40.838383+00');

-- project for detailsTraitOfProjectTestUser
INSERT INTO full_webuser_data (project,oauth_id,provider,import_date) VALUES ('{
    "id": "table",
    "format": "Biological Observation Matrix 2.1.0",
    "format_url": "http://biom-format.org",
    "matrix_type": "sparse",
    "generated_by": "BIOM-Format 2.1",
    "date": "2016-10-06T08:07:40.838383",
    "type": "OTU table",
    "matrix_element_type": "float",
    "shape": [5, 2],
    "data": [[0,0,120.0],[3,1,12.0],[5,2,20.0],[7,3,12.7],[8,4,16.0]],
    "rows": [
        {"id": "OTU_1", "metadata": {"fennec_organism_id": 134097}},
        {"id": "OTU_2", "metadata": {"fennec_organism_id": 163840}},
        {"id": "OTU_3", "metadata": {"fennec_organism_id": 24718}},
        {"id": "OTU_4", "metadata": {"fennec_organism_id": 73023}},
        {"id": "OTU_5", "metadata": {"fennec_organism_id": 23057}}
    ],
    "columns": [
        {"id": "Sample_1", "metadata": {}},
        {"id": "Sample_2", "metadata": {}}
    ]
}','detailsTraitOfProjectTestUser','detailsTraitOfProjectTestUser','2016-10-06 08:07:40.838383+00');


-- project for detailsTraitOfProjectTestUser
INSERT INTO full_webuser_data (project,oauth_id,provider,import_date) VALUES ('{
    "id": "Original ID",
    "format": "Biological Observation Matrix 2.1.0",
    "format_url": "http://biom-format.org",
    "matrix_type": "sparse",
    "generated_by": "BIOM-Format 2.1",
    "date": "2016-10-06T08:07:40.838383",
    "type": "OTU table",
    "matrix_element_type": "float",
    "shape": [5, 2],
    "data": [[0,0,120.0],[3,1,12.0],[5,2,20.0],[7,3,12.7],[8,4,16.0]],
    "rows": [
        {"id": "OTU_1", "metadata": {"fennec_organism_id": 134097}},
        {"id": "OTU_2", "metadata": {"fennec_organism_id": 163840}},
        {"id": "OTU_3", "metadata": {"fennec_organism_id": 24718}},
        {"id": "OTU_4", "metadata": {"fennec_organism_id": 73023}},
        {"id": "OTU_5", "metadata": {"fennec_organism_id": 23057}}
    ],
    "columns": [
        {"id": "Sample_1", "metadata": {}},
        {"id": "Sample_2", "metadata": {}}
    ]
}','UpdateProjectTestUser','UpdateProjectTestUser','2016-10-06 08:07:40.838383+00');