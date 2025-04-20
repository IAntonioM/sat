<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\Opciones\HlaRequest;
use App\Models\HlaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class HlaController extends Controller
{
    /**
     * Display HLA page
     *
     * @param HlaRequest $request
     * @return \Illuminate\View\View
     */
    public function index(HlaRequest $request)
    {
        $user = Auth::user();
        $vcodcontr = $user->vcodcontr;
        $year = $request->input('year', date('Y'));
        $usuario =  Session::get('usuario');
        // Get contributor data
        $contributor = HlaModel::getContributorData($vcodcontr);

        // Get HLA details
        $hlaDetails = HlaModel::getHlaDetail($vcodcontr, $year);

        // Get HLA summary
        $hlaSummary = HlaModel::getHlaSummary($vcodcontr, $year);

        // Get HLP data (property tax)
        $hlpData = HlaModel::getHlpData($vcodcontr, $year);

        return view('HLA', compact(
            'contributor',
            'hlaDetails',
            'hlaSummary',
            'hlpData',
            'year',
            'usuario'
        ));
    }

    /**
     * Get HLA data via AJAX
     *
     * @param HlaRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHlaData(HlaRequest $request)
    {
        $user = Auth::user();
        $vcodcontr = $user->vcodcontr;
        $year = $request->input('year', date('Y'));

        // Get HLA details
        $hlaDetails = HlaModel::getHlaDetail($vcodcontr, $year);

        // Get HLA summary
        $hlaSummary = HlaModel::getHlaSummary($vcodcontr, $year);

        return response()->json([
            'hlaDetails' => $hlaDetails,
            'hlaSummary' => $hlaSummary
        ]);
    }

    /**
     * Export HLA data as PDF
     *
     * @param HlaRequest $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    /*
    public function exportPdf(HlaRequest $request)
    {
        $user = Auth::user();
        $vcodcontr = $user->vcodcontr;
        $year = $request->input('year', date('Y'));

        // Get contributor data
        $contributor = HlaModel::getContributorData($vcodcontr);

        // Get HLA details
        $hlaDetails = HlaModel::getHlaDetail($vcodcontr, $year);

        // Get HLA summary
        $hlaSummary = HlaModel::getHlaSummary($vcodcontr, $year);

        // Get HLP data (property tax)
        $hlpData = HlaModel::getHlpData($vcodcontr, $year);

        // Generate PDF (this is just a placeholder - you'll need to implement your PDF generation logic)
        $pdf = PDF::loadView('hla.pdf', compact(
            'contributor',
            'hlaDetails',
            'hlaSummary',
            'hlpData',
            'year'
        ));

        return $pdf->download('HLA-' . $vcodcontr . '-' . $year . '.pdf');
    }*/

}
