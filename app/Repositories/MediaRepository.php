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
        $extension      = pathinfo($originalName, PATHINFO_EXTENSION);
        // $extension      = $file->extension();

        $data_kode  = ['M','E','T','A','L','I','N','D','O','P'];
        shuffle($data_kode);
        $kode       = implode("",$data_kode);

        $data_kode2  = array('M' => '0', 'E'=>'1', 'T' => '2', 'A' =>'3', 
				'L' =>'4', 'I' =>'5','N' =>'6','D' =>'7', 'O' =>'8','P' =>'9');
        
        $jam1 = array_search(substr($jam,0,1 ), $data_kode2);  
        $jam2 = array_search(substr($jam,1,1 ), $data_kode2); 
        
        $menit1 = array_search(substr($menit,0,1 ), $data_kode2);  
        $menit2 = array_search(substr($menit,1,1 ), $data_kode2); 

        $foto_bukti = 'SMP_'.$kode.'_'.$jam1.$jam2.'X'.$menit1.$menit2.'.'.$extension;

        $path = Storage::put('/'. trim($path, '/'), $file, 'public');
        if(!$type){
            $type = in_array($extension, ['jpg', 'png', 'jpeg', 'gif']) ? 'image' : $extension;
        }


        return $this->model()::create([
            'type' => $type,
            'name' => $foto_bukti,
            'src' =>  $file->getClientOriginalName(),
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





    public function storeByKlaim(UploadedFile $file, string $path, string $description = null, string $type = null, $urutan): Media
    {

        $date           = now()->toDateTimeString();
        $jam            =  date('h',strtotime($date));
        $menit          =  date('i',strtotime($date));
        $originalName   = $file->getClientOriginalName();
        $extension      = pathinfo($originalName, PATHINFO_EXTENSION);
        // $extension      = $file->extension();

        $data_kode  = ['M','E','T','A','L','I','N','D','O','P'];
        shuffle($data_kode);
        $kode       = implode("",$data_kode);

        // $data_kode2  = ['0' => 'M', '1'=>'E', '2' => 'T', '3' =>'A', 
		// 		'4' =>'L', '5' =>'I','6' =>'N','7' =>'D', '8' =>'O','9' =>'P'];
        $data_kode2  = array('M' => '0', 'E'=>'1', 'T' => '2', 'A' =>'3', 
				'L' =>'4', 'I' =>'5','N' =>'6','D' =>'7', 'O' =>'8','P' =>'9');
        
        $jam1 = array_search(substr($jam,0,1 ), $data_kode2);  
        $jam2 = array_search(substr($jam,1,1 ), $data_kode2); 
        
        $menit1 = array_search(substr($menit,0,1 ), $data_kode2);  
        $menit2 = array_search(substr($menit,1,1 ), $data_kode2); 

        $foto_bukti = 'SMP_'.$kode.'_'.$jam1.$jam2.'X'.$menit1.$menit2.'.'.$extension;

        $path = Storage::put('/'. trim($path, '/'), $file, 'public');
        if(!$type){
            $type = in_array($extension, ['jpg', 'png', 'jpeg', 'gif']) ? 'image' : $extension;
        }


        return $this->model()::create([
            'type' => $type,
            'name' => $foto_bukti,
            'src' =>  $file->getClientOriginalName(),
            'extension' => $extension,
            'path' => $path,
            'description' => $description,
        ]);
    }
}
