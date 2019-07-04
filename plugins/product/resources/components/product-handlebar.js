let Handlebars = require('handlebars');

// Handle bar:

Handlebars.registerHelper("isVariantProduct", function(typeProduct) {
    let type = (typeProduct) ? typeProduct : 'simple';
    return (type === 'simple') ? false : true;
});

Handlebars.registerHelper("productDefaultValue", function(productDefaultAttributeValues, attributeId) {
    return productDefaultAttributeValues[attributeId] ? productDefaultAttributeValues[attributeId][0] : 0;
});

Handlebars.registerHelper("valueByKeyObject", function(productDefaultAttributeValues, attributeId, key) {
    return productDefaultAttributeValues[attributeId] ? productDefaultAttributeValues[attributeId][0][key] : null;
});

export { Handlebars };