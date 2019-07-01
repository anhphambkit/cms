import floatLabel from './float-label';
let panel = {
    // Switch panel to active or inactive mode
    switchPanel: function(panelToSwitch, active=true){
        panelToSwitch.attr('data-active', active);
        panelToSwitch.find('.field input[type="text"], .field input[type="number"], .field input[type="date"], .field select, .field input[type="password"], .field input[type="email"]').each(function(index, control) {

            // Add - when active = false and the field is empty
            // Remove - when active = true and the field == -
            let value = $(control).val();

            if(!active){
                let type = $(control).attr('type');
                $(control).attr('data-org-val', value);
                $(control).attr('data-org-type', type);
            }

            if(!active && (value == null || value.trim().length == 0 )){
                $(control).attr('type', 'text');
                $(control).val('-');
            } else if(active && value === '-') {
                $(control).val($(control).attr('data-org-val'));
                $(control).attr('type', $(control).attr('data-org-type'));
            }
            control.value = $(control).val();
            floatLabel.unLock(control, active);
        });
    },
    handleEditButton: function(editButtonEl){
        $(editButtonEl).on('click', function(){
            let currentPanel = $(this).closest('.card-box');
            let currentIsActive = currentPanel.attr('data-active');
            if(currentIsActive && currentIsActive === 'true'){
                panel.switchPanel(currentPanel, false);
            } else {
                panel.switchPanel(currentPanel, true);
            }
        })
    }
};
export default panel;