<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {

                $edit = "<a href='" . route('admin.product.edit', $query->id) . "' class='btn btn-primary' style='margin-right:5px'><i class='fas fa-edit'></i></a>";

                $delete = "<a href='" . route('admin.product.destroy', $query->id) . "' class='btn btn-danger delete-item' style='margin-right:5px;'><i class='fas fa-trash'></i></a>";

                $more = '<div class="btn-group dropleft flex-column " style="height: 24px; ">
                      <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                      <i class="fas fa-cog fa-2xs"></i>
                      </button>
                      <div class="dropdown-menu dropleft" x-placement="left-start" style="position: absolute; transform: translate3d(-2px, 0px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="'.route('admin.product-gallery.show-index', $query->id).'">Product Gallery</a>

                      </div>
                    </div>';

                return '<div  class=" ">'.$edit . $delete . $more.'</div>';
            })
            ->addColumn('price', function ($query) {
                return '$' . $query->price;
            })
            ->addColumn('offer_price', function ($query) {
                return '$' . $query->offer_price;
            })
            ->addColumn('status', function ($query) {
                $active = "<span class='badge bg-info text-white'>Active</span>";
                $inactive = "<span class='badge bg-danger text-white'>InActive</span>";
                if ($query->status === 1) {
                    return $active;
                } else {
                    return $inactive;
                }
            })
            ->addColumn('show_at_home', function ($query) {
                $active = "<span class='badge bg-info text-white'>Yes</span>";
                $inactive = "<span class='badge bg-danger text-white'>No</span>";
                if ($query->show_at_home === 1) {
                    return $active;
                } else {
                    return $inactive;
                }
            })
            ->addColumn('image', function ($query) {
                return "<img height='50px' src='" . asset($query->thumb_image) . "'>";
            })
            ->rawColumns(['status', 'action', 'show_at_home', 'image'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('product-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(0)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ])
            ->parameters([
                'createdRow' => 'function(row, data, dataIndex) {
                            $(row).addClass("list-group-item-action item");
                        }',
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('id'),
            Column::make('image'),
            Column::make('name'),
            Column::make('price'),
            Column::make('offer_price'),
            Column::make('show_at_home'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}
