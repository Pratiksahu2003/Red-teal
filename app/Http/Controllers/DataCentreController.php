<?php

namespace App\Http\Controllers;

use App\Models\DataCentre;

class DataCentreController extends Controller
{
    public function index()
    {
        $dataCentre = DataCentre::instance();

        return view('data-centre.index', [
            'dataCentre' => $dataCentre,
            'specifications' => $dataCentre->specifications()->where('is_active', true)->get(),
            'features' => $dataCentre->features()->where('is_active', true)->get(),
            'gallery' => $dataCentre->gallery()->where('is_active', true)->get(),
        ]);
    }
}
