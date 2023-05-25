<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdministratorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'bod'=> is_null($this->bod) || is_string($this->bod)  ? null  : $this->bod->format('d/m/Y H:i:s'),
            'created_at'=> $this->created_at ? $this->created_at->format('d/m/Y H:i:s') : null ,
            'updated_at'=> $this->updated_at ? $this->updated_at->format('d/m/Y H:i:s') : null ,

        ];
    }
}
