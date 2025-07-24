<?php

namespace App\Filament\Technician\Resources\ServiceRequestResource\Pages;

use App\Filament\Technician\Resources\ServiceRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewServiceRequest2 extends ViewRecord
{
    protected static string $resource = ServiceRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('assign_to_me')
                ->label('Assign to Me')
                ->icon('heroicon-o-user-plus')
                ->color('success')
                ->visible(fn() => $this->record->status === 'pending')
                ->action(function () {
                    $this->record->update([
                        'technician_id' => auth('technician')->id(),
                        'status' => 'assigned'
                    ]);

                    $this->refreshFormData(['status', 'technician']);
                })
                ->requiresConfirmation()
                ->modalHeading('Assign Request')
                ->modalDescription('Are you sure you want to assign this request to yourself?')
                ->modalSubmitActionLabel('Yes, Assign'),

            Actions\Action::make('mark_completed')
                ->label('Mark as Completed')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn() => $this->record->status === 'assigned' && $this->record->technician_id === auth('technician')->id())
                ->action(function () {
                    // Update status to completed
                    $this->record->update(['status' => 'completed']);

                    // Redirect to bill creation
                    return redirect()->to('/technician/bills/create?service_request_id=' . $this->record->id);
                })
                ->requiresConfirmation()
                ->modalHeading('Mark as Completed')
                ->modalDescription('This will mark the service as completed and take you to create the bill.')
                ->modalSubmitActionLabel('Complete & Create Bill'),

            Actions\Action::make('view_location')
                ->label('Open in Google Maps')
                ->icon('heroicon-o-map-pin')
                ->color('info')
                ->visible(fn() => $this->record->lat && $this->record->lng)
                ->url(fn() => "https://www.google.com/maps?q={$this->record->lat},{$this->record->lng}")
                ->openUrlInNewTab(),

            Actions\Action::make('get_directions')
                ->label('Get Directions')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('warning')
                ->visible(fn() => $this->record->lat && $this->record->lng)
                ->url(fn() => "https://www.google.com/maps/dir//{$this->record->lat},{$this->record->lng}")
                ->openUrlInNewTab(),

            Actions\EditAction::make()
                ->visible(fn() => $this->record->status !== 'completed'),
        ];
    }

    public function getTitle(): string
    {
        return "Service Request #{$this->record->id}";
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // You can add custom widgets here if needed
        ];
    }
}
