$(function () {
  $('.js-modal-open').on('click', function () {
    $('.js-open').fadeIn();

    var setting_reserve = $(this).val();
    var reserve_part = $(this).attr('reserve_part');

    $('.modal-inner-date input').val(setting_reserve);
    $('.modal-inner-time input').val(reserve_part);
    return false;
  });
  $('.js-modal-close').on('click', function () {
    $('.js-open').fadeOut();
    return false;
  });
});
