window._restoreLog = null;
if (window.log !== null && window.log !== undefined)
    window._restoreLog = window.log;

(function() {
    var ffSupport, formats, getOrderedMatches, hasMatches, isFF, isIE, isOpera, isSafari, log, makeArray, operaSupport, safariSupport, stringToArgs, _log;
    if (!(window.console && window.console.log)) {
        return;
    }
    log = function() {
        var args;
        args = [];
        makeArray(arguments).forEach(function(arg) {
            if (typeof arg === 'string') {
                return args = args.concat(stringToArgs(arg));
            } else {
                return args.push(arg);
            }
        });
        return _log.apply(window, args);
    };
    _log = function() {
        return console.log.apply(console, makeArray(arguments));
    };
    makeArray = function(arrayLikeThing) {
        return Array.prototype.slice.call(arrayLikeThing);
    };
    formats = [
        {
            regex: /\*([^\*]+)\*/,
            replacer: function(m, p1) {
                return "%c" + p1 + "%c";
            },
            styles: function() {
                return ['font-style: italic', ''];
            }
        }, {
            regex: /\_([^\_]+)\_/,
            replacer: function(m, p1) {
                return "%c" + p1 + "%c";
            },
            styles: function() {
                return ['font-weight: bold', ''];
            }
        }, {
            regex: /\`([^\`]+)\`/,
            replacer: function(m, p1) {
                return "%c" + p1 + "%c";
            },
            styles: function() {
                return ['background: rgb(255, 255, 219); padding: 1px 5px; border: 1px solid rgba(0, 0, 0, 0.1)', ''];
            }
        }, {
            regex: /\[c\=(?:\"|\')?((?:(?!(?:\"|\')\]).)*)(?:\"|\')?\]((?:(?!\[c\]).)*)\[c\]/,
            replacer: function(m, p1, p2) {
                return "%c" + p2 + "%c";
            },
            styles: function(match) {
                return [match[1], ''];
            }
        }
    ];
    hasMatches = function(str) {
        var _hasMatches;
        _hasMatches = false;
        formats.forEach(function(format) {
            if (format.regex.test(str)) {
                return _hasMatches = true;
            }
        });
        return _hasMatches;
    };
    getOrderedMatches = function(str) {
        var matches;
        matches = [];
        formats.forEach(function(format) {
            var match;
            match = str.match(format.regex);
            if (match) {
                return matches.push({
                    format: format,
                    match: match
                });
            }
        });
        return matches.sort(function(a, b) {
            return a.match.index - b.match.index;
        });
    };
    stringToArgs = function(str) {
        var firstMatch, matches, styles;
        styles = [];
        while (hasMatches(str)) {
            matches = getOrderedMatches(str);
            firstMatch = matches[0];
            str = str.replace(firstMatch.format.regex, firstMatch.format.replacer);
            styles = styles.concat(firstMatch.format.styles(firstMatch.match));
        }
        return [str].concat(styles);
    };
    isSafari = function() {
        return /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
    };
    isOpera = function() {
        return /OPR/.test(navigator.userAgent) && /Opera/.test(navigator.vendor);
    };
    isFF = function() {
        return /Firefox/.test(navigator.userAgent);
    };
    isIE = function() {
        return /MSIE/.test(navigator.userAgent);
    };
    safariSupport = function() {
        var m;
        m = navigator.userAgent.match(/AppleWebKit\/(\d+)\.(\d+)(\.|\+|\s)/);
        if (!m) {
            return false;
        }
        return 537.38 <= parseInt(m[1], 10) + (parseInt(m[2], 10) / 100);
    };
    operaSupport = function() {
        var m;
        m = navigator.userAgent.match(/OPR\/(\d+)\./);
        if (!m) {
            return false;
        }
        return 15 <= parseInt(m[1], 10);
    };
    ffSupport = function() {
        return window.console.firebug || window.console.exception;
    };
    if (isIE() || (isFF() && !ffSupport()) || (isOpera() && !operaSupport()) || (isSafari() && !safariSupport())) {
        window.log = _log;
    } else {
        window.log = log;
    }
    window.log.l = _log;
}).call(this);


window.logKB = window.log;
window.log = undefined;
if (window._restoreLog !== null)
    window.log = window._restoreLog;
window._restoreLog = undefined;

window.dump = console.log;

window.dumpEx = function(value, styleData)
{
    if (styleData === null || styleData === undefined)
        styleData = false;

    if (styleData === false) { console.log(value); return null; }
    if (styleData === true)  { logKB(value); return null; }

    var mountLog = ("[c=\"" + styleData + "\"]" + value + "[c]");
    logKB(mountLog);
};

dumpEx("POWERED BY KRUPABOX", "font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; color: #ff4900; font-size: 40px; padding: 5px 5px; border-radius: 5px; line-height: 40px; text-shadow: 0 1px #000");

// window.console.error = function(value)
// {
//     console.log("error: " + value);
// };