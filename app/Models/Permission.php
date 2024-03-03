<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Permission extends \Spatie\Permission\Models\Permission
{
    protected static $abilities;

    protected static $models;

    protected static $permissions;

    public static function defaultPermissions()
    {
        #custom permissions
        self::$permissions = collect([]);

        self::$abilities = collect(['view', 'add', 'edit', 'delete']);

        $files = Storage::disk('app')->files('Models');

        self::$models = collect($files)->map(fn($file) => basename($file, '.php'));

        self::$models->map(fn($model) => self::$abilities->map(function ($ability) use ($model) {

            // dd($model, self::$models);

            if (in_array($model, self::diffModels()))
                return;

            $perm = $ability . '_' . Str::plural(Str::lower($model));

            self::$permissions->push(['name' => $perm, 'model' => Str::plural(Str::lower($model))]);
        }))->diff(self::diffModels());

        return self::$permissions;
    }

    protected static function diffModels(): array
    {
        return [
            'Otp',
        ];
    }

}
