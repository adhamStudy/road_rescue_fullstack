<?php

namespace App\Filament\Technician\Resources\BillResource\Pages;

use App\Filament\Technician\Resources\BillResource;
use App\Models\ServiceRequest;
use Filament\Resources\Pages\CreateRecord;

class CreateBill extends CreateRecord
{
    protected static string $resource = BillResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure technician_id is set to current technician
        $data['technician_id'] = auth('technician')->id();

        // Ensure total_amount is calculated if not present
        if (!isset($data['total_amount']) || empty($data['total_amount'])) {
            $basePrice = $data['base_price'] ?? 0;
            $nightTax = $data['night_tax'] ?? 0;
            $data['total_amount'] = $basePrice + $nightTax;
        }

        // Ensure night_tax is set
        if (!isset($data['night_tax'])) {
            $data['night_tax'] = 0.00;
        }

        return $data;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Bill created successfully!';
    }

    public function mount(): void
    {
        parent::mount();

        // Check if we have a service_request_id from URL
        $serviceRequestId = request()->get('service_request_id');

        if ($serviceRequestId) {
            $serviceRequest = ServiceRequest::with(['user', 'service', 'technician'])->find($serviceRequestId);

            if ($serviceRequest && $serviceRequest->technician_id === auth('technician')->id()) {
                // Pre-fill the form with service request data
                $isNightService = now()->hour >= 22 || now()->hour < 6;
                $nightTax = $isNightService ? ($serviceRequest->service->price * 0.5) : 0;

                $this->form->fill([
                    'service_request_id' => $serviceRequest->id,
                    'user_id' => $serviceRequest->user_id,
                    'technician_id' => $serviceRequest->technician_id,
                    'service_id' => $serviceRequest->service_id,
                    'base_price' => $serviceRequest->service->price,
                    'is_night_service' => $isNightService,
                    'night_tax' => $nightTax,
                    'total_amount' => $serviceRequest->service->price + $nightTax,
                    'status' => 'pending',
                ]);
            }
        }
    }
}
