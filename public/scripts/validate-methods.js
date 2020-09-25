// self-defined validator methods
$.validator.addMethod("regex",function(value, element, params) {
    let exp = new RegExp(params);
    return exp.test(value);
},"Format is incorrect.");
