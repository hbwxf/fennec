'use strict';

function condenseTraitValues(organismsByValue) {
    var valueByOrganism = {};
    var _iteratorNormalCompletion = true;
    var _didIteratorError = false;
    var _iteratorError = undefined;

    try {
        for (var _iterator = Object.keys(organismsByValue).sort()[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
            var key = _step.value;

            var value = organismsByValue[key];
            var _iteratorNormalCompletion2 = true;
            var _didIteratorError2 = false;
            var _iteratorError2 = undefined;

            try {
                for (var _iterator2 = value[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
                    var organism = _step2.value;

                    if (organism in valueByOrganism) {
                        valueByOrganism[organism] += '/' + key;
                    } else {
                        valueByOrganism[organism] = key;
                    }
                }
            } catch (err) {
                _didIteratorError2 = true;
                _iteratorError2 = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion2 && _iterator2.return) {
                        _iterator2.return();
                    }
                } finally {
                    if (_didIteratorError2) {
                        throw _iteratorError2;
                    }
                }
            }
        }
    } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
    } finally {
        try {
            if (!_iteratorNormalCompletion && _iterator.return) {
                _iterator.return();
            }
        } finally {
            if (_didIteratorError) {
                throw _iteratorError;
            }
        }
    }

    return valueByOrganism;
}
"use strict";

/**
 * Selects the best vernacularName from the object returned by the eol pages API.
 * It only considers english names (language: en) and preferes those with eol_preferred: true.
 * The scientificName is used as fallback.
 * @param eolObject {Object} object returned by the eol pages API
 * @returns {String} bestName
 */
function getBestVernacularNameEOL(eolObject) {
    var bestName = "";
    if (typeof eolObject.scientificName !== "undefined") {
        bestName = eolObject.scientificName;
    }
    if (typeof eolObject.vernacularNames !== "undefined" && eolObject.vernacularNames.length > 0) {
        var preferred = false;
        eolObject.vernacularNames.forEach(function (value) {
            if (value.language === "en") {
                if (typeof value.eol_preferred !== "undefined" && value.eol_preferred) {
                    preferred = true;
                    bestName = value.vernacularName;
                } else if (!preferred) {
                    bestName = value.vernacularName;
                }
            }
        });
    }
    return bestName;
};