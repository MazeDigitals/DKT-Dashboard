<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Blogs extends BaseModel
{
    use HasFactory;

    protected $table = 'blogs';
    protected $guarded = ['id'];
    // public $timestamps = false;
    protected $appends = ['e_id','m_created_at','m_image'];

    const STATUS_ACTIVE  = 1;
    const STATUS_INACTIVE  = 0;

    const FEATURED_YES  = 1;
    const FEATURED_NO  = 0;

    const LIST_PERMISSION = 'list-blog';
    const VIEW_PERMISSION = 'view-blog';
    const ADD_PERMISSION = 'add-blog';
    const EDIT_PERMISSION = 'edit-blog';
    const DELETE_PERMISSION = 'delete-blog';

    public function getEidAttribute(){
        return encrypt($this->id);
    }

    public function getMCreatedAtAttribute(){
        return Carbon::parse($this->created_at)->isoFormat('DD MMM YYYY');
    }


    public function getMImageAttribute(){
        if( $this->image && ($this->image!='') ){
            return asset('storage/'.$this->image);
        } 
        return null;
    }

    static public function canOpenList() {
        return ( auth()->user()->can(self::LIST_PERMISSION) );
    }

    static public function canAdd(){
        return ( auth()->user()->can(self::ADD_PERMISSION) );
    }

    static public function canEdit(){
        return ( auth()->user()->can(self::EDIT_PERMISSION) );
    }

    static public function canView(){
        return ( auth()->user()->can(self::VIEW_PERMISSION) );
    }

    public function getEditBtnHtml(){
        if( self::canEdit() ){
            $link = route('admin.blog.edit',[ 'id' => $this->e_id ]);
            return '<a href="'.$link.'" class="btn btn-primary btn-sm" title="Edit"><i class="icon icon-edit pr-0"></i> </a>';
        }
    }

    public function getStatusHtml(){
        if($this->status == self::STATUS_ACTIVE){
            return '<label class="badge badge-success">Active</label>';
            // return '<span class="icon icon-unlock f-16 mr-1 text-success" title="Active"></span>';
        } else{
            // return '<span class="icon icon-lock f-16 mr-1 text-danger" title="InActive"></span>';
            return '<label class="badge badge-danger">Inactive</label>';
        }
    }

    static public function getActive(){
        return self::where('status',self::STATUS_ACTIVE)->get();
    }

}
