<?php

use App\Models\Author;

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
