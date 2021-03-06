<?php
namespace Desafios\App\Http\Controllers;
use Desafios\App\Models\User;
use Exception;
use Desafios\Src\JWTAuth;


class UserController {
 
    

    
     /**
     * Display a listing of the resource.
     *
     */
    public function login()
    {
        
        try {
            $email = input('email','','post');
            $password = input('password','','post');

            if(empty($email)){
                throw new Exception("O e-mail é obrigatório!", 400);
            }

            if(empty($password)){
                throw new Exception("A senha é obrigatória!", 400);
            }
            $password = md5($password);
            $user = User::where('email', $email)->where('password', $password);
            if($user->count() == 0  ){
                throw new Exception("E-mail ou senha incorreta!",   200);
            }

            $user = $user->first();
             
            $objJWTAuth = new JWTAuth(); 
            $jwt = $objJWTAuth->getJwt($user->id);  
            $user->jwt = $jwt;
            $returnData = $user;
            http_response_code(201);
        } catch (Exception $e) {
            $codeHttp = get_http_code($e->getCode(),400);
            http_response_code($codeHttp);
            $returnData = json_encode(['message' => $e->getMessage()]);
        }
      

        return $returnData;
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store()
    {   
        try {
            $name = input('name','','post');
            $email =  input('email','','post');
            $password = input('password','','post');
    
            if(empty($name)){
                throw new Exception("O nome é obrigatório!", 400);
            }

            if(empty($email)){
                throw new Exception("O e-mail é obrigatório!", 400);
            }

            if(empty($password)){
                throw new Exception("A senha é obrigatória!", 400);
            }

            if(User::where('email', $email)->count() > 0  ){
                throw new Exception("Email já cadastrado!", 200);
            }

            
            $user = User::create(
                [
                    'name'=> $name,
                    'email'=>$email,
                    'password'=>md5($password)
                ]
            );

            $objJWTAuth = new JWTAuth(); 
            $jwt = $objJWTAuth->getJwt($user->id);  
            $user->jwt = $jwt;

            $returnData = $user;
            http_response_code(201);
        } catch (Exception $e) {
            $codeHttp = get_http_code($e->getCode(),400);
            http_response_code($codeHttp);
            $returnData = json_encode(['message' => $e->getMessage()]);
        }
      
        
        return $returnData;

    }

   
}
