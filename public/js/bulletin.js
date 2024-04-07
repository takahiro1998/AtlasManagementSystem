$(function () {
  // メインカテゴリセレクト画面
  // メインカテゴリをクリックしたなら
  $('.main_categories').click(function () {
    $(this).toggleClass('open');
    // 押されたボタンよりcategory_idを格納
    var category_id = $(this).attr('category_id');
    $('.category_num' + category_id).slideToggle();
  });

  $(document).on('click', '.like_btn', function (e) {
    e.preventDefault();
    $(this).addClass('un_like_btn');
    $(this).removeClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);
    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/like/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      console.log(res);
      $('.like_counts' + post_id).text(countInt + 1);
    }).fail(function (res) {
      console.log('fail');
    });
  });

  $(document).on('click', '.un_like_btn', function (e) {
    e.preventDefault();
    $(this).removeClass('un_like_btn');
    $(this).addClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/unlike/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      $('.like_counts' + post_id).text(countInt - 1);
    }).fail(function () {

    });
  });

  // 投稿編集モーダル
  // class="edit-modal-open"が押されたら
  $('.edit-modal-open').on('click', function () {
    // モーダルの中身(class= "js-modal")の表示
    $('.js-modal').fadeIn();
    // 押されたボタンから投稿タイトルを格納
    var post_title = $(this).attr('post_title');
    // 押されたボタンから投稿内容を格納
    var post_body = $(this).attr('post_body');
    // 押されたボタンから投稿のidを格納
    var post_id = $(this).attr('post_id');
    // 取得した内容を渡す
    $('.modal-inner-title input').val(post_title);
    $('.modal-inner-body textarea').text(post_body);
    $('.edit-modal-hidden').val(post_id);
    return false;
  });
  $('.js-modal-close').on('click', function () {
    // モーダルの中身(class= "js-modal")を非表示
    $('.js-modal').fadeOut();
    return false;
  });

});
