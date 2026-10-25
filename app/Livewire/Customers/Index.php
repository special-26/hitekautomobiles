<?php

namespace App\Livewire\Customers;

use App\Exports\CustomersExport;
use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filter = '';

    public string $fromDate = '';
    public string $toDate = '';

    public string $appliedFromDate = '';
    public string $appliedToDate = '';

    public array $selectedCustomers = [];
    public bool $selectAll = false;
    public bool $selectAllResults = false;

    public function updatedSearch(): void
    {
        $this->clearCustomerSelection();
        $this->resetPage();
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
        $this->clearCustomerSelection();
        $this->resetPage();
    }

    public function applyDateFilter(): void
    {
        $this->appliedFromDate = $this->fromDate;
        $this->appliedToDate = $this->toDate;

        $this->clearCustomerSelection();

        $this->resetPage();
    }

    public function clearDateFilter(): void
    {
        $this->fromDate = '';
        $this->toDate = '';

        $this->appliedFromDate = '';
        $this->appliedToDate = '';

        $this->clearCustomerSelection();

        $this->resetPage();
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

    private function customerQuery()
    {
        return Customer::query()
            ->withCount([
                'vehicles',
                'jobCards',
            ])
            ->with([
                'vehicles:id,customer_id,registration_number,make,model,variant,fuel_type,current_odometer,last_service_at,next_service_at,insurance_expiry_at',
            ])

            // Search
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

            // Applied date range
            ->when($this->appliedFromDate, function ($query) {
                if ($this->isServiceFilter() || $this->isInsuranceFilter()) {
                    $query->whereHas('vehicles', function ($query) {
                        $query->whereDate(
                            $this->dateFieldForFilter(),
                            '>=',
                            $this->appliedFromDate
                        );
                    });
                } else {
                    $query->whereDate('created_at', '>=', $this->appliedFromDate);
                }
            })

            ->when($this->appliedToDate, function ($query) {
                if ($this->isServiceFilter() || $this->isInsuranceFilter()) {
                    $query->whereHas('vehicles', function ($query) {
                        $query->whereDate(
                            $this->dateFieldForFilter(),
                            '<=',
                            $this->appliedToDate
                        );
                    });
                } else {
                    $query->whereDate('created_at', '<=', $this->appliedToDate);
                }
            })

            ->latest('id');
    }

    public function render()
    {
        $customers = $this->customerQuery()
            ->paginate(20);

        $summary = [
            'all' => Customer::count(),

            'service_upcoming' => Customer::whereHas('vehicles', function ($query) {
                $query->whereBetween('next_service_at', [
                    today()->addDay(),
                    today()->addDays(7),
                ]);
            })->count(),

            'service_due' => Customer::whereHas('vehicles', function ($query) {
                $query->whereDate('next_service_at', today());
            })->count(),

            'service_overdue' => Customer::whereHas('vehicles', function ($query) {
                $query->whereDate('next_service_at', '<', today());
            })->count(),

            'insurance_7_days' => Customer::whereHas('vehicles', function ($query) {
                $query->whereBetween('insurance_expiry_at', [
                    today(),
                    today()->addDays(7),
                ]);
            })->count(),

            'insurance_30_days' => Customer::whereHas('vehicles', function ($query) {
                $query->whereBetween('insurance_expiry_at', [
                    today(),
                    today()->addDays(30),
                ]);
            })->count(),

            'insurance_expired' => Customer::whereHas('vehicles', function ($query) {
                $query->whereDate('insurance_expiry_at', '<', today());
            })->count(),
        ];

        return view('livewire.customers.index', [
            'customers' => $customers,
            'summary' => $summary,
        ])->layout('components.layouts.management', [
            'title' => 'Customers',
        ]);
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

    public function toggleSelectAll(): void
    {
        $this->selectAll = ! $this->selectAll;

        if ($this->selectAll) {
            $this->selectedCustomers = $this->customerQuery()
                ->forPage($this->getPage(), 20)
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();
        } else {
            $this->selectedCustomers = [];
        }

        $this->selectAllResults = false;
    }

    public function selectAllMatchingResults(): void
    {
        $this->selectAllResults = true;
        $this->selectAll = true;
    }

    public function clearSelection(): void
    {
        $this->selectedCustomers = [];
        $this->selectAll = false;
        $this->selectAllResults = false;
    }

    public function exportCustomers()
    {
        $total = $this->customerQuery()->count();

        if ($total === 0) {
            $this->dispatch('notify', type: 'error', message: 'No customers found to export.');
            return;
        }

        $limit = min($this->exportLimit, $total);

        return Excel::download(
            new CustomersExport(
                search: $this->search,
                filter: $this->filter,
                fromDate: $this->appliedFromDate,
                toDate: $this->appliedToDate,
                limit: $limit,
            ),
            'hitek-customers-' . now()->format('Y-m-d-His') . '.xlsx'
        );
    }

    private function clearCustomerSelection(): void
    {
        $this->selectedCustomers = [];
        $this->selectAll = false;
        $this->selectAllResults = false;
    }

    public function exportSelected()
    {
        if (! $this->selectAllResults && empty($this->selectedCustomers)) {
            return;
        }

        $filename = 'customers-' . now()->format('Y-m-d-His') . '.xlsx';

        if ($this->selectAllResults) {
            return Excel::download(
                new CustomersExport(
                    search: $this->search,
                    filter: $this->filter,
                    fromDate: $this->appliedFromDate,
                    toDate: $this->appliedToDate,
                ),
                $filename
            );
        }

        return Excel::download(
            new CustomersExport(
                search: $this->search,
                filter: $this->filter,
                fromDate: $this->appliedFromDate,
                toDate: $this->appliedToDate,
                customerIds: array_map('intval', $this->selectedCustomers),
            ),
            $filename
        );
    }
}
