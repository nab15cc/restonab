<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MahasiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_menu' => $this->id_menu,
            'nama_menu' => $this->nama_menu,
            'kategori' => $this->kategori,
            'harga' => $this->harga,
            'deskripsi' => $this->deskripsi,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    public function with(Request $request): array
    {
        return [
            'success' => true,
            'message' => 'Data berhasil diambil'
        ];
    }
}
