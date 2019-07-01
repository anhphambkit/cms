let floatLabel = {
    scanControl: '.float-label',
    /*
    * Unlock (active) control for ready input
    * @param control: Control is a Javascript Element
     */
    unLock : function (control, active=true) {
        if(active){
            $(control).closest(floatLabel.scanControl).addClass('active');
        } else {
            $(control).closest(floatLabel.scanControl).removeClass('active');
        }
    },
    /*
    * Float label to the top control or not
    * @param: control MUST BE javascript element (not jquery wrapper element)
     */
    float : function (control) {
        let val = control ? control.value : null;
        if(val != null && val.length > 0){
            $(control).closest(floatLabel.scanControl).addClass('float');
        } else {
            $(control).closest(floatLabel.scanControl).removeClass('float');
        }
    },
    init : function(){
        $(this.scanControl).find('.field input[type="text"], .field input[type="number"], .field input[type="date"], .field select, .field input[type="password"], .field input[type="email"]').each(function(index, control) {
            $(control).on('change input paste keyup select propertychange', function() {
                floatLabel.float(control);
            });
            floatLabel.float(control);
        });


    }
}
export default floatLabel;