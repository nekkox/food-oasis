<?php

namespace App\DataTables;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SliderDataTable extends DataTable
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

                $edit = "<a href='" . route('admin.slider.edit', $query->id) . "' class='btn btn-primary' style='margin-right:5px'><i class='fas fa-edit'></i></a>";

                $delete = "<a href='" . route('admin.slider.destroy', $query->id) . "' class='btn btn-danger delete-item'><i class='fas fa-trash'></i></a>";

                return $edit . $delete;
            })
            ->addColumn('image', function ($query) {
                return '<img height="30px" src="' . asset($query->image) . '">';
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
            ->rawColumns(['image', 'action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Slider $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('slider-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(0, 'asc')
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ])->parameters([
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

            Column::make('id')->width(60),
            Column::make('image')->width(100),
            Column::make('offer'),
            Column::make('title'),
            Column::make('status'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(110)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Slider_' . date('YmdHis');
    }
}
