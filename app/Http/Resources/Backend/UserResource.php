<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $status ='Inactive';
        if ( $this->status == 1 ) {
            $status ='Active';
        }  else if($this->status == 2){
            $status ='Rejected';
        }
        $status = ['label'=> ucfirst(strtolower(str_replace('_',' ',$status))), 'class'=>'bg-'.$status];
        return [
            'id' => $this->id,
            'name' => $this->name,
            'customer_role' => $this->customer_role ?  json_decode($this->customer_role) : [],
            'country' => $this->country,
            'company' => $this->company,
            'phone' => $this->phone,
            'pic' => $this->pic,
            'last_name' => $this->last_name,
            'title' => $this->title ?? 'Marketing Strategy Officer',
            'email' => $this->email,
            'slug' => $this->slug,
            'roles' => $this->roles ? json_decode($this->roles) : [],
            'status' =>  $status
         ];
    }
}
