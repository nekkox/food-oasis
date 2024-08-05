<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductRatingDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    function index(ProductRatingDataTable $dataTable) : View|JsonResponse {
        return $dataTable->render('admin.product.product-review.index');
    }
}
