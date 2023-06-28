<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class ApiController extends Controller
{

    /*** DB Insert ***/
    public function createStudent(Request $request){
        // 新規クラスの宣言
        $student = new Student;
        // 送られてきたnameとcourseを作成したクラスに格納
        // NULLを送ると下記変数どちらでもエラーになる
        $student->name = $request->name;
        $student->course = $request->course;
        // DB送信＆保存
        $student->save();

        // 正常レスポンスで（戻り値）にメッセージとステータス
        return response()->json([
            "message" => "student record created"
        ], 201);
    }

    /*** DB Select (all) */
    public function getAllStudents() {
        // Student::get()で全取得->toJsonでJson形式に変換
        $students = Student::get()->toJson(JSON_PRETTY_PRINT);
        return response($students, 200);
    }

    /*** DB Select (where id) ***/
    public function getStudent($id){
        // Student::where('カラム名', 引数)で検索、exists()で見つかったらtrue的な？
        if (Student::where('id', $id)->exists()) {
            // 再度検索掛けてget()で取得、Json形式に変換
            $student = Student::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($student, 200);
        
        }else {
            // 見つからない場合はコメント、エラーステータス
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }
    }

    /*** DB Update ***/
    public function updateStudent(Request $request, $id){
        if (Student::where('id', $id)->exists()){
            // id検索でDBからデータをモデルに格納
            $student = Student::find($id);
            // NULLじゃなければ更新
            $student->name = is_null($request->name) ? $student->name : $request->name;
            $student->course = 
                is_null($request->course) ? $student->course : $request->course;
            $student->save();

            return response($student, 200);

        } else{
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }
    }

    public function deleteStudent($id){
        if (Student::where('id', $id)->exists()){
            // update同様見つかったidのデータを格納
            $student = Student::find($id);
            // 取得データに対してDBに削除指令
            $student->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        }else {
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }
    }
}
