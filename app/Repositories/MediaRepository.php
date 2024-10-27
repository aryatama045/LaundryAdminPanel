<?php


namespace App\Repositories;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaRepository extends Repository
{
    public function model()
    {
        return Media::class;
    }

    public function storeByRequest(UploadedFile $file, string $path, string $description = null, string $type = null): Media
    {
        $path = Storage::put('/'. trim($path, '/'), $file, 'public');
        $extension = $file->extension();
        if(!$type){
            $type = in_array($extension, ['jpg', 'png', 'jpeg', 'gif']) ? 'image' : $extension;
        }

        return $this->model()::create([
            'type' => $type,
            'name' => $file->getClientOriginalName(),
            'src' =>  $path,
            'extension' => $extension,
            'path' => $path,
            'description' => $description,
        ]);
    }

    public function updateByRequest(UploadedFile $file,string $path, string $type = null, Media $media): Media
    {
        $path = Storage::put('/'. trim($path, '/'), $file, 'public');
        $extension = $file->extension();
        if(!$type){
            $type = in_array($extension, ['jpg', 'png', 'jpeg', 'gif']) ? 'image' : $extension;
        }

        if(Storage::exists($media->src)){
            Storage::delete($media->src);
        }

        $media->update([
            'type' => $type,
            'name' => $file->getClientOriginalName(),
            'src' =>  $path,
            'extension' => $extension,
            'path' => $path,
        ]);
        return $media;
    }




    public function storeByGaransi(UploadedFile $file, string $path, string $description = null, string $type = null, $urutan): Media
    {

        $date           = now()->toDateTimeString();
        $jam            =  date('h',strtotime($date));
        $menit          =  date('i',strtotime($date));
        $originalName   = $file->getClientOriginalName();
        // $extension      = pathinfo($originalName, PATHINFO_EXTENSION);
        $extension      = $file->extension();

        $data_kode  = ['M','E','T','A','L','I','N','D','O','P'];
        shuffle($data_kode);
        $kode       = implode("",$data_kode);

        $foto_bukti = 'SMP_'.$kode.'_'.$jam.'X'.$menit.'-'.$urutan;
        
        $path = Storage::put('/'. trim($path, '/'), $foto_bukti, 'public');
        $extension = $file->extension();
        if(!$type){
            $type = in_array($extension, ['jpg', 'png', 'jpeg', 'gif']) ? 'image' : $extension;
        }


        return $this->model()::create([
            'type' => $type,
            'name' => $foto_bukti.'.'.$extension,
            'src' =>  $path,
            'extension' => $extension,
            'path' => $path,
            'description' => $description,
        ]);
    }

    public function updateByGaransi(UploadedFile $file,string $path, string $type = null, Media $media): Media
    {
        $path = Storage::put('/'. 'images/garansi/', $file, 'public');
        $extension = $file->extension();
        if(!$type){
            $type = in_array($extension, ['jpg', 'png', 'jpeg', 'gif']) ? 'image' : $extension;
        }

        if(Storage::exists($media->src)){
            Storage::delete($media->src);
        }

        $media->update([
            'type' => $type,
            'name' => $file->getClientOriginalName(),
            'src' =>  $path,
            'extension' => $extension,
            'path' => $path,
        ]);
        return $media;
    }
}
