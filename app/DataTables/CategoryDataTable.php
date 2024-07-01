<?php

namespace App\DataTables;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'category.action')
            ->addColumn('show_at_home',function ($query){
                $active = "<span class='badge bg-info text-white'>Yes</span>";
                $inactive = "<span class='badge bg-danger text-white'>No</span>";
                if ($query->show_at_home === 1) {
                    return $active;
                } else {
                    return $inactive;
                }
            })
            ->addColumn('status',function ($query){
                $active = "<span class='badge bg-info text-white'>Active</span>";
                $inactive = "<span class='badge bg-danger text-white'>InActive</span>";
                if ($query->status === 1) {
                    return $active;
                } else {
                    return $inactive;
                }
            })
            ->addColumn('action', function ($query) {

                $edit = "<a href='" . route('admin.category.edit', $query->id) . "' class='btn btn-primary' style='margin-right:5px'><i class='fas fa-edit'></i></a>";

                $delete = "<a href='" . route('admin.category.destroy', $query->id) . "' class='btn btn-danger delete-item'><i class='fas fa-trash'></i></a>";

                return $edit . $delete;
            })
            ->rawColumns(['show_at_home','status','action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Category $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('category-table')
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

            Column::make('id'),
            Column::make('name'),
            Column::make('status'),
            Column::make('show_at_home'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Category_' . date('YmdHis');
    }
}
