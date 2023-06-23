<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $guarded = [];
    protected $appends = ['e_id','m_price','m_created_at'];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const LIST_PERMISSION = 'list-product';
    const VIEW_PERMISSION = 'view-product';
    const ADD_PERMISSION = 'add-product';
    const EDIT_PERMISSION = 'edit-product';
    const DELETE_PERMISSION = 'delete-product';

    static public function getByEid($id){
        return self::find( decrypt($id) );
    } 

    public function getEIdAttribute(){
        return encrypt($this->id);
    }

    public function images(){
        return $this->hasMany('App\Models\ProductImage','product_id');
    }

    public function images_by_sequence(){
        return $this->hasMany('App\Models\ProductImage','product_id')->orderBy('sequence','ASC');
    }
    
    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function getMPriceAttribute(){
        return 'Rs '.number_format($this->price);
    }

    public function getMCreatedAtAttribute(){
        return Carbon::parse($this->created_at)->isoFormat('DD MMM, YYYY (h:mm a)');
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
            $link = route('admin.product.edit',[ 'id' => $this->e_id ]);
            return '<a href="'.$link.'" class="btn btn-primary btn-sm" title="Edit"><i class="icon icon-edit pr-0"></i> </a>';
        }
    }

    public function getViewBtnHtml(){
        if( self::canEdit() ){
            $link = route('admin.product.show',[ 'id' => $this->e_id ]);
            return '<a href="'.$link.'" class="btn btn-primary btn-sm" title="View"><i class="icon icon-eye pr-0"></i> </a>';
        }
    }

    public function getStatusHtml(){
        if($this->status == self::STATUS_ACTIVE){
            return '<label class="badge badge-success">Active</label>';
        } else if($this->status == self::STATUS_INACTIVE) {
            return '<label class="badge badge-secondary">In-Active</label>';
        }
    }
}
