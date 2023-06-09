<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();
        DB::table('permissions')->insert([

            //Settings
            ['id'=>1,'name'=>"list-settings",'slug'=>"list-settings"],
            ['id'=>2,'name'=>"edit-settings",'slug'=>"edit-settings"],

            //Role
            ['id'=>3,'name'=>"list-role",'slug'=>"list-role"],
            ['id'=>4,'name'=>"view-role",'slug'=>"view-role"],
            ['id'=>5,'name'=>"add-role",'slug'=>"add-role"],
            ['id'=>6,'name'=>"edit-role",'slug'=>"edit-role"],
            ['id'=>7,'name'=>"delete-role",'slug'=>"delete-role"],

            //Admin User
            ['id'=>8,'name'=>"list-admin-user",'slug'=>"list-admin-user"],
            ['id'=>9,'name'=>"view-admin-user",'slug'=>"view-admin-user"],
            ['id'=>10,'name'=>"add-admin-user",'slug'=>"add-admin-user"],
            ['id'=>11,'name'=>"edit-admin-user",'slug'=>"edit-admin-user"],
            ['id'=>12,'name'=>"delete-admin-user",'slug'=>"delete-admin-user"],

            //Customer
            ['id'=>13,'name'=>"list-customer",'slug'=>"list-customer"],
            ['id'=>14,'name'=>"view-customer",'slug'=>"view-customer"],
            ['id'=>15,'name'=>"add-customer",'slug'=>"add-customer"],
            ['id'=>16,'name'=>"edit-customer",'slug'=>"edit-customer"],
            ['id'=>17,'name'=>"delete-customer",'slug'=>"delete-customer"],

            //Activity Logs
            ['id'=>18,'name'=>"list-activity-logs",'slug'=>"list-activity-logs"],

            //Category
            ['id'=>19,'name'=>"list-category",'slug'=>"list-category"],
            ['id'=>20,'name'=>"view-category",'slug'=>"view-category"],
            ['id'=>21,'name'=>"add-category",'slug'=>"add-category"],
            ['id'=>22,'name'=>"edit-category",'slug'=>"edit-category"],
            ['id'=>23,'name'=>"delete-category",'slug'=>"delete-category"],

            //product
            ['id'=>24,'name'=>"list-product",'slug'=>"list-product"],
            ['id'=>25,'name'=>"view-product",'slug'=>"view-product"],
            ['id'=>26,'name'=>"add-product",'slug'=>"add-product"],
            ['id'=>27,'name'=>"edit-product",'slug'=>"edit-product"],
            ['id'=>28,'name'=>"delete-product",'slug'=>"delete-product"],

            ['id'=>30,'name'=>"list-page",'slug'=>"list-page"],
            ['id'=>31,'name'=>"view-page",'slug'=>"view-page"],
            ['id'=>32,'name'=>"add-page",'slug'=>"add-page"],
            ['id'=>33,'name'=>"edit-page",'slug'=>"edit-page"],
            ['id'=>34,'name'=>"delete-page",'slug'=>"delete-page"],

            ['id'=>36,'name'=>"list-blog",'slug'=>"list-blog"],
            ['id'=>37,'name'=>"view-blog",'slug'=>"view-blog"],
            ['id'=>38,'name'=>"add-blog",'slug'=>"add-blog"],
            ['id'=>39,'name'=>"edit-blog",'slug'=>"edit-blog"],
            ['id'=>40,'name'=>"delete-blog",'slug'=>"delete-blog"],

            ['id'=>42,'name'=>"list-gallery",'slug'=>"list-gallery"],
            ['id'=>43,'name'=>"view-gallery",'slug'=>"view-gallery"],
            ['id'=>44,'name'=>"add-gallery",'slug'=>"add-gallery"],
            ['id'=>45,'name'=>"edit-gallery",'slug'=>"edit-gallery"],
            ['id'=>46,'name'=>"delete-gallery",'slug'=>"delete-gallery"],

        ]);
    }
}
