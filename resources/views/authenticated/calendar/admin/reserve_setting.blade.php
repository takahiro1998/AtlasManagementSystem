@extends('layouts.sidebar')
@section('content')
<div class="vh-100 pt-5" style="">
  <div class="border w-75 m-auto pt-5 pb-5 white">
    {!! $calendar->render() !!}
    <div class="adjust-table-btn m-auto text-right">
      <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
    </div>
  </div>
</div>
@endsection
