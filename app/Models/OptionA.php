<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionA extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'option_a';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'opt_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'opt_a',
        'data_a',
        'order',
    ];

    /**
     * Get options by type
     *
     * @param string $type
     * @return \Illuminate\Support\Collection
     */
    public static function getOptions($type)
    {
        return self::where('opt_a', $type)
            ->orderBy('order', 'asc')
            ->pluck('data_a');
    }
}
