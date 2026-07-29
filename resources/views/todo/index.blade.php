<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ToDoリスト</title>
</head>
<body>
    <h1>ToDoリスト</h1>
    {{-- タスク新規追加用の入力フォーム --}}
        <form action="/todo" method="POST">
        @csrf
        <input type="text" name="title" placeholder="新しいタスクを入力">
        <button type="submit">追加する</button>
    </form>
    
    <ul>
        @foreach($tasks as $task)
            {{--
                コントローラから受け取った $tasks（全件データの束）から1つずつデータを取り出し、データがなくなるまで間の処理を繰り返す、という命令
                @foreachという書き方はLaravel独自の書き方
            --}}
           
            <li>
                {{ $task->title }}
                
            {{--なぜ {{ }} で囲むのか？
                表示を短く簡単に書くため（出力）
                通常のPHPで変数の中身をHTMLとして画面に表示させる場合、<?php echo $task->title; ?> のように記述する必要があります。Laravelでは {{ $task->title }} と書くだけで、これと全く同じ処理を自動で行ってくれます。

                セキュリティ対策（エスケープ処理）
                これが最も重要な理由です。例えば、悪意のあるユーザーがタスクのタイトル入力欄に「システムを誤作動させるようなプログラムのコード」を入力して保存したとします。それをそのまま画面に表示してしまうと、そのプログラムが実行されてしまう危険性（XSS攻撃と呼ばれます）があります。
                {{ }} を使って表示すると、Laravelが自動的にその入力内容を「ただの無害な文字列」に変換（無効化）して表示してくれるため、安全にWebアプリを動かすことができます。
            --}}

               {{-- ▼ 編集ページへのリンクを追加 --}}
                <a href="/todo/{{ $task->id }}/edit">編集</a>

                
                {{-- ここから削除ボタンとフォームを追加 --}}
                <form action="/todo/{{ $task->id }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">削除</button>
                </form>
            </li>
            
            
        @endforeach
        
    </ul>
    
</body>
</html>