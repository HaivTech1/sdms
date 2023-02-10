<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Banner;
use App\Models\Choose;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        return view('admin.frontend.index');
    }

    public function banner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'sub_title' => 'required',
            'description' => 'required',
            'button_text' => 'required',
            'feature_one' => 'required',
            'feature_two' => 'required',
            'feature_three' => 'required',
        ]);

        $banner = Banner::first();

        if ($banner) {
           $banner->update([
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'description' => $request->description,
                'button_text' => $request->button_text,
                'feature_one' => $request->feature_one,
                'feature_two' => $request->feature_two,
                'feature_three' => $request->feature_three,
                'feature_one_title' => $request->feature_one_title,
                'feature_two_title' => $request->feature_two_title,
                'feature_three_title' => $request->feature_three_title,
           ]);

           if($request->hasFile('wide_banner')){
                $path = 'storage/'.$banner->wide_banner;
                if(File::exists($path)){
                    File::delete($path);
                }

                $bannerFileName = $request->wide_banner->getClientOriginalName();
                $bannerFilePath = 'banner/' . $bannerFileName;
                $bannerIsFileUploaded = Storage::disk('public')->put($bannerFilePath, file_get_contents($request->wide_banner));
                if ($bannerIsFileUploaded) {
                    $banner->update(['wide_banner' =>$bannerFilePath]);
                }
           }

           return response()->json(['status'=>'success', 'message' => 'Banner updated successfully!'], 200);
        }else{
            if ($validator->passes()) {
                $banner = new Banner();
                $banner->title = $request->title;
                $banner->sub_title = $request->sub_title;
                $banner->description = $request->description;
                $banner->button_text = $request->button_text;
                $banner->feature_one_title = $request->feature_one_title;
                $banner->feature_one = $request->feature_one;
                $banner->feature_two_title = $request->feature_two_title;
                $banner->feature_two = $request->feature_two;
                $banner->feature_three_title = $request->feature_three_title;
                $banner->feature_three = $request->feature_three;
    
    
                $bannerFileName = $request->wide_banner->getClientOriginalName();
                $bannerFilePath = 'banner/' . $bannerFileName;
                $bannerIsFileUploaded = Storage::disk('public')->put($bannerFilePath, file_get_contents($request->wide_banner));
                if ($bannerIsFileUploaded) {
                    $banner->wide_banner = $bannerFilePath;
                }
                $banner->save();
    
                return response()->json(['status'=>'success', 'message' => 'Banner saved successfully!'], 200);
            }
        }

       
    
    
        return response()->json(['message'=> $validator->errors()->all()], 500);
    }
    
    public function bannerShow()
    {
       $banner = Banner::first();
       return response()->json(['status'=> 'success', 'message' => 'Banner shown successfully!', 'banner' => $banner], 200);
    }

    public function about(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description_one' => 'required',
            'description_two' => 'required',
            'big_image' => 'required',
            'small_image_one' => 'required',
            'small_image_two' => 'required',
        ]);

        $about = About::first();

        if ($about) {
           $about->update([
                'title' => $request->title,
                'description_one' => $request->description_one,
                'description_two' => $request->description_two,
           ]);

           if($request->hasFile('big_image')){
                $path = 'storage/'.$about->big_image;
                if(File::exists($path)){
                    File::delete();
                }

                $aboutFileName = $request->big_image->getClientOriginalName();
                $aboutFilePath = 'about/' . $aboutFileName;
                $aboutIsFileUploaded = Storage::disk('public')->put($aboutFilePath, file_get_contents($request->big_image));
                if ($aboutIsFileUploaded) {
                    $about->big_image = $aboutFilePath;
                    $about->save();
                }
           }

            if($request->hasFile('small_image_one')){
                $path = 'storage/'.$about->small_image_one;
                if(File::exists($path)){
                    File::delete();
                }

                $aboutFileName = $request->small_image_one->getClientOriginalName();
                $aboutFilePath = 'about/' . $aboutFileName;
                $aboutIsFileUploaded = Storage::disk('public')->put($aboutFilePath, file_get_contents($request->small_image_one));
                if ($aboutIsFileUploaded) {
                    $about->small_image_one = $aboutFilePath;
                    $about->save();
                }
            }

            if($request->hasFile('small_image_two')){
                $path = 'storage/'.$about->small_image_two;
                if(File::exists($path)){
                    File::delete();
                }

                $aboutFileName = $request->small_image_two->getClientOriginalName();
                $aboutFilePath = 'about/' . $aboutFileName;
                $aboutIsFileUploaded = Storage::disk('public')->put($aboutFilePath, file_get_contents($request->small_image_two));
                if ($aboutIsFileUploaded) {
                    $about->small_image_two = $aboutFilePath;
                    $about->save();
                }
            }

           return response()->json(['status'=>'success', 'message' => 'About updated successfully!'], 200);
        }else{
            if ($validator->passes()) {
                $about = new About();
                $about->title = $request->title;
                $about->description_one = $request->description_one;
                $about->description_two = $request->description_two;
    
                $aboutFileName = $request->big_image->getClientOriginalName();
                $aboutFilePath = 'about/' . $aboutFileName;
                $aboutIsFileUploaded = Storage::disk('public')->put($aboutFilePath, file_get_contents($request->big_image));
                if ($aboutIsFileUploaded) {
                    $about->big_image = $aboutFilePath;
                }

                $smallFileName = $request->small_image_one->getClientOriginalName();
                $smallFilePath = 'about/' . $smallFileName;
                $smallIsFileUploaded = Storage::disk('public')->put($smallFilePath, file_get_contents($request->small_image_one));
                if ($smallIsFileUploaded) {
                    $about->small_image_one = $smallFilePath;
                }

                $oneSmallFileName = $request->small_image_two->getClientOriginalName();
                $oneSmallFilePath = 'about/' . $oneSmallFileName;
                $oneSmallIsFileUploaded = Storage::disk('public')->put($oneSmallFilePath, file_get_contents($request->small_image_two));
                if ($oneSmallIsFileUploaded) {
                    $about->small_image_two = $oneSmallFilePath;
                }
                $about->save();
    
                return response()->json(['status'=>'success', 'message' => 'About saved successfully!'], 200);
            }
        }

       
    
    
        return response()->json(['message'=> $validator->errors()->all()], 500);
    }

    public function aboutShow()
    {
       $about = About::first();
       return response()->json(['status'=> 'success', 'message' => 'About shown successfully!', 'about' => $about], 200);
    }

    public function choose(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'addmore.*.topic' => 'required',
            'addmore.*.intention' => 'required',
            'addmore.*.logo' => 'required',
        ]);

        
        if ($validator->passes()) {

            foreach ($request->addmore as $key => $value) {
                $choose = new Choose();
                $choose->topic = $value['topic'];
                $choose->intention = $value['intention'];

                $chooseFileName = $value['logo']->getClientOriginalName();
                $chooseFilePath = 'choose/' . $chooseFileName;
                $chooseIsFileUploaded = Storage::disk('public')->put($chooseFilePath, file_get_contents($value['logo']));
                if ($chooseIsFileUploaded) {
                    $choose->logo = $chooseFilePath;
                }
                $choose->save();
            }

            return response()->json(['status'=>'success', 'message' => 'Why choose use created successfully!'], 200);
        }
        return response()->json(['message'=> $validator->errors()->all()], 500);
    }

    public function uploadSignature()
    {
        return view('admin.frontend.upload_ignature');
    }

    public function uploadSignaturePost(Request $request)
    {

        $application = Application::first();

        if($request->hasFile('signature')){
            $path = 'storage/'.$application->signature;
            if(File::exists($path)){
                File::delete($path);
            }

            $ignatureFileName = $request->signature->getClientOriginalName();
            $ignatureFilePath = 'applications/' . $ignatureFileName;
            $ignatureIsFileUploaded = Storage::disk('public')->put($ignatureFilePath, file_get_contents($request->signature));
            if ($ignatureIsFileUploaded) {
                $application->update(['signature' =>$ignatureFilePath]);
            }
        }

        if($request->hasFile('stamp')){
            $path = 'storage/'.$application->stamp;
            if(File::exists($path)){
                File::delete($path);
            }

            $stampFileName = $request->stamp->getClientOriginalName();
            $stampFilePath = 'applications/' . $stampFileName;
            $stampIsFileUploaded = Storage::disk('public')->put($stampFilePath, file_get_contents($request->stamp));
            if ($stampIsFileUploaded) {
                $application->update(['stamp' =>$stampFilePath]);
            }
        }

       return response()->json(['status'=> 'success', 'message' => 'Uploaded successfully!'], 200);
    }
}
