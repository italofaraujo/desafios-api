<?php
namespace Desafios\App\Http\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use Firebase\JWT\JWT;
use DateTimeImmutable;
use Exception;

class AuthMiddleware implements IMiddleware {

    public function handle(Request $request): void 
    {
        
        if (! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
            header('HTTP/1.0 400 Bad Request');
            echo 'Token not found in request';
            exit;
        }

        $jwt =  $matches[1];

        // Authenticate user, will be available using request()->user
        ///$request->user = User::authenticate();
        
        //redirect(url('profile'));
        
        try {
            $secretKey  = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
            $token = JWT::decode($jwt, $secretKey, ['HS512']);
            $now = new DateTimeImmutable();
            $serverName = "desafios.tete";

            if ($token->iss !== $serverName ||
                $token->nbf > $now->getTimestamp() ||
                $token->exp < $now->getTimestamp())
            {
                throw new Exception("Error Processing Request", 1);
                
            }
        } catch (Exception $e) {
            $request->setRewriteUrl(url('unauthorized'));
        }

        

       

    }
}