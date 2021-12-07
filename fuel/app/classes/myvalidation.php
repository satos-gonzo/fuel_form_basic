<?php

// 独自バリデーションの設定
class MyValidation{

  // 半角数字チェック
  public static function _validation_validhalf($str){//プレフィックスに_validation_をつける
    if(!preg_match('/^[a-zA-Z0-9]+$/',$str)){
      return true;
    }else{
      return false;
    }
  }
}
