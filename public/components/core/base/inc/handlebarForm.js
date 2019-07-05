let Handlebars = require('handlebars');

Handlebars.registerHelper('ifIndex', function(v1, options) {
    if(v1 == 0) {
        return options.fn(this);
    }
    return options.inverse(this);
});

Handlebars.registerHelper('ifUnIndex', function(v1, options) {
    if(v1 != 0) {
        return options.fn(this);
    }
    return options.inverse(this);
});

Handlebars.registerHelper('ifEquals', function(arg1, arg2, options) {
    return (arg1 === arg2) ? options.fn(this) : options.inverse(this);
});

Handlebars.registerHelper('ifNotEquals', function(arg1, arg2, options) {
    return (arg1 !== arg2) ? options.fn(this) : options.inverse(this);
});

Handlebars.registerHelper("formatCurrency", function(number) {
    return currencyFormat(number);
});

function currencyFormat(num) {
    return (
        num
            .toFixed(0) // always two decimal digits
            .replace('.', ',') // replace decimal point character with ,
            .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
    ) // use . as a separator
};

class HandlebarRender {
    constructor(){
        this.data            = {};
        this.sourceElement   = null;
        this.templateElement = null;
        this.handlebar       = Handlebars;
    }

    /**
     * setter data.
     */
    setData(data){
        this.data = data;
    }

    /**
     * getter data.
     */
    getData(){
        return this.data;
    }

    /**
     * setter source.
     */
    setSourceElement(element){
        this.sourceElement = element;
    }

    /**
     * setter handlebar.
     */
    setHandlebar(handlebar){
        this.handlebar = handlebar;
    }

    /**
     * setter template.
     */
    setTemplateElement(element){
        this.templateElement = element;
    }

    /**
     * hook before parse template
     */
    beforeParseTemplate(){}

    /**
     * hook after parse template
     */
    afterParseTemplate(){
        $('[data-toggle="tooltip"]').tooltip();
    }

    /**
     * Parse template
     */
    parseTemplate(){
        this.beforeParseTemplate();
        let source = $(this.sourceElement).html();
        let template = this.handlebar.compile(source);
        $(this.templateElement).html(template(this.data));
        this.afterParseTemplate();
    }
}

export { Handlebars, HandlebarRender };