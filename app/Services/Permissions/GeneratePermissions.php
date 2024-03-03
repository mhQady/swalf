<?php

namespace App\Services\Permissions;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class GeneratePermissions
{
    const GUARD = 'admin';

    public static function generatePermissions()
    {
        $permissions = Permission::select('name', 'model', 'guard_name')->get();

        foreach (self::getModels() as $model) {
            self::generateFor($model, $permissions);
        }

        foreach (self::customPermissions() as $model => $permission) {
            if (is_array($permission)) {
                foreach ($permission as $per) {
                    self::createPermission($model, $per);
                }
            } else {
                self::createPermission($model, $permission);
            }
        }
    }

    protected static function generateFor($model, $savedPermissions)
    {
        foreach (self::staticPermissions() as $permission) {
            $permissionExists = $savedPermissions->contains(function ($permissionRecord) use ($permission, $model) {
                return $permissionRecord->name == "$permission $model" &&
                    $permissionRecord->model == $model && $permissionRecord->guard_name == self::GUARD;
            });
            if (!$permissionExists) {
                self::createPermission($model, $permission);
            }
        }
    }

    protected static function createPermission($model, $permission)
    {
        Permission::firstOrCreate(['name' => "$permission $model", 'model' => $model, 'guard_name' => self::GUARD]);
    }

    protected static function getModels()
    {
        $modelFiles = Storage::disk('app')->files('Models');

        $models = collect($modelFiles)->map(function ($modelFile) {
            $model = str_replace('.php', '', $modelFile);

            $model = str_replace('Models/', '', $model);

            return Str::lower($model);
        })->diff(self::diffModels())->merge(self::mergeModels());
        return $models;
    }

    protected static function mergeModels(): array
    {
        return [
            'role',
            'trash',
            'storerequestin',
            'storerequestout',

        ];
    }

    protected static function diffModels(): array
    {
        return [
            'devicetoken',
            'invoicepiece',
            'storerequest',
            'storerequestdetail',
            'storerequestdetailwithproductname',
            'storetransaction',
            'productattribute',
            'productstore',
            'workorderproduct',
            'cart',
            'cartitem',
            'safe',
            'safetransaction',
            'invoiceproduct',
            'manufacturepermitproduct',
            'workorder',
            'covenantproduct',
            'purchaseorderproduct',
            'whatsappconversation',
            'whatsappchat',
            'transaction',
            'orderproduct',
            'whatsappticket',
            'purchaseordersettle',
            'price_offer_products',
            'settleproduct',
            'salaryhistory',
            'offerpriceproducts',
            'offerpricesettles'
        ];
    }

    public static function staticPermissions(): array
    {
        return [
            'browse',
            'add',
            'edit',
            'delete',
        ];
    }

    protected static function customPermissions(): array
    {
        return [
            'hr' => 'allow',
            'maintenance' => 'allow',
            'maintenance_app' => 'allow',
            'store' => 'allow',
            'pos' => ['browse', 'allow'],
            'manufacturing' => 'allow',
            'purchase' => 'allow',
            'crm' => 'allow',
            'settings' => ['allow', 'update_salary_settings'],
            'leaverequest' => [
                'browse_all',
                'add_for_team_member',
                'browse_for_team_member'
            ],
            'deduction' => [
                'add_for_team_member',
                'change_status',
            ],
            'reward' => [
                'add_for_team_member',
                'change_status'
            ],
            'manufacturepermit' => 'show',
            'purchaseorder' => [
                'review',
                'settle',
                'receive'
            ],
            'purchase_requests' => [
                'browse',
                'show',
                'delete',
                'edit',
                'add',
                'pricing'
            ],
            'product' => [
                'print product barcode'
            ],
            'workorder' => [
                'browse',
                'delete',
                'browse_representative',
                //  مندوب
                'browse_prices_man',
                // المسعر
                'browse_supervisor',
                'browse_sales_manager',
                'browse_general_manager',
                'browse_reviewer',
                'browse_manufacturing',
                'browse_sales',
                'browse_store',
            ],
            'offerprice' => [
                'act_as_direct_manager',
                'act_as_general_manager',
                'act_as_coordinator',
                'act_as_pricing_administrator',
                'review_contract'
            ],
            'offer_price_discount' => [
                'edit'
            ],
            'chats' => [
                'browse',
                'answer'
            ],
            'whatsapp_ticket' => [
                'browse',
            ],
            'team' => [
                'browse_as_leader',
                'show',
            ],
            'salaryraise' => [
                'change_status',
            ],
            'salary' => 'show',
            'employee' => [
                'show',
                'contracttermination',
            ],
        ];
    }
}
