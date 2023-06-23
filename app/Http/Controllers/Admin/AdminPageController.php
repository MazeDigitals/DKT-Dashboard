<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Category;
use App\Models\Page;
use App\Models\PageBannerImage;
use App\Http\Requests\PageFormRequest;
use Helper;

class AdminPageController extends Controller
{
    public $module_title = 'Pages';
    public $listing_view = 'admin.pages.index';
    public $add_edit_view = 'admin.pages.add_edit';
    public $show_view = 'admin.pages.show';

    public function index(){

        //checking edit permission
        if( ! Page::canOpenList() ) {
            return Helper::redirectUnauthorizedPermission();
        }

        $data['title'] = $this->module_title;
        $data['category'] = Category::getActive();
        $data['add_url'] = route('admin.page.create');
        $data['listing_fetch_url'] = route('admin.page.fetch');
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
        $query = Page::where('id','<>',0);
        $query = $query->with($with);

        return $query;
    }

    private function getArrangedData($id=null) {
        if($id){
            $data['title'] = 'Update Page';
            $data['page'] = Page::getByEid($id);
            $data['action_url'] = route('admin.page.update',['id'=>$data['page']->e_id]);         
        } else{
            $data['title'] = 'Add New Page';
            $data['page'] = null;
            $data['action_url'] = route('admin.page.store');         
        }
        return $data;
    }

    public function create(){

        if( ! Page::canAdd() ) {
            return Helper::redirectUnauthorizedPermission();
        }

        return view( $this->add_edit_view , $this->getArrangedData(null) );
    }

    public function store(PageFormRequest $request){
        try{
            
            $page = Page::create([
               'title' => $request->title,
               'slug' => \Str::slug($request->title)
            ]);
            if( $page ){
                if( $request->hasFile('image') ){
                    $path = $request->file('image')->store('pages', 'public');
                    $storage_path = $path;
                    // $data['image'] = $storage_path; 
                    PageBannerImage::create([
                        'page_id' => $page->id,
                        'type' => PageBannerImage::TYPE_IMAGE,
                        'source' => $storage_path,
                    ]);
                }

            }
            
            Helper::successToast('Page has been added successfully');
            return redirect()->route('admin.pages');
        } catch(\Exception $e){
            Helper::errorToast($e);
            return back();
        }
    }

    public function edit($id){

        //checking edit permission
        if( ! Page::canEdit() ) {
            return Helper::redirectUnauthorizedPermission();
        }

        return view( $this->add_edit_view , $this->getArrangedData($id) );
    }

    public function update(PageFormRequest $request,$id){
            $page = Page::getByEid($id);
            unset($request['page_id']);
            $page->update($request->except('image'));
            if( $page ){
                if( $request->hasFile('image') ){
                    $path = $request->file('image')->store('pages', 'public');
                    $storage_path = $path;
                    // $data['image'] = $storage_path; 
                    PageBannerImage::create([
                        'page_id' => $page->id,
                        'type' => PageBannerImage::TYPE_IMAGE,
                        'source' => $storage_path,
                    ]);
                }

            }

            Helper::successToast('Page has been updated successfully');
            return back();
      
    }

    public function show($id) {

        if( ! Page::canView() ) {
            return Helper::redirectUnauthorizedPermission();
        }

        $data['page'] = Page::getByEid($id);
        $data['title'] = 'Page Details';
        $data['action_url'] = route('admin.pages');
        return view($this->show_view, $data);
    }

    public function updateImageSequence(Request $request,$id){
        try{
            if( isset($request->image_id) && (count($request->image_id)>0) ){
                foreach($request->image_id as $key => $imageId){
                    $sequence = $key + 1;
                    PageBannerImage::where('id', $imageId)->update(['sequence' => $sequence]);
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

    public function removePageImage(Request $request){
        $image_id = $request->image_id;
        PageBannerImage::where('id', $image_id)->delete();
        return [
            "status" => true,
            'message' => 'Page image deleted successfully',
        ];
    }
}
