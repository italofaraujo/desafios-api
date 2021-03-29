<?php
namespace Desafios\App\Http\Controllers;
use Desafios\App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use DateTimeImmutable;

class UserController {
 
    

    private function getJwt($idUsuario){
        $secretKey  = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+6 minutes')->getTimestamp();                                      // Retrieved from filtered POST data
        $serverName = "desafios.teste";
        $data = [
            'iat'  => $issuedAt->getTimestamp(),         // Issued at: time when the token was generated
            'nbf'  => $issuedAt->getTimestamp(),         // Not before
            'exp'  => $expire,           // Expire
            'id_usuario' => $idUsuario,
            'iss'  => $serverName
        ];     // User name

        return JWT::encode(
                $data,
                $secretKey,
                'HS512'
        );   
    }
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
                throw new Exception("E-mail ou senha incorreta!", 1);
            }

            $user = $user->first();
             
            
            $jwt = $this->getJwt($user->id);  



            $returnData['success'] = true;
            $returnData['message'] = 'Login efetuado com sucesso!';
            $returnData['jwt'] = $jwt;
            $returnData['data'] = $user;
            
        } catch (Exception $e) {
            $returnData['success'] = false;
            $returnData['message'] = $e->getMessage();
        }
      

        return json_encode($returnData);
        
        return $user;
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

            $returnData['success'] = true;
            $returnData['message'] = 'Usuário cadastrado com sucesso';
            $returnData['data'] = $user;
        } catch (Exception $e) {
            $returnData['success'] = false;
            $returnData['message'] = $e->getMessage();
        }
      

        return json_encode($returnData);

    }

   
}
