<?php
namespace Desafios\App\Models;
use \Illuminate\Database\Eloquent\Model;
 
class Challenge extends Model {
    protected $table = 'challenges';
    protected $fillable = ['id', 'name', 'description', 'explanation', 'thophy_video'];
}