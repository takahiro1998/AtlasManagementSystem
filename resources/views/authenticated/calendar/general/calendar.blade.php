@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">

      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <!-- 予約ボタン -->
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
    <!-- 予約キャンセル画面作成中 -->
      <div class="modal js-open">
        <div class="modal__bg js-modal-close"></div>
        <div class="modal__content">
          <form action="{{ ('deleteParts') }}" method="post">
            <div class="modal-inner-date">
              <p>予約日：<input type="text" readonly></p>
            </div>
            <div class="modal-inner-time">
              <p>時間：<input type="text" readonly></p>
            </div>
            <div>
              <p>上記の予約をキャンセルしてもよろしいですか？</p>
            </div>
            <div class="w-50 m-auto edit-modal-btn d-flex">
              <a class="js-modal-close btn btn-primary d-block" href="">閉じる</a>
              <input type="hidden" class="edit-modal-hidden" name="post_id" value="">
              <input type="submit" class="btn btn-danger d-inline-block" value="キャンセル">
            </div>
            {{ csrf_field() }}
          </form>
        </div>
      </div>
  </div>
</div>
@endsection
