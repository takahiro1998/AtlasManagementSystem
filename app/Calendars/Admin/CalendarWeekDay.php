<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  function getClassName(){
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function render(){
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function everyDay(){
    return $this->carbon->format("Y-m-d");
  }

  function dayPartCounts($ymd){
    $html = [];
    // 指定した日付の部数「１」の予約状況(ReserveSetting)を格納
    $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    // 指定日付の部数「２」の予約状況
    $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    // 指定日付の部数「３」の予約状況
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();


    // ここに予約人数を表示させる＆予約詳細画面へ遷移する機能を実装
    $html[] = '<div class="text-left">';
    if($one_part){
      // 指定日付の部数「１」に接続しているuserの数を表示する
      $route=route("calendar.admin.detail",['date'=>$ymd,'part'=>'1']);
      $html[] = '<p class="day_part m-0 pt-1"><a href='.$route.'>1部</a>'.$one_part->users()->count().'</p>';
    }
    if($two_part){
      // 指定日付の部数「２」に接続しているuserの数を表示
      $route=route("calendar.admin.detail",['date'=>$ymd,'part'=>'2']);
      $html[] = '<p class="day_part m-0 pt-1"><a href='.$route.'>2部</a>'.$two_part->users()->count().'</p>';
    }
    if($three_part){
      // 指定日付の部数「３」に接続しているuserの数を表示
      $route=route("calendar.admin.detail",['date'=>$ymd,'part'=>'3']);
      $html[] = '<p class="day_part m-0 pt-1"><a href='.$route.'>3部</a>'.$three_part->users()->count().'</p>';
    }
    $html[] = '</div>';

    return implode("", $html);
  }


  function onePartFrame($day){
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    if($one_part_frame){
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
    }else{
      $one_part_frame = "20";
    }
    return $one_part_frame;
  }
  function twoPartFrame($day){
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if($two_part_frame){
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    }else{
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }
  function threePartFrame($day){
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if($three_part_frame){
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    }else{
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }

  //
  function dayNumberAdjustment(){
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }
}
