<?php

namespace App\DataTables;

use App\Models\Address;
use Form;
use Yajra\Datatables\Services\DataTable;

class AddressDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'addresses.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $addresses = Address::query();

        return $this->applyScopes($addresses);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->addAction(['width' => '10%'])
            ->ajax('')
            ->parameters([
                'dom' => 'Bfrtip',
                'scrollX' => false,
                'buttons' => [
                    'print',
                    'reset',
                    'reload',
                    [
                         'extend'  => 'collection',
                         'text'    => '<i class="fa fa-download"></i> Export',
                         'buttons' => [
                             'csv',
                             'excel',
                             'pdf',
                         ],
                    ],
                    'colvis'
                ]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'street_address' => ['name' => 'street_address', 'data' => 'street_address'],
            'postal_code' => ['name' => 'postal_code', 'data' => 'postal_code'],
            'address_region' => ['name' => 'address_region', 'data' => 'address_region'],
            'address_locality' => ['name' => 'address_locality', 'data' => 'address_locality'],
            'address_country' => ['name' => 'address_country', 'data' => 'address_country']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'addresses';
    }
}
