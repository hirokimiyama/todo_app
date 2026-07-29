<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TodoAuthController extends Controller
{
    // ログイン画面・新規登録画面の表示
public function index(Request $request)
    {
        $loginId = $request->session()->get("login_id", null);
        
        $loginIdStr = "";
        if (isset($loginId)) {
            $userRecord = DB::connection('mysql')->select("select * from users where id = " . $loginId);
            if (count($userRecord) > 0) {
                $loginIdStr = $userRecord[0]->id_str;
            }
        }

        $variables = [
            "isLoginActive" => isset($loginId),
            "loginIdStr" => $loginIdStr // ← ここでアカウント名を渡しています
        ];

        return view("todo_auth.index", compact("variables"));
    }

    // アカウント登録処理
    public function register(Request $request)
    {
        $id = $request->input("id");
        $password = $request->input("password");

        if (strlen($id) < 4 || strlen($password) < 8) {
            return response("IDは4文字以上、パスワードは8文字以上で入力してください。<a href='/todo/login'>前のページへ戻る</a>");
        } // ← 【修正点】ここに if文を閉じる 「 } 」 を追加しました！

        // すでに同じIDが登録されていないかチェック
        $oldRecords = DB::connection('mysql')->select("select count(*) from users where id_str = '" . $id . "'");

        if (count($oldRecords) == 0) {
            return response("処理中に問題が発生しました。<a href='/todo/login'>前のページへ戻る</a>");
        }

        $record = (array)($oldRecords[0]);
        if ($record["count(*)"] > 0) {
            return response("すでに存在するアカウント id です。<a href='/todo/login'>前のページへ戻る</a>");
        }

        // データベースに新しいユーザーを保存
        DB::connection("mysql")->insert("insert into users (id_str,password) values ('" . $id . "','" . $password . "')");
        $records = DB::connection('mysql')->select("select * from users where id_str = '" . $id . "'");

        if (count($records) == 0) {
            return response("ユーザーデータの登録処理中に問題が発生しました。<a href='/todo/login'>前のページへ戻る</a>");
        }

        // セッションにログイン中のユーザーIDを保存
        $request->session()->put("login_id", $records[0]->id);
        return response("登録が完了しました。<a href='/todo/login'>前のページへ戻る</a>");
    }

    // ログイン処理
    public function sign_in(Request $request)
    {
        $id = $request->input("id");
        $password = $request->input("password");

        // 入力されたIDとパスワードが一致するレコードを探す
        $records = DB::connection('mysql')->select("select * from users where id_str = '" . $id . "' and password = '" . $password . "'");
        if (count($records) == 0) {
            return response("IDかパスワードが間違っています。<a href='/todo/login'>前のページへ戻る</a>");
        }

        // ログイン成功したらセッションにIDを保存
        $request->session()->put("login_id", $records[0]->id);

        // ▼ 変更点：メッセージにアカウント名を表示し、リンク先をToDoリスト（/todo）にする
        return response("アカウント「<strong>" . $id . "</strong>」でログインが完了しました。<br><a href='/todo'>ToDoリストへ進む</a>");
    }

    // ログアウト処理
    public function unregister(Request $request)
    {
        // セッションを空にしてログアウトする
        $request->session()->flush();
        return response("ログアウトが完了しました。<a href='/todo/login'>前のページへ戻る</a>");
    }

    // アカウント削除処理
    public function delete_account(Request $request)
    {
        // 1. セッションから、現在ログインしているユーザーの固有番号（id）を取り出す
        $loginId = $request->session()->get("login_id");

        // 2. データベースから、そのIDを持つユーザーのデータをピンポイントで削除する
        DB::connection('mysql')->delete("delete from users where id = " . $loginId);

        // 3. アカウントがなくなったので、セッションを空にして完全にログアウト状態にする
        $request->session()->flush();

        return response("アカウントを削除しました。<a href='/todo/login'>ログイン画面へ戻る</a>");
    }
}