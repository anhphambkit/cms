window.removeItemByPropertyInArray = function(arrayNeedRemove, valueProperty, property = 'id') {
    // Remove item just added
    for (var i = 0; i < arrayNeedRemove.length; i++) {
        if (arrayNeedRemove[i][property] == valueProperty) {
            arrayNeedRemove.splice(i, 1);
            break;
        }
    }
    return arrayNeedRemove;
}

window.getPropertyOfAttribute = function(arraySource, valuePropertyCheck, propertyCheck = 'id', propertyGet = 'slug') {
    for (var i = 0; i < arraySource.length; i++) {
        if (arraySource[i][propertyCheck] == valuePropertyCheck) {
            return arraySource[i][propertyGet];
        }
    }
}

window.createVariantItemFromAttributes = function () {
    let r = [];
    if (arguments.length > 0) {
        let arg = arguments, max = arg.length-1;
        function helper(arr, i) {
            for (var j=0, l=arg[i].length; j<l; j++) {
                var a = arr.slice(0); // clone arr
                a.push(arg[i][j])
                if (i==max) {
                    r.push(a);
                } else
                    helper(a, i+1);
            }
        }
        helper([], 0);
    }
    return r;
}