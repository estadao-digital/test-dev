Object.entries = Object.entries ? Object.entries : function(obj) {
    var allowedTypes = ["[object String]", "[object Object]", "[object Array]", "[object Function]"];
    var objType = Object.prototype.toString.call(obj);

    if(obj === null || typeof obj === "undefined") {
        throw new TypeError("Cannot convert undefined or null to object");
    } else if(!~allowedTypes.indexOf(objType)) {
        return [];
    } else {
        // if ES6 is supported
        if (Object.keys) {
            return Object.keys(obj).map(function (key) {
                return [key, obj[key]];
            });
        }
        var result = [];
        for (var prop in obj) {
            if(obj.hasOwnProperty(prop)) {
                result.push([prop, obj[prop]]);
            }
        }

        return objType === "[object Array]" ? result : result.sort(function(a, b) {return a[1]-b[1];});
    }
};

if (typeof module !== 'undefined' && module.exports) {
    module.exports = Object.entries;
}

