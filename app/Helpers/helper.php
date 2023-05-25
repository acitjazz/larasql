<?php

use App\Models\Media;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

function filterString($filtername)
{
	if(request('sort') == 'asc'){
		return $filtername.'&sort=desc';
	}
	return $filtername.'&sort=asc';
}

function limitWord($str, $limit)
{
	$word = Str::words($str, $limit, '...');
	return $word;
}


function getImage($image)
{
	if($image){
		$image = json_decode($image)[0] ?? null;
		$image =  $image ?  url('/storage/uploads/'.$image->url) : url('/images/default.png');

		return $image;
	}
	return asset('/images/default.png');
}

function currentUrl($number)
{
	$currentpage = request()->segment($number);
	return $currentpage;
}
function get_client_ip()
{
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if (isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if (isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if (isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}

function readCSV($csvFile, $array)
{
	$file_handle = fopen($csvFile, 'r');
	while (!feof($file_handle)) {
		$line_of_text[] = fgetcsv($file_handle, 0, $array['delimiter']);
	}
	fclose($file_handle);
	return $line_of_text;
}


function toTitle($str){
	return ucfirst(str_replace('-', ' ', $str));
}


function type()
{
	$type = request('type');
	$arrTypes = pageTypes();

	if (is_null($type)) {
		return false;
	}
	if(in_array($type,$arrTypes)){

		return $type;
	}
	return abort(404);
}

function languages($key)
{
    if($key == 'meta') {
        return [
            'en' => [
                'title' => null,
                'image' => null,
                'description' => null,
            ],
            'id' => [
                'title' => null,
                'image' => null,
                'description' => null,
            ],
            'sc' => [
                'title' => null,
                'image' => null,
                'description' => null,
            ],
        ];
    }
	return [
		'en' => null,
		'id' => null,
		'sc' => null,
	];
}

function translate($model,$key)
{
	return empty($model->getTranslations($key)) ? languages($key) : $model->getTranslations($key);
}

function pageTypes()
{
	return [
		'menu','home','blog','static','main-menu','footer-menu'
	];
}

function vueFormExist($name,$folder,$default = 'form'){
    $file = base_path().'/resources/js/Admin/Views/'.$folder.'/'.$name.'.vue';
    if(!file_exists($file)){
        return $folder.'/'.$default;
    }
	return $folder.'/'.$name;
}


function uploadLocal($file ,$folder='user', $user= null)
{
    try {
        $date = Carbon::now()->format('dmY-his');
        $fileName = $file->getClientOriginalName();
        $extinsion = $file->getClientOriginalExtension();
        $fileSize = $file->getSize();

        // $folder = Str::snake($folder);

        if (!is_dir(storage_path('/app/public/uploads/' . $folder))) {
           $folder_full  = storage_path('/app/public/uploads/' . $folder);
           if (!is_dir($folder_full)) mkdir($folder_full, 0777, true);
        }
        $path = storage_path('/app/public/uploads/' . $folder);

        $download =  $folder . '/';
        $media = new Media();
        if($user!=''){
            $media->user_id = $user->id;
            $mitra = $user->mitras->first();
            $media->mitra_id = $mitra->id ?? null;
        }
        $media->extension = $extinsion;
        $media->folder    = $folder;
        $media->name      = str_replace($extinsion, '', $fileName) ;
        $media->size      = $fileSize;
        $media->filename  = $fileName;
        $media->save();

        $filePath = 'uploads/'.$folder.'/' . $media->slug;
        // $filePath = 'uploads/'.$folder.'/';

        // $path =  Storage::disk("local")->putFileAs($filePath,  $file, $fileName);
        $destinationPath = $path;
        $original        = $media->slug . '-' . $date . '.' . $media->extension;
        $file->move($destinationPath, $original);
        // $path = Storage::disk('local')->put($filePath, file_get_contents($file));
        // $path = Storage::disk('local')->url('0');
        // $url = Storage::disk('s3')->url($filePath);

        Cache::tags(['medias'])->flush();

        $media->path      = $filePath;
        // $media->url       =  $filePath = 'uploads/'.$folder.'/' . $media->slug;
        $media->url = $download . $original;
        $media->update();



        $return['status'] = true;
        $return['data'] =  $media;
        $return['message'] = 'succses';
        return $return;
    } catch (Exception $e) {

        $return['status'] = false;
        $return['data'] =  [];
        $return['message'] = $e->getMessage();
        return $return;
    }

}
