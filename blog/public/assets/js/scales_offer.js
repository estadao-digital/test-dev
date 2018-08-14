/**
 * Created by reinaldo on 20/12/16.
 */
$(function () {
    $('#form_scale_offer').on('click', 'input:radio', function(){

    });
});
if($('#form_scale_offer input:radio:checked').length > 0){
    $('#form_scale_offer_button').prop('disabled', 1);
}