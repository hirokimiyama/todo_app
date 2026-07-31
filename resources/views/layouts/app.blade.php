<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDoアプリ</title>
    
    <!-- ここでCSSを読み込む設定をします（Viteを使用） -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color: #f3f4f6; color: #333; font-family: sans-serif; margin: 0; padding: 0;">

    <!-- 共通のヘッダー部分 -->
    <header style="background-color: #fff; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
        <h1 style="margin: 0; font-size: 24px;">ToDo App</h1>
    </header>

    <!-- メインコンテンツ（各画面の中身）が入る場所 -->
    <main style="max-width: 800px; margin: 0 auto; padding: 0 20px;">
        @yield('content')
    </main>

</body>
</html>