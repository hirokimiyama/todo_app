<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ToDoリスト</title>
</head>
<body>
    <h1>ToDoリスト</h1>

    <div style="background-color: #f0f0f0; padding: 10px; margin-bottom: 15px;">
        <p>ログイン中のアカウント：<strong>{{ $variables["loginIdStr"] }}</strong></p>
        <p><a href="/todo/login">ログイン画面（メニュー）へ戻る</a></p>
    </div>

    {{-- タスク新規追加用の入力フォーム --}}
        <form action="/todo" method="POST">
        @csrf
        <input type="text" name="title" placeholder="新しいタスクを入力">
        <button type="submit">追加する</button>
    </form>
    
    <ul>
        @foreach($variables["tasks"] as $task)
            {{--
                コントローラから受け取った $variables["tasks"] から1つずつデータを取り出す
            --}}
           
            <li>
                {{ $task->title }}
                
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