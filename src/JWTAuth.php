<?php 
namespace Desafios\Src;
use Firebase\JWT\JWT;
use DateTimeImmutable;
use Exception;

class JWTAuth{
    
    private $secretKey  = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
    private $serverName = "desafios.tete";
    public function getJWT($idUsuario){
    
        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+300 minutes')->getTimestamp(); 
        $data = [
            'iat'  => $issuedAt->getTimestamp(),         // Issued at: time when the token was generated
            'nbf'  => $issuedAt->getTimestamp(),         // Not before
            'exp'  => $expire,           // Expire
            'id_usuario' => $idUsuario,
            'iss'  => $this->serverName
        ];     // User name

        return JWT::encode(
                $data,
                $this->secretKey,
                'HS512'
        );   
    }
    
    public function validateJWT($jwt){
        $token = JWT::decode($jwt, $this->secretKey, ['HS512']);
        $now = new DateTimeImmutable();
        

        if ($token->iss !== $this->serverName ||
            $token->nbf > $now->getTimestamp() ||
            $token->exp < $now->getTimestamp())
        {
            throw new Exception("Error Processing Request", 401);
            
        }
        return true;
    }
}