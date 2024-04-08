<?php

namespace App\Http\Controllers\Backend;

use FFI;
use App\Models\Hut;
use App\Models\Facility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MultiImage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Constraint\Count;
use Symfony\Component\Yaml\Yaml;

class HutController extends Controller
{
    public function EditHut($id)
    {
        $basic_facility = Facility::where('huts_id', $id)->get();
        $multiimgs = MultiImage::where('huts_id', $id)->get();
        $editData = Hut::find($id);
        return view('backend.allhut.huts.edit_hut', compact('editData', 'basic_facility', 'multiimgs'));
    }

    public function UpdateHut(Request $request, $id)
    {
        $hut = Hut::find($id);
        $hut->huttype_id = $hut->huttype_id;
        $hut->total_adult = $request->total_adult;
        $hut->total_child = $request->total_child;
        $hut->hut_capacity = $request->hut_capacity;
        $hut->price = $request->price;
        $hut->size = $request->size;
        $hut->view = $request->view;
        $hut->bed_style = $request->bed_style;
        $hut->discount = $request->discount;
        $hut->short_desc = $request->short_desc;
        $hut->description = $request->description;

        //update single image
        if ($request->file('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $save_url = 'upload/hutimg/' . $name_gen;
            Image::read($image)->resize(550, 850)->save($save_url);
            $hut['image'] = $name_gen;
        }

        $hut->save();

        // Update for facality table
        if ($request->facility_name == NULL) {
            $notification = array(
                'message' => 'Sorry! Not Any Basic Facility Select',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {
            Facility::where('huts_id', $id)->delete();
            $facilities = Count($request->facility_name);
            for ($i = 0; $i < $facilities; $i++) {
                $fcount = new Facility();
                $fcount->huts_id = $hut->id;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->save();
            }
        }


        // Update Multi Images
        if (!empty($request->multi_img)) {
            // Get existing multi-images
            $existingImages = $hut->multiImages;
            if ($existingImages) {
                $existingImages = $existingImages->pluck('multi_img')->toArray();
            } else {
                $existingImages = [];
            }
            // Determine which images to keep
            $imagesToKeep = array_intersect($existingImages, $request->multi_img);
            // Delete images that are not in the new list
            $imagesToDelete = array_diff($existingImages, $imagesToKeep);
            foreach ($imagesToDelete as $imageToDelete) {
                $imageModel = MultiImage::where('multi_img', $imageToDelete)->first();
                if ($imageModel) {
                    $imageModel->delete();
                    if (file_exists(public_path('upload/hutimg/multi_img/' . $imageToDelete))) {
                        unlink(public_path('upload/hutimg/multi_img/' . $imageToDelete));
                    }
                }
            }
            // Save new multi-images
            foreach ($request->multi_img as $file) {
                if (!in_array($file, $existingImages)) {
                    $imgName = date('YmdHi') . $file->getClientOriginalName();
                    $file->move('upload/hutimg/multi_img/', $imgName);
                    $subimage = new MultiImage();
                    $subimage->huts_id = $hut->id;
                    $subimage->multi_img = $imgName;
                    $subimage->save();
                }
            }
        }

        $notification = array(
            'message' => 'Hut Updated Successfullty',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function Delete(Request $request)
    {
        $imageId = $request->input('image_id');
        $image = MultiImage::find($imageId);
        if ($image) {
            // Delete image from storage
            $filePath = public_path('upload/hutimg/multi_img/') . $image->multi_img;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            // Delete image record from database
            $image->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
