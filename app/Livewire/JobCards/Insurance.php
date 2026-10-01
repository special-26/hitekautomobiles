<?php

namespace App\Livewire\JobCards;

use Livewire\Component;

class Insurance extends Component
{
    public $jobCard;

    public $insurance;

    public $claim;

    public $documents = [];

    public function mount($jobCard)
    {
        $this->jobCard = [
            'id' => $jobCard,
            'vehicle_no' => 'CH01BT9020',
            'vehicle' => 'Hyundai Creta 1.6',
            'customer' => 'Mrs. Indu Narula',
        ];

        $this->insurance = [
            'company' => 'National Insurance Co. Ltd.',
            'policy_number' => 'NIA/CHD/2026/458721',
            'policy_type' => 'Comprehensive',
            'policy_start' => '15 Mar 2026',
            'policy_expiry' => '14 Mar 2027',
            'insured_declared_value' => 725000,
            'customer_contribution' => 12500,
            'cashless' => true,
        ];

        $this->claim = [
            'claim_number' => 'NIC/CLM/2026/78214',
            'status' => 'Approved',
            'intimation_date' => '23 Sep 2026',
            'survey_date' => '24 Sep 2026',
            'approval_date' => '25 Sep 2026',
            'approved_amount' => 34750,
            'surveyor_name' => 'Mr. Rajesh Sharma',
            'surveyor_phone' => '9876543210',
            'remarks' => 'Claim approved after vehicle inspection. Parts replacement and repair work authorized.',
        ];

        $this->documents = [
            [
                'id' => 1,
                'name' => 'Insurance Policy',
                'type' => 'PDF',
                'uploaded_by' => 'Basant Joshi',
                'uploaded_at' => '23 Sep 2026, 09:35 AM',
                'status' => 'Verified',
            ],
            [
                'id' => 2,
                'name' => 'RC Copy',
                'type' => 'PDF',
                'uploaded_by' => 'Basant Joshi',
                'uploaded_at' => '23 Sep 2026, 09:36 AM',
                'status' => 'Verified',
            ],
            [
                'id' => 3,
                'name' => 'Claim Approval Letter',
                'type' => 'PDF',
                'uploaded_by' => 'Basant Joshi',
                'uploaded_at' => '25 Sep 2026, 02:15 PM',
                'status' => 'Verified',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.job-cards.insurance')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['id'] . ' - Insurance',
            ]);
    }
}
