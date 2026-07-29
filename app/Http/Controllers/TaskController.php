<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;//このコントローラ（TaskController）の中で、先ほど app フォルダ直下に作成した Task モデルを使用するための宣言。この1行がないと、プログラムが Task を見つけられずエラーになってしまう。

class TaskController extends Controller
{
    // ★ここから下の数行を追加します
    public function index()
    {
        // データベースからすべてのタスクデータを取得して、変数 $tasks に入れる
        $tasks = Task::all();
        return view('todo.index', ['tasks' => $tasks]);
        //$tasksをtodo.indexにおいて呼び出すためのキーを'tasks'として設定している
    }
    // 以下は、入力フォームから入力されて\TaskにPOST通信されてきたときにデータを格納するための処理
    public function store(Request $request)
    {
        $request->validate([
        'title' => 'required', // 'title' は必須（required）という意味
        ]);

    // 1. 新しいタスクのモデル（設計図）のインスタンスを作る
        $task = new Task;

        // 2. フォームから送られてきた 'title' の中身を、モデルの title に代入する
        $task->title = $request->title;

        // 3. データベースに保存する
        $task->save();

        // 4. 保存が終わったら、元の画面（ /todo ）にもどる（リダイレクトする）
        return redirect('/todo');
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