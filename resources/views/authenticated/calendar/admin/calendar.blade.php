@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5">
  <div class="border w-75 m-auto pt-5 pb-5 white">
    <div class="w-100">
      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <p>{!! $calendar->render() !!}</p>
    </div>
  </div>
</div>
@endsection
