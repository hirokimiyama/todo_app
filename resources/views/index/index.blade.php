cat << 'EOF' > resources/views/index/index.blade.php
<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
</head>

<body>
    Top Controller!!
    <?= isset($sampleValue) ? $sampleValue : '' ?>

    <header>
        <a href="/login">
            <h2>ログイン</h2>
        </a>
    </header>
</body>

</html>
EOF