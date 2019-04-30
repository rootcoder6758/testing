<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Image;
 
class FileController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUpload()
    {
        
        $get = Image::all();
        
        return view('image/fileUpload' ,['get' => $get]);
    }
 
    /**

     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUploadPost(Request $request)

    {
           

        $image = $request->file('uploadImage');

        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

        $destinationPath = public_path('/image');

        $image->move($destinationPath, $input['imagename']);
        
        $data = $input['imagename'];

        $formData = [
            'image' => $data,
        ];

        $d = Image::insert($formData);
        return json_encode($d);
    }
}