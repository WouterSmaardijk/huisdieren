<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'type_id', 'address'];

    public function type()
    {
        return $this->belongsTo(PetType::class);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type->type,
            'address' => $this->address,
        ];
    }

}
