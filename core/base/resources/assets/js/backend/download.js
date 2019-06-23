"use strict";
(function (bigin) {
    /**
     * [loading description]
     * @return {[type]} [description]
     */
    function download() {
        if( typeof toastr == 'undefined'){
            throw new Error("BDownload requires toastr plugin");
        }
        if( typeof axios == 'undefined'){
            throw new Error("BDownload requires axios plugin");
        }
        var helpers = {};

        /**
         * [handleDownload description]
         * @return {[type]} [description]
         */
        helpers.handleDownload = function(url){
            helpers.handleNotification('success', `Start downloading file.`, 'Downloader');
            return axios.get(url, { responseType: 'arraybuffer'})
            .then(function(response){
                var blob      = new Blob([response.data],{type:response.headers['content-type']});
                var filename  = (response.headers['content-disposition'] || '').split('filename=')[1];
                var link      = document.createElement('a');
                link.href     = window.URL.createObjectURL(blob);
                link.download = filename.replace(new RegExp('"', 'g'), '');
                link.click();
                helpers.handleNotification('success', `Download file completed.`, 'Downloader');
            })
            .catch(function(error){
                helpers.handleNotification('error', `Cannot download this file.`, 'Downloader');
            })
        }
        
        /**
         * Helper notification
         * @param  {[type]} messageType   [description]
         * @param  {[type]} message       [description]
         * @param  {[type]} messageHeader [description]
         * @return {[type]}               [description]
         */
        helpers.handleNotification = function(messageType, message, messageHeader){
            if( typeof toastr === 'object'){
                toastr.clear();
                toastr.options = {
                    closeButton: true,
                    positionClass: 'toast-top-right',
                    onclick: null,
                    showDuration: 1000,
                    hideDuration: 1000,
                    timeOut: 10000,
                    extendedTimeOut: 1000,
                    showEasing: 'swing',
                    hideEasing: 'linear',
                    showMethod: 'fadeIn',
                    hideMethod: 'fadeOut'
                };
                toastr[messageType](message, messageHeader);
            }
        } 
        return helpers;
    }

    /**
     * Register libary download
     * @author  TrinhLe
     */
    if (typeof BDownloadPlugin === "undefined") {
        bigin.BDownloadPlugin = download();
    }
})(window);

$(document).on('click', '.b-download-media', function(event){
    event.preventDefault();
    let urlDownload = $(this).data('url');
    BDownloadPlugin.handleDownload(urlDownload);
});