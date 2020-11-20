<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    public $guarded = [];

    public const extension = [
        'image'
    ];

    public function article(){
        return $this->morphTo(Article::class, 'fileables');
    }

    public function getFileUrlAttribute(){
        return 'http://127.0.0.1:8080/storage/' . $this->path;
    }

    public static function getBasenameWithExtension(string $string){
        $data = pathinfo($string);
        return $data['basename'];
    }
}
