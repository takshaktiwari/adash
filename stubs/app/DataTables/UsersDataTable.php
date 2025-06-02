<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->editColumn('created_at', function ($item) {
                return '<span class="text-nowrap">' . $item->created_at->format('Y-m-d h:i A') . '</span>';
            })
            ->addColumn('role', function ($user) {
                return $user->roles->pluck('name')->implode(', ');
            })
            ->orderColumn('role', function ($query, $order) {
                $query->withCount(['roles' => function ($query) use ($order) {
                    $query->orderBy('name', $order);
                }])->orderBy('roles_count', $order);
            })
            ->addColumn('action', function ($user) {
                $html = '';

                $html .= view('components.admin.btns.action-show', [
                    'permission' => 'users_show',
                    'url' => route('admin.users.show', [$user])
                ]);

                $html .= view('components.admin.btns.action-edit', [
                    'permission' => 'users_update',
                    'url' => route('admin.users.edit', [$user])
                ]);

                if ($user->id != 1) {
                    $html .= view('components.admin.btns.action-delete', [
                        'permission' => 'users_delete',
                        'url' => route('admin.users.destroy', [$user])
                    ]);
                }

                return $html;
            })
            ->rawColumns(['action', 'created_at']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(): QueryBuilder
    {
        return User::query()->with('roles')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"d-flex mb-2 justify-content-between flex-wrap gap-3"<"d-flex gap-3"lB>f>rt<"d-flex justify-content-between flex-wrap gap-3 mt-3"ip>')
            ->selectStyleSingle()
            ->responsive(true)
            ->pageLength(100)
            ->serverSide(true) // Enable server-side processing
            ->processing(true)
            ->stateSave(true)
            ->buttons([
                // Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                // Button::make('print'),
                // Button::make('reset'),
                Button::make('reload'),
                Button::raw([
                    'extend' => 'colvis',
                    'text' => '<i class="fas fa-columns"></i>',
                    'className' => 'btn btn-secondary btn-sm'
                ]),
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

            Column::make('name'),
            Column::make('email'),
            Column::make('mobile'),
            Column::make('role'),
            Column::make('created_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->width(60)
                ->addClass('text-center text-nowrap'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
