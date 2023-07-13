<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Http\Requests\GalleryFormRequest;
use Helper;


class AdminGalleryController extends Controller
{
    public $module_title = 'Galleries';
    public $listing_view = 'admin.galleries.index';
    public $add_edit_view = 'admin.galleries.add_edit';
    public $show_view = 'admin.galleries.show';

    public function index(){

        //checking edit permission
        if( ! Gallery::canOpenList() ) {
            return Helper::redirectUnauthorizedPermission();
        }

        $data['title'] = $this->module_title;
        $data['category'] = Category::getActive();
        $data['add_url'] = route('admin.galleries.create');
        $data['listing_fetch_url'] = route('admin.galleries.fetch');
        return view( $this->listing_view , $data );
    }

    public function fetch(Request $request) {
        
        $query = $this->getModelCollection($request);

        return Datatables::of($query)
        ->addColumn('edit_btn', function($row){
            return $row->getEditBtnHtml();
        })
        ->rawColumns(['edit_btn'])
        ->make(true);
    }

    private function getModelCollection($request, $with=[]){
        $with = array_merge([], $with);
        $query = Gallery::where('id','<>',0);
        $query = $query->with($with);

        return $query;
    }

    private function getArrangedData($id=null) {
        if($id){
            $data['title'] = 'Update Gallery';
            $data['gallery'] = Gallery::getByEid($id);
            $data['action_url'] = route('admin.galleries.update',['id'=>$data['gallery']->e_id]);         
        } else{
            $data['title'] = 'Add New Gallery';
            $data['gallery'] = null;
            $data['action_url'] = route('admin.galleries.store');         
        }
        return $data;
    }

    public function create(){

        if( ! Gallery::canAdd() ) {
            return Helper::redirectUnauthorizedPermission();
        }

        return view( $this->add_edit_view , $this->getArrangedData(null) );
    }

    public function store(GalleryFormRequest $request){
       
            $galleries = Gallery::create([
               'title' => $request->title,
               'slug' => \Str::slug($request->title)
            ]);
            if( $galleries ){
                if( $request->hasFile('image') ){
                    $path = $request->file('image')->store('galleries', 'public');
                    $storage_path = $path;
                    // $data['image'] = $storage_path; 
                    GalleryImage::create([
                        'gallery_id' => $galleries->id,
                        'type' => GalleryImage::TYPE_IMAGE,
                        'source' => $storage_path,
                    ]);
                }

            }
            
            Helper::successToast('Gallery has been added successfully');
            return redirect()->route('admin.galleries');
        
    }

    public function edit($id){

        //checking edit permission
        if( ! Gallery::canEdit() ) {
            return Helper::redirectUnauthorizedPermission();
        }

        return view( $this->add_edit_view , $this->getArrangedData($id) );
    }

    public function update(GalleryFormRequest $request,$id){
            $galleries = Gallery::getByEid($id);
            unset($request['gallery_id']);
            $galleries->update($request->except('image'));
            if( $galleries ){
                if( $request->hasFile('image') ){
                    $path = $request->file('image')->store('galleries', 'public');
                    $storage_path = $path;
                    // $data['image'] = $storage_path; 
                    GalleryImage::create([
                        'gallery_id' => $galleries->id,
                        'type' => GalleryImage::TYPE_IMAGE,
                        'source' => $storage_path,
                    ]);
                }

            }

            Helper::successToast('Gallery has been updated successfully');
            return back();
      
    }

    public function show($id) {

        if( ! Gallery::canView() ) {
            return Helper::redirectUnauthorizedPermission();
        }

        $data['galleries'] = Gallery::getByEid($id);
        $data['title'] = 'Gallery Details';
        $data['action_url'] = route('admin.galleries');
        return view($this->show_view, $data);
    }

    public function updateImageSequence(Request $request,$id){
        try{
            if( isset($request->image_id) && (count($request->image_id)>0) ){
                foreach($request->image_id as $key => $imageId){
                    $sequence = $key + 1;
                    GalleryImage::where('id', $imageId)->update(['sequence' => $sequence]);
                }
                Helper::successToast('Image sequence has been updated successfully');
            } else {
                Helper::successToast('Images does not exist');
            }
            return back();
        }catch(Exception $e){
            Helper::errorToast();
            return back();
        }
    }

    public function removeGalleryImage(Request $request){
        $image_id = $request->image_id;
        GalleryImage::where('id', $image_id)->delete();
        return [
            "status" => true,
            'message' => 'Gallery image deleted successfully',
        ];
    }
}
