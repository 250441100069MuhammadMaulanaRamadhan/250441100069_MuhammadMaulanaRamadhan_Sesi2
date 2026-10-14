<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdatePesananRequest extends StorePesananRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['kode_id'] = [
            'required', 'string', 'max:20',
            Rule::unique('pesanans', 'menu_id')->ignore($this->route('barang')),
        ];

        return $rules;
    }
}