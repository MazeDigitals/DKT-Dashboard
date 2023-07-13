<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'galleries';
    protected $guarded = [];
    protected $appends = ['e_id','m_created_at'];

    const LIST_PERMISSION = 'list-gallery';
    const VIEW_PERMISSION = 'view-gallery';
    const ADD_PERMISSION = 'add-gallery';
    const EDIT_PERMISSION = 'edit-gallery';
    const DELETE_PERMISSION = 'delete-gallery';

    static public function getByEid($id){
        return self::find( decrypt($id) );
    } 

    public function getEIdAttribute(){
        return encrypt($this->id);
    }

    public function images(){
        return $this->hasMany('App\Models\GalleryImage','gallery_id');
    }

    public function getMCreatedAtAttribute(){
        return Carbon::parse($this->created_at)->isoFormat('DD MMM, YYYY (h:mm a)');
    }
    public function images_by_sequence(){
        return $this->hasMany('App\Models\GalleryImage','gallery_id')->orderBy('sequence','ASC');
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

    static public function canDelete(){
        return ( auth()->user()->can(self::DELETE_PERMISSION) );
    }

    public function getEditBtnHtml(){
        if( self::canEdit() ){
            $link = route('admin.galleries.edit',[ 'id' => $this->e_id ]);
            return '<a href="'.$link.'" class="btn btn-primary btn-sm" title="Edit"><i class="icon icon-edit pr-0"></i> </a>';
        }
    }
}
