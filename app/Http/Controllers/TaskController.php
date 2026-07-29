<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Task;//このコントローラ（TaskController）の中で、先ほど app フォルダ直下に作成した Task モデルを使用するための宣言。この1行がないと、プログラムが Task を見つけられずエラーになってしまう。

class TaskController extends Controller
{
   
public function index(Request $request)

    {
        // 1. セッションからログイン中のユーザーの固有番号（id）を取得
        $loginId = $request->session()->get("login_id");

        // 2. ログイン中のユーザーのレコードをデータベースから取得して、ID文字列を取り出す
        $userRecord = DB::connection('mysql')->select("select * from users where id = " . $loginId);
        $loginIdStr = $userRecord[0]->id_str; // ログインしているユーザーの文字列ID（例: test_user）

        // 3. そのユーザーのタスクだけを取得
        $tasks = DB::connection('mysql')->select("select * from tasks where user_id = " . $loginId);

        // 4. ビューに渡す配列の中に、ログインIDの文字列も含める
        $variables = [
            "tasks" => $tasks,
            "loginIdStr" => $loginIdStr,
        ];

        return view("todo.index", compact("variables"));
    }

    // 以下は、入力フォームから入力されて\TaskにPOST通信されてきたときにデータを格納するための処理
    public function store(Request $request)
    {
        // 1. セッションから現在ログインしているユーザーのIDを取り出す
        $loginId = $request->session()->get("login_id");

        // 2. 画面から送られてきたタスクのタイトルを取り出す
        $title = $request->input("title");

        // 3. tasksテーブルに、タイトルとユーザーIDをセットで保存する
        DB::connection("mysql")->insert(
            "insert into tasks (title, user_id) values ('" . $title . "', " . $loginId . ")"
        );

        return redirect("/todo");
    }

    public function destroy($id)
    {
        // 1. 渡された $id をもとに、データベースから該当するタスクを1件見つけ出す
        $task = Task::findOrFail($id);

        // 2. 見つけたタスクをデータベースから削除する
        $task->delete();

        // 3. 削除が終わったら、元の画面（ /todo ）にモドル（リダイレクトする）
        return redirect('/todo');
    }

    public function edit($id)
    {
        // 1. 編集したいタスクをデータベースから1件見つけ出す
        $task = Task::findOrFail($id);

        // 2. 見つけたデータを「todo.edit」という名前の編集画面に渡して表示する
        return view('todo.edit', ['task' => $task]);
    }

    public function update(Request $request, $id)
    {
        // 1. データベースから該当するタスクを1件見つけ出す
        $task = Task::findOrFail($id);

        // 2. フォームから送られてきた新しいタイトルで書き換える
        $task->title = $request->input('title');

        // 3. データベースに保存（上書き）する
        $task->save();

        // 4. 更新が終わったら、元のリスト一覧画面（ /todo ）に戻る
        return redirect('/todo');
    }
}