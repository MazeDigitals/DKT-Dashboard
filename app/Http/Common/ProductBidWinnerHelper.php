<?php

namespace App\Http\Common;

use Illuminate\Http\Request;
use Session;
use App\Models\Activity\ActivityLog;
use App\Models\Setting;
use DB;
use Carbon\Carbon;
use Helper;
use Response;
use App\Models\Product;
use App\Models\ProductBid;
use App\Models\ProductWinner;
use App\Traits\EmailTrait;
use App\Mail\ProductBidWinnerNotifyMail;
use Illuminate\Support\Facades\Log;

class ProductBidWinnerHelper {

    use EmailTrait;

    public function processProductBidWinner(){
        $products = Product::where('status',1)->get();
        foreach( $products as $product ) {
            if( $product->checkBidTimeFinished() == 1 ){
                $maxBidder = ProductBid::where('product_id',$product->id)->orderBy('amount','DESC')->first();
                if($maxBidder)
                {
                    $productWinner = ProductWinner::create([
                        'bid_id' => $maxBidder->id,
                        'user_id' => $maxBidder->user_id,
                        'product_id' => $maxBidder->product_id,
                        'bid_amount' => $maxBidder->amount,
                        'status' => ProductWinner::STATUS_PROCESSING,
                        'is_notified' => 1
                    ]);
    
                    //Notify User through email
                    if( $productWinner ){
                        Product::where('id',$product->id)->update(['status'=>2]);
                        try{
                            $this->sendEmail(
                                $productWinner->user->email,
                                new ProductBidWinnerNotifyMail(
                                    $productWinner->user->name,
                                    $productWinner->m_bid_amount,
                                    $productWinner->product->name
                                )
                            );
                        } catch(\Exception $e){
                            Log::error($e);
                        }
                        
                        //TODO:: Returned user's deposit amount to their wallets and mark status  in product_deposit table here...
        
                    }
                }
            }
        }

        // TODO:: generate logs here

    }

}