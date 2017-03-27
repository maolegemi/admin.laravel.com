define(function() {
    myFunction = {
        format: function(str, step, splitor) {
            str = str.toString();
            var len = str.length;
            if (len > step) {
                var l1 = len % step,
                    l2 = parseInt(len / step),
                    arr = [],
                    first = str.substr(0, l1);
                if (first != '') {
                    arr.push(first);
                };
                for (var i = 0; i < l2; i++) {
                    arr.push(str.substr(l1 + i * step, step));
                };
                str = arr.join(splitor);
            };
            return str;
        }
    }
    return myFunction;
});