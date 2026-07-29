<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    // 最初の画面
    public function index(Request $request)
    {
        // 非ログイン時はアカウント登録フォーム、ログイン時はログアウトボタンを表示するといった切り替えのため session に保存された login_id を取得
        $loginId = $request->session()->get( "login_id" , null);
        $variables = [
            "isLoginActive" => isset( $loginId )
        ];

        return view("login/index", compact( "variables" ) );
    }

    // アカウント登録処理
    public function register(Request $request)
    {
        // form からの入力情報の取得
        $id = $request->input("id");
        $password = $request->input("password");

        // 同一 id の登録が既に存在するかチェックするため、指定された id をもとに DB Record を取得する。
        // select count(*) は where 条件に合致するレコード数を取得する SQL Query。
        $oldRecords = DB::connection('mysql')->select("select count(*) from users where id_str = '" . $id . "'");

        // sql query に失敗している場合、処理失敗として終了する。
        if (count($oldRecords) == 0) {
            return response("処理中に問題が発生しました。<a href='/login'>前のページへ戻る</a>");
        }

        // count(*) の値が 0 より大きい場合は同一 id の record が存在することになるため、処理を終了する。
        $record = (array)($oldRecords[0]);
        if ($record["count(*)"] > 0) {
            return response("すでに存在するアカウント id です。<a href='/login'>前のページへ戻る</a>");
        }

        // ここまで正常に処理が進んだら既存のレコードも存在しないため、入力情報をもとにレコードを追加する。
        DB::connection("mysql")->insert("insert into users (id_str,password) values ('" . $id . "','" . $password . "')");

        // ログイン id を取得するため、保存したレコード情報を取得する。
        $records = DB::connection('mysql')->select("select * from users where id_str = '" . $id . "'");

        // record が取得できなかったら何らかのエラーが発生しているため処理を終了する。
        if (count($records) == 0) {
            return response("ユーザーデータの登録処理中に問題が発生しました。<a href='/login'>前のページへ戻る</a>");
        }

        // session にログインしている user id を保存
        $request->session()->put( "login_id", $records[0]->id );

        return response("登録が完了しました。<a href='/login'>前のページへ戻る</a>");
    }

    // ログアウト処理
    public function unregister(Request $request)
    {
        $request->session()->flush();
        return response("ログアウトが完了しました。<a href='/login'>前のページへ戻る</a>");
    }
}