<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
// use Intervention\Image\Facades\Image as Image;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'avatar',
        'user_name',
        'rfid',
        'fullname',
        'birthday',
        'email',
        'password',
        'address',
        'phone',
        'gender',
        'id_number',
        'medical_insurance',
        'password_changed'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'role',
        'user_name'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function medical_records ()
    {
        return $this->hasMany(MedicalRecord::class);
    }
    public function base64ToImage($imageData){
 
        // $data = $imageData;
        // $file_link = 'user-'.uniqid().'.jpg';
        // $path = 'public/user/'.$file_link;
        
        // if(Image::make(($data))->save($path)){
        //     return '/user/'.$file_link;
        // }
        // return false;
        // $data = $imageData;
        // $file_link = uniqid().'.jpg';
        // $path = '/public/uploads/' . $file_link;
        // if(Image::make(file_get_contents($data))->save($path)){
        //     return '/uploads/'.$file_link;
        // }
        // return false;
        $imgdata = base64_decode($imageData);
        $f = finfo_open();
        $mime_type = "." . explode("/", finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE))[1];
        $img = $imageData;
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = 'user/'.uniqid().".".$image_type;
        file_put_contents($file, $image_base64);
        return $file;
    }
}
