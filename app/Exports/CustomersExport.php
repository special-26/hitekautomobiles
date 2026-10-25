<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersExport implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(
        protected string $search = '',
        protected string $filter = '',
        protected string $fromDate = '',
        protected string $toDate = '',
        protected array $customerIds = [],
    ) {}

    public function query(): Builder
    {
        return Customer::query()
            ->with([
                'vehicles:id,customer_id,registration_number,make,model,variant,fuel_type,current_odometer,last_service_at,next_service_at,insurance_expiry_at',
            ])
            ->when($this->search, function ($query) {
                $search = '%' . $this->search . '%';

                $query->where(function ($query) use ($search) {
                    $query->where('name', 'ilike', $search)
                        ->orWhere('phone', 'ilike', $search)
                        ->orWhere('email', 'ilike', $search)
                        ->orWhere('customer_code', 'ilike', $search)
                        ->orWhereHas('vehicles', function ($query) use ($search) {
                            $query->where('registration_number', 'ilike', $search);
                        });
                });
            })

            // Service filters
            ->when($this->filter === 'service_upcoming', function ($query) {
                $query->whereHas('vehicles', function ($query) {
                    $query->whereDate('next_service_at', '>', today())
                        ->whereDate('next_service_at', '<=', today()->addDays(7));
                });
            })
            ->when($this->filter === 'service_due', function ($query) {
                $query->whereHas('vehicles', function ($query) {
                    $query->whereDate('next_service_at', today());
                });
            })
            ->when($this->filter === 'service_overdue', function ($query) {
                $query->whereHas('vehicles', function ($query) {
                    $query->whereDate('next_service_at', '<', today());
                });
            })

            // Insurance filters
            ->when($this->filter === 'insurance_7_days', function ($query) {
                $query->whereHas('vehicles', function ($query) {
                    $query->whereDate('insurance_expiry_at', '>=', today())
                        ->whereDate('insurance_expiry_at', '<=', today()->addDays(7));
                });
            })
            ->when($this->filter === 'insurance_30_days', function ($query) {
                $query->whereHas('vehicles', function ($query) {
                    $query->whereDate('insurance_expiry_at', '>=', today())
                        ->whereDate('insurance_expiry_at', '<=', today()->addDays(30));
                });
            })
            ->when($this->filter === 'insurance_expired', function ($query) {
                $query->whereHas('vehicles', function ($query) {
                    $query->whereDate('insurance_expiry_at', '<', today());
                });
            })

            // Date range
            ->when($this->fromDate, function ($query) {
                if ($this->isServiceFilter() || $this->isInsuranceFilter()) {
                    $query->whereHas('vehicles', function ($query) {
                        $query->whereDate(
                            $this->dateFieldForFilter(),
                            '>=',
                            $this->fromDate
                        );
                    });
                } else {
                    $query->whereDate('created_at', '>=', $this->fromDate);
                }
            })
            ->when($this->toDate, function ($query) {
                if ($this->isServiceFilter() || $this->isInsuranceFilter()) {
                    $query->whereHas('vehicles', function ($query) {
                        $query->whereDate(
                            $this->dateFieldForFilter(),
                            '<=',
                            $this->toDate
                        );
                    });
                } else {
                    $query->whereDate('created_at', '<=', $this->toDate);
                }
            })
            ->when($this->customerIds, function ($query) {
                $query->whereIn('id', $this->customerIds);
            })
            ->latest('id');
    }

    private function isServiceFilter(): bool
    {
        return in_array($this->filter, [
            'service_upcoming',
            'service_due',
            'service_overdue',
        ]);
    }

    private function isInsuranceFilter(): bool
    {
        return in_array($this->filter, [
            'insurance_7_days',
            'insurance_30_days',
            'insurance_expired',
        ]);
    }

    private function dateFieldForFilter(): string
    {
        return match ($this->filter) {
            'service_upcoming',
            'service_due',
            'service_overdue' => 'next_service_at',

            'insurance_7_days',
            'insurance_30_days',
            'insurance_expired' => 'insurance_expiry_at',

            default => 'created_at',
        };
    }

    public function headings(): array
    {
        return [
            'Customer Code',
            'Customer Name',
            'Phone',
            'Email',
            'City',
            'State',
            'Vehicle Number',
            'Vehicle',
            'Variant',
            'Fuel Type',
            'Odometer',
            'Last Service',
            'Next Service',
            'Insurance Expiry',
            'Customer Status',
        ];
    }

    public function map($customer): array
    {
        $vehicle = $customer->vehicles->first();

        return [
            $customer->customer_code,
            $customer->name,
            $customer->phone,
            $customer->email,
            $customer->city,
            $customer->state,
            $vehicle?->registration_number,
            $vehicle
                ? trim($vehicle->make . ' ' . $vehicle->model)
                : null,
            $vehicle?->variant,
            $vehicle?->fuel_type,
            $vehicle?->current_odometer,
            $vehicle?->last_service_at?->format('d-m-Y'),
            $vehicle?->next_service_at?->format('d-m-Y'),
            $vehicle?->insurance_expiry_at?->format('d-m-Y'),
            $customer->is_active ? 'Active' : 'Inactive',
        ];
    }
}
