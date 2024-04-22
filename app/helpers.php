<?php

use App\Models\Author;

function setting($name, $value)
{
    $settings = [];
    if (\Illuminate\Support\Facades\File::exists(config_path('settings.php'))) {
        $settings = require config_path('settings.php');
    }

    $settings[$name] = $value;

    $parsable_string = var_export($settings, true);

    $content = "<?php return {$parsable_string};";

    \Illuminate\Support\Facades\File::put(config_path('settings.php'), $content);
    \Illuminate\Support\Facades\Artisan::call('config:clear');
}

function author($id, $name)
{
    return Author::firstOrCreate(
        ['slack_id' => $id],
        ['name' => $name]
    );
}

function conversion($file, $conversion) {
    return 'media/'.$conversion.'/'.$file->id.'/'.$file->name;
}

function media($file) {
    return 'media/'.$file->id.'/'.$file->name;
}
