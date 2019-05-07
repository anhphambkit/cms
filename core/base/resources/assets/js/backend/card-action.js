// Close Card
$('a[data-action="remove"]').on('click',function(){
    $(this).closest('.card').remove().slideUp('fast');
});