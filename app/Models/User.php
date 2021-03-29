<?php
namespace Desafios\App\Models;
use \Illuminate\Database\Eloquent\Model;
 
class User extends Model {
    protected $table = 'users';
    protected $fillable = ['name','email','password'];
    protected $hidden = ['password','created_at','updated_at','deleted_at'];
}