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
      }
    },
    "version": "0.8.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"fennec_id\": 22457,\n  \"scientific_name\": \"Bellis perennis\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "src/AppBundle/API/Listing/Organisms.php",
    "groupTitle": "Listing"
  },
  {
    "type": "get",
    "url": "/listing/overview",
    "title": "Overview",
    "name": "ListingOverview",
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
      }
    },
    "version": "0.8.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"projects\": 0,\n  \"organisms\": 1400000,\n  \"trait_entries\": 200000,\n  \"trait_types\": 30,\n}",
          "type": "json"
        }
      ]
    },
    "filename": "src/AppBundle/API/Listing/Overview.php",
    "groupTitle": "Listing"
  }
] });
