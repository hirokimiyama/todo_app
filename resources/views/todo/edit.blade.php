<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスクの編集</title>
</head>
<body>
    <h1>タスクの編集</h1>

    {{-- 編集データを送信するフォーム --}}
    <form action="/todo/{{ $task->id }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="title" value="{{ $task->title }}">
        <button type="submit">更新する</button>
    </form>

    <p><a href="/todo">戻る</a></p>
</body>
</html>