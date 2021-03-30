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
                throw new Exception("O e-mail é obrigatório!", 1);
            }

            if(empty($password)){
                throw new Exception("A senha é obrigatória!", 1);
            }
            $password = md5($password);
            $user = User::where('email', $email)->where('password', $password);
            if($user->count() == 0  ){
                throw new Exception("E-mail ou senha incorreta!",   );
            }

            $user = $user->first();
             
            $objJWTAuth = new JWTAuth(); 
            $jwt = $objJWTAuth->getJwt($user->id);  
            $user->jwt = $jwt;
            $returnData = $user;
            
        } catch (Exception $e) {
            http_response_code(400);
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
                throw new Exception("O nome é obrigatório!", 1);
            }

            if(empty($email)){
                throw new Exception("O e-mail é obrigatório!", 1);
            }

            if(empty($password)){
                throw new Exception("A senha é obrigatória!", 1);
            }

            if(User::where('email', $email)->count() > 0  ){
                throw new Exception("Email já cadastrado!", 1);
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
            
        } catch (Exception $e) {
            http_response_code(400);
            $returnData = json_encode(['message' => $e->getMessage()]);
        }
      

        return $returnData;

    }

   
}
