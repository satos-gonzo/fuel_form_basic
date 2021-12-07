<?php


  /* 処理の流れ */
  // fieldestオブジェクトを使ってuser_formのインスタンスを生成（フォームオブジェクトの全体になるもの）
  // addメソッドを使って、formタグを生成する
  // add_ruleメソッドを使って、バリデーションのルールを設定する
  // * post送信されているか確認
  // （postされている場合）
  // fieldestオブジェクトからvalidationオブジェクトを生成する
  // validationインスタンスからバリデーションの実行メソッドを実行する
  // L validationエラーがない場合
  // L validationエラーがある場合
  // エラーメッセージ変数に格納する
  // 上記の変数をビュー側に渡して表示する
  // （postされていない場合）


  /* コード */
class Controller_Formtest extends Controller{

  // クラス定数の設定
  const PASS_MIN_LENGTH = 6;
  const PASS_MAX_LENGTH = 20;

  public function action_index(){
    // 使用する変数を定義
    $error = '';

    // fieldestオブジェクトを使ってuser_formのインスタンスを生成（フォームオブジェクトの全体になるもの）
    $user_form = Fieldset::forge('user_form',array('form_attributes' => array(
      'class' => 'form'
    )));

    // addメソッドを使って、formタグを生成していく
    $user_form->add('username','名前',array('type' => 'text','class' => 'username','placeholder' => 'お名前'))
    ->add_rule('required')
    ->add_rule('min_length',self::PASS_MIN_LENGTH);//クラス定数はself::定数名 で呼び出し可能

    $user_form->add('email','Email',array('type' => 'email','class' => 'user_email','placeholder' => 'Email'))
    ->add_rule('required')
    ->add_rule('valid_email')
    ->add_rule('max_length',self::PASS_MAX_LENGTH);

    $user_form->add('password','パスワード',array('type' => 'password','class' => 'user_password','placeholder' => 'パスワード'))
    ->add_rule('required')
    ->add_rule('min_length',self::PASS_MIN_LENGTH)
    ->add_rule('max_length',self::PASS_MAX_LENGTH);

    $user_form->add('password_re','パスワード再入力',array('type' => 'password','class' => 'user_password_re','placeholder' => 'パスワード再入力'))
    ->add_rule('required')
    ->add_rule('match_field','password')
    ->add_rule('min_length',self::PASS_MIN_LENGTH)
    ->add_rule('max_length',self::PASS_MAX_LENGTH);


    $user_form->add('submit','',array('type' => 'submit','class' => 'btn','value' => '送信する'));

    // post送信されているか
    if(Input::method() === 'POST'){
      // バリデーションクラスの生成
      $val = $user_form->validation();

      // validationインスタンスからバリデーションの実行メソッドを実行する
      if($val->run()){
        Debug::dump('ここにバリデーションが成功した時の処理');

      }else{
        // バリデーションが失敗した場合
        $error = $val->error();
      }

      // フォームの入力保持：buildする前に記述する
      $user_form->repopulate();
    }

    // ビューファイルに情報を渡す
    // ここはテンプレートになるファイル
    $view = View::forge('index.php');
    $view->set('header',$view::forge('template/header'));
    $view->set('content',$view::forge('template/content'));
    $view->set('footer',$view::forge('template/footer'));
    // buildでフォームオブジェクトのレンダリング
    $view->set_global('user_form',$user_form->build(),false);
    // 変数$errorをビュー側にセットする
    $view->set_global('error',$error);

    return $view;

  }
}
