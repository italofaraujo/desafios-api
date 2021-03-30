<?php
namespace Desafios\App\Http\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use Desafios\Src\JWTAuth;
use Exception;

class AuthMiddleware implements IMiddleware {

    public function handle(Request $request): void 
    {
        
        try {
            if (empty($_SERVER['HTTP_AUTHORIZATION'])) {
                throw new Exception("Token não encontrado na solicitação", 400);
                exit;
            }
            if (! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
                throw new Exception("Token não encontrado na solicitação", 400);
                exit;
            }
    
            $jwt =  $matches[1];
            
            $objJWTAuth = new JWTAuth(); 
            $jwt = $objJWTAuth->validateJWT($jwt);
        } catch (Exception $e) {
            $codeHttp = get_http_code_erro($e->getCode(),401);
            http_response_code($codeHttp);
                
            if($codeHttp == 400){
                echo json_encode(['message'=> $e->getMessage()]);
                exit();
            }

            $request->setRewriteUrl(url('unauthorized'));
        }

    }
}