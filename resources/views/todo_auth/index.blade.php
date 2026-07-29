<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ToDoリスト - ログイン</title>
</head>
<body>
    <h1>ToDoアプリ ログイン・登録</h1>

    <?php if ($variables["isLoginActive"]) { ?>
        <p>現在、アカウント「<strong>{{ $variables["loginIdStr"] }}</strong>」でログイン中です。</p>
        <p><a href="/todo">ToDoリストを見る</a></p>
        <p><a href="/todo/unregister">ログアウトする</a></p>

        <form method="post" action="/todo/delete_account" onsubmit="return confirm('本当にアカウントを削除しますか？この操作は取り消せません。');">
            @csrf
            <div style="margin-top: 30px;">
                <input type="submit" value="アカウントを削除（退会）する" style="color: red;">
            </div>
        </form>

    <?php } else { ?>
        
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
            <h2>新規登録</h2>
            <h3>IDは4文字以上、パスワードは8文字以上で入力してください</h3>
            <form method="post" action="/todo/register">
                @csrf
                <div>ID : <input type="text" name="id"></div>
                <div>PW : <input type="password" name="password"></div>
                <div><input type="submit" value="新しく登録する"></div>
            </form>
        </div>

        <div style="border: 1px solid #ccc; padding: 10px;">
            <h2>ログイン</h2>
            <form method="post" action="/todo/sign_in">
                @csrf
                <div>ID : <input type="text" name="id"></div>
                <div>PW : <input type="password" name="password"></div>
                <div><input type="submit" value="ログインする"></div>
            </form>
        </div>
        
    <?php } ?>
</body>
</html>