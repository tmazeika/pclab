<?php

namespace PCLab\Models;

use PCLab\Presenters\StorageComponentPresenter;

/**
 * @property int id
 * @property int capacity
 * @property bool is_ssd
 * @property string width
 */
class StorageComponent extends ComponentChild
{
    protected $fillable = [
        'capacity',
        'is_ssd',
        'width',
    ];

    protected $presenter = StorageComponentPresenter::class;
}
