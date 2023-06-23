<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Blogs;
use App\Http\Requests\BlogFormRequest;
use Helper;

class AdminBlogController extends Controller
{
    public $module_title = 'Blogs';
    public $listing_view = 'admin.blog.index';
    public $add_edit_view = 'admin.blog.add_edit';
    public $show_view = 'admin.blog.show';

    public function index(){

        //checking edit permission
        if( ! Blogs::canOpenList() ) {
            return Helper::redirectUnauthorizedPermission();
        }

        $data['title'] = $this->module_title;
        // $data['roles'] = Role::getPortalRoles();
        $data['add_url'] = route('admin.blog.create');
        $data['listing_fetch_url'] = route('admin.blog.fetch');
        return view( $this->listing_view , $data );
    }

    public function fetch(Request $request) {
        
        $query = $this->getModelCollection($request);

        return Datatables::of($query)
        ->addColumn('edit_btn', function($row){
            return $row->getEditBtnHtml();
        })
        // ->addColumn('view_btn', function($row){
        //     return $row->getViewBtnHtml();
        // })
        ->addColumn('status_html', function($row){
            return $row->getStatusHtml();
        })
        ->rawColumns(['edit_btn','view_btn','status_html'])
        ->make(true);
    }

    private function getModelCollection($request, $with=[]){
        $with = array_merge([], $with);
        $query = Blogs::where('id','<>',0);

        if( ($request->status != null) && ($request->status != '') ){
            $query->where('status',$request->status);
        }

        $query = $query->with($with);

        return $query;
    }

    private function getArrangedData($id=null) {
        // $data['roles'] = Role::getPortalRoles();
        if($id){
            $data['title'] = 'Update Blog';
            $data['blog'] = Blogs::getByEid($id);
            $data['action_url'] = route('admin.blog.update',['id'=>$data['blog']->e_id]);         
        } else{
            $data['title'] = 'Add New Blog';
            $data['blog'] = null;
            $data['action_url'] = route('admin.blog.store');         
        }
        return $data;
    }

    public function create(){

        if( ! Blogs::canAdd() ) {
            return Helper::redirectUnauthorizedPermission();
        }

        return view( $this->add_edit_view , $this->getArrangedData() );
    }

    public function store(BlogFormRequest $request){
      
            $blog = Blogs::create($request->input());

            if( $request->hasFile('image') ){
                $path = $request->file('image')->store('blog', 'public');
                $storage_path = $path;
                // $data['image'] = $storage_path; 
                $blog->update(['image'=>$storage_path]);
            }

            Helper::successToast('Blog has been added successfully');
            return redirect()->route('admin.blog');
      
    }

    public function edit($id){

        //checking edit permission
        if( ! Blogs::canEdit() ) {
            return Helper::redirectUnauthorizedPermission();
        }

        return view( $this->add_edit_view , $this->getArrangedData($id) );
    }

    public function update(BlogFormRequest $request,$id){
        try{
            $role = Blogs::getByEid($id);
            $data = $request->input();

            if( $request->hasFile('image') ){
                $path = $request->file('image')->store('blog', 'public');
                $storage_path = $path;
                $data['image'] = $storage_path; 
            }

            $role->update($data);

            Helper::successToast('Blog has been updated successfully');
            return redirect()->route('admin.blog');
        } catch(\Exception $e){
            Helper::errorToast();
            return back();
        }
    }

    public function show($id) {
        $data['user'] = Blogs::getByEid($id);
        $data['title'] = 'Blog Details';
        $data['action_url'] = route('admin.blog');
        return view($this->show_view, $data);
    }
}
