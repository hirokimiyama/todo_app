<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SampleController extends Controller
{
    public function index(Request $request)
    {
        // 先ほどの追加処理は、もう実行しないように消すかコメントアウトしておきます

        // 削除：where条件を使って、「nameが'ユーザー1'」のレコードだけを削除します
        $deleteResult = DB::connection("mysql")->delete("delete from users where name = 'ユーザー1'");
        
        // 削除が成功したか確認するため、usersテーブルの現在の全データを取得します
        $records = DB::connection('mysql')->select("select * from users");
        
        // 取得したデータを画面に出力して処理を止める
        dd($records);
    }
}