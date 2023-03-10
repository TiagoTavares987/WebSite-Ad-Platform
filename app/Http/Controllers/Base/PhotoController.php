<?php

namespace App\Http\Controllers\Base;

use App\Models\Photo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PhotoController extends Controller
{
    private const ImagesPath = "/images/";
    private const PhotosPath = '/fotos/';
    private const AdsPath = '/ads/';
    
    // foto da pessoa que esta logada
    public static function GetPhoto(){
        // self -> estatico
        return Auth::user() ? self::obter(Auth::user()->imageId, self::PhotosPath, Auth::user()->is_admin ? "adminLogo.png" : "userLogo.png") : null;
    }    

    public static function GetUser(?int $id, bool $is_admin){
        return Auth::user()->is_admin ? self::obter($id, self::PhotosPath, $is_admin ? "adminLogo.png" : "userLogo.png") : null;
    }
    
    public static function GetAd(?int $id){
        return self::obter($id, self::AdsPath, "no_image.jpg");
    }

    public static function SavePhoto(Request $request, ?int $id)
    {
        return self::gravar($request, $id, 'imageId', self::PhotosPath);
    }

    public static function SaveAd(Request $request, ?int $id)
    {
        return self::gravar($request, $id, 'imageId', self::AdsPath);
    }    

    public static function DeletePhoto(int $id)
    {
        return self::apagar($id, self::PhotosPath);
    }  

    public static function DeleteAd(int $id)
    {
        return self::apagar($id, self::AdsPath);
    }
    
    private static function obter(?int $id, string $storagePath, string $defaultImage)
    {
        $file = null;
        $path = 'storage';

        if($id != null)
        {
            $photo = Photo::find($id);  
            if($photo != null)
            {
                $file = $path.$storagePath.$photo->path;
                if (!file_exists($file))
                    $file = null;
            }
        }

        if($file == null)
            $file = $path.self::ImagesPath.$defaultImage;
        
        return asset($file); 
    }

    private static function gravar(Request $request, ?int $id, string $fieldname, string $storagePath)
    {
        $request->validate([$fieldname => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',]);
        
        $name = $request->file($fieldname)->getClientOriginalName(); 
        $path = $request->file($fieldname)->hashName();
        $request->file($fieldname)->store('public'.$storagePath);// grava a imagem no disco

        if ($id != null) {
            $photo = Photo::find($id); // buscar foto
            if ($photo != null) {
                $oldPath = $photo->path; // guardar o old path para apagar no disco
                if (self::atualizar($photo, $name, $path)) { // atualiza na bd com o novo path
                    self::apagarFicheiro($storagePath . $oldPath); // apagar no disco o ficheiro antigo
                    return $id;
                } else
                    return null;
            }
        }
        return self::novo($name, $path);
    }

    private static function novo(string $name, string $path)
    {
        $picture = new Photo;
        $picture->nome = $name;
        $picture->path = $path;
        return $picture->save() ? $picture->id : null;
    }
    
    private static function atualizar(Photo $photo, string $name, string $path)
    {
        $fields = [
            'nome' => $name,
            'path' => $path
        ];

        return $photo->update($fields, []);
    }

    public static function apagar(int $id, $storagePath)
    {
        $photo = Photo::find($id);
        if($photo != null && $photo->delete()){
            self::apagarFicheiro($storagePath.$photo->path);
            return true;
        }
        return false;
    }  

    private static function apagarFicheiro(string $filePath)
    {
        File::delete('storage'.$filePath);
    }
}
