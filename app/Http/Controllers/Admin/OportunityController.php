<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Api\SalesApi;
use App\Api\LeadsApi;
use App\Api\ProductApi;
use App\Api\OportunityApi;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OportunityController extends Controller
{
  protected $salesApi, $leadsApi, $oportunityApi, $productApi;

  public function __construct(SalesApi $salesApi, LeadsApi $leadsApi, OportunityApi $oportunityApi
      , ProductApi $productApi)
  {
    $this->salesApi = $salesApi;
    $this->leadsApi = $leadsApi;
    $this->productApi = $productApi;
    $this->oportunityApi = $oportunityApi;

    view()->share('menuActive', 'oportunities');
  }

  public function index()
  {
    $oportunities = $this->oportunityApi->getAll();
    return view('admin.oportunities.index', compact('oportunities'));
  }

  public function create()
  {
    $sales = $this->salesApi->getAll();
    $leads = $this->leadsApi->getAll();
    $products = $this->productApi->getAll();

    return view('admin.oportunities.create', compact('sales', 'leads', 'products'));
  }

  public function store(Request $request)
  {
    $validator = \Validator::make($request->all(), [
      'judul' => 'required',
      'deskripsi' => 'required',
      'jumlah_step' => 'required|numeric'
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withInput()->withErrors($validator);
    }

    $this->oportunityApi->create($request->all());
    return redirect()->to('oportunities');
  }

  public function edit($id)
  {
    $sales = $this->salesApi->getAll();
    $leads = $this->leadsApi->getAll();
    $products = $this->productApi->getAll();
    $oportunity = $this->oportunityApi->getById($id);
    return view('admin.oportunities.edit', compact('oportunity', 'sales', 'products', 'leads'));
  }

  public function update(Request $request, $id)
  {
    $oportunity = $this->oportunityApi->getById($id);

    $this->oportunityApi->update($id, $request);

    return redirect()->to('oportunities');
  }

  public function show($id)
  {
    $oportunity =  $this->oportunityApi->getById($id);
    return view('admin.oportunities.show', compact('oportunity'));
  }
}
