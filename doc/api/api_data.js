define({ "api": [
  {
    "type": "get",
    "url": "/listing/organisms",
    "title": "Organisms",
    "name": "ListingOrganisms",
    "group": "Listing",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "dbversion",
            "description": "<p>Version of the internal fennec database</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "limit",
            "defaultValue": "5",
            "description": "<p>Limit number of results</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "search",
            "description": "<p>Only return organisms where the scientific name matches this string (case insensitive)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\n  \"dbversion\": \"1.0\",\n  \"limit\": 2,\n  \"search\": \"Bellis perennis\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.8.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n[{\n  \"fennec_id\": 22457,\n  \"scientific_name\": \"Bellis perennis\"\n}]",
          "type": "json"
        }
      ],
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "results",
            "description": "<p>Array of result objects. Each result has keys fennec_id and scientific_name</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl http://fennec.molecular.eco/api/listing/organisms?dbversion=1.0&limit=1&search=bellis",
        "type": "curl"
      }
    ],
    "sampleRequest": [
      {
        "url": "http://fennec.molecular.eco/api/listing/organisms"
      }
    ],
    "filename": "src/AppBundle/API/Listing/Organisms.php",
    "groupTitle": "Listing"
  },
  {
    "type": "get",
    "url": "/listing/overview",
    "title": "Overview",
    "name": "ListingOverview",
    "description": "<p>This returns an object containing the number of elements in the database, split by organisms, projects and traits.</p>",
    "group": "Listing",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "dbversion",
            "description": "<p>Version of the internal fennec database</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\n  \"dbversion\": \"1.0\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.8.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"projects\": 0,\n  \"organisms\": 1400000,\n  \"trait_entries\": 200000,\n  \"trait_types\": 30,\n}",
          "type": "json"
        }
      ],
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "projects",
            "description": "<p>Number of projects for the current user.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "organisms",
            "description": "<p>Number of organisms in the database.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "trait_entries",
            "description": "<p>Number of total trait entries in the database.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "trait_types",
            "description": "<p>Number of distinct trait types in the database.</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl http://fennec.molecular.eco/api/listing/overview?dbversion=1.0",
        "type": "curl"
      }
    ],
    "sampleRequest": [
      {
        "url": "http://fennec.molecular.eco/api/listing/overview"
      }
    ],
    "filename": "src/AppBundle/API/Listing/Overview.php",
    "groupTitle": "Listing"
  }
] });
