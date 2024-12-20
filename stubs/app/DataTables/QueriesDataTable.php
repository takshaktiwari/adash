<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Takshak\Adash\Models\Query;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class QueriesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                $html = '';
                $html .= view('components.admin.btns.action-show', ['url' => route('admin.queries.show', $item->id)]);
                $html .= view('components.admin.btns.action-delete', ['url' => route('admin.queries.destroy', $item->id)]);

                return $html;
            })
            ->editColumn('created_at', fn ($item) => $item->created_at->diffForHumans())
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Query $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('queries-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"d-flex mb-2 justify-content-between flex-wrap gap-3"<"d-flex gap-3"lB>f>rt<"d-flex justify-content-between flex-wrap gap-3 mt-3"ip>')
            ->selectStyleSingle()
            ->responsive(true)
            ->pageLength(100)
            ->serverSide(true) // Enable server-side processing
            ->processing(true)
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('#')
                ->searchable(false)
                ->orderable(false)
                ->exportable(false)
                ->printable(true)
                ->width(30)
                ->addClass('text-center'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
            Column::make('name'),
            Column::make('email'),
            Column::make('mobile'),
            Column::make('subject'),
            Column::make('origin'),
            Column::make('title'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Queries_' . date('YmdHis');
    }
}
