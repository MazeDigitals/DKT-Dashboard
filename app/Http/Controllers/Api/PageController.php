<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blogs;
use App\Models\Category;
use App\Models\Page;
use App\Models\{PageBannerImage,Gallery};

class PageController extends Controller
{
    public function getPage(){
        $page = Page::get();
        return $this->response(true,$page,'Pages fetch successfully',200);
    }

    public function getBanner($id){
        $page = Page::where('id',$id)->with('images')->first();
        if(!$page){
            return $this->response(false,null,'Record Not Found',422);
        }
        return $this->response(true,$page,'Banner fetch successfully',200);
    }

    public function getBlogCategory(){
        $blogs = ['josh','dkt','okay','heer','dhanak','sheroz'];
        return $this->response(true,$blogs,'Blogs category fetch successfully',200);
    }
    public function getBlog($page){
        $cat = ['josh','dkt','okay','heer','dhanak','sheroz'];
        if(!in_array($page,$cat)){
            return $this->response(false,null,'Invalid Page name',422);
        }
        $blogs = Blogs::where('category',$page)->paginate(10);
        if(!$blogs){
            return $this->response(false,null,'Record Not Found',422);
        }
        return $this->response(true,$blogs,'Blogs fetch successfully',200);
    }

    public function getBlogById($id){
        $blogs = Blogs::where('id',$id)->first();
        if(!$blogs){
            return $this->response(false,null,'Record Not Found',422);
        }
        return $this->response(true,$blogs,'Blogs fetch successfully',200);
    }

    public function getGallery(){
        $gallery = Gallery::get();
        return $this->response(true,$gallery,'Gallery fetch successfully',200);
    }

    public function getGalleryImage($id){
        $gallery = Gallery::where('id',$id)->with('images')->first();
        if(!$gallery){
            return $this->response(false,null,'Record Not Found',422);
        }
        return $this->response(true,$gallery,'Gallery fetch successfully',200);
    }
}
