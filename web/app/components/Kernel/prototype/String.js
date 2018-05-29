(function () {
    'use strict';

    String.prototype.pad = __pad;

    function __pad (pad, direction) {
        if (typeof pad !== 'string') {
            throw new Error('String::pad: typeof parameter pad must be string');
        }

        var padded = pad.substring(0, pad.length - this.length);
        if (direction === 'right') {
            return this + padded;
        }

        return padded + this;
    }
})();
