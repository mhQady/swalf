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

            if (!$permissionExists)
                self::createPermission($model, $permission);

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

        })
            ->diff(self::diffModels())
            ->merge(self::mergeModels());

        return $models;
    }

    protected static function mergeModels(): array
    {
        return [

        ];
    }

    protected static function diffModels(): array
    {
        return [
            'otp'
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
            // 'salary' => 'show',
            // 'employee' => [
            //     'show',
            //     'contracttermination',
            // ],
        ];
    }
}
