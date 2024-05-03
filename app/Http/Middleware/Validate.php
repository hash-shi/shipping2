<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Validator;

class Validate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(\Illuminate\Http\Request $request, Closure $next)
    {
        $action     = Route::currentRouteAction();
        $action     = str_replace("App\\Http\\Controllers\\api\\", "", $action);
        if ($action == Route::currentRouteAction()){
            $action = str_replace("App\\Http\\Controllers\\", "", $action);
        }
        $controller = explode("@",$action)[0];
        $method     = explode("@",$action)[1];
        $vClass     = $request->input("vClass");
        $this->inputValidateInner($request, $controller, $method, $vClass);

        return $next($request);
    }

    //-------------------------------------------------------------------------
    // 
    // 入力値チェック(実処理)
    // 
    //-------------------------------------------------------------------------
    public function inputValidateInner(\Illuminate\Http\Request $request, $controller, $method, $vClass){
        $rulesClass = "App\\Validate\\Definitions\\".$controller;
        if ($vClass !== null){
            $rulesClass = "App\\Validate\\Definitions\\".$vClass;
        }
        if (class_exists($rulesClass)){
            $rulesObj   = new $rulesClass;

            // ルール・メッセージ・項目名のそれぞれの定義を
            $targets    = $rulesObj->getTargets($request, $method);
            $rules      = $rulesObj->getRules($request, $method);
            $messages   = $rulesObj->getMessages($request, $method);
            $attributes = $rulesObj->getAttributes($request, $method);

            // validate実行
            // Validator::make($targets==null?$request->all():$targets, $rules, $messages, $attributes)->validate();

            // これで、上記と同じ結果になった
            // Warning出力の場合、make->fails後になんらかの方法で警告であることを埋め込みたい
            $validator = Validator::make($targets==null?$request->all():$targets, $rules, $messages, $attributes);
            $validateResult = $validator->fails();
            if ($validateResult){
                $errors = (new \Illuminate\Validation\ValidationException($validator))->errors();
                $responseJson = array(
                    'message' => 'Failed validation',
                    'errors' => $errors,
                );

                // 追加で返却したい情報がある場合は、addResponseJsonメソッドに記述する
                if (method_exists($rulesObj, "addResponseJson")){
                    $addResponseJson = $rulesObj->addResponseJson($request, $method, $validator);
                    foreach($addResponseJson as $key => $value){
                        if ($key === "message"){ continue; }
                        if ($key === "errors"){ continue; }
                        $responseJson[$key] = $value;
                    }
                }

                $responseJson = response()->json($responseJson, 422, [], JSON_UNESCAPED_UNICODE);
                throw new HttpResponseException($responseJson);
            }
        }
    }    
}
