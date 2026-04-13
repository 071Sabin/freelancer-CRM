<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;

use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;

class ClientList extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Client::query()
                    ->with('currency')
                    ->where('user_id', auth()->id())
                    ->select([
                        'id',
                        'user_id',
                        'client_name',
                        'client_email',
                        'company_name',
                        'company_email',
                        'currency_id',
                        'hourly_rate',
                        'status',
                        'created_at',
                        'deleted_at',
                    ])
            )

            // optional (enable later)
            // ->deferLoading()

            ->columns([
                // CLIENT NAME + EMAIL (like your HTML)
                TextColumn::make('client_name')
                    ->label('Client Name')
                    ->searchable()
                    ->sortable(),

                // COMPANY
                TextColumn::make('company_name')
                    ->label('Company'),

                // HOURLY RATE
                TextColumn::make('hourly_rate')
                    ->label('Hourly Rate')
                    ->sortable()
                    ->formatStateUsing(function ($state, Client $record) {
                        return strtoupper($record->currency->code ?? 'USD') . ' ' . strtoupper($state);
                    }),

                // STATUS (converted from your HTML badges)
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Active' => 'success',
                        'Inactive' => 'danger',
                        'Lead' => 'warning',
                        default => 'gray',
                    }),

                // CREATED
                TextColumn::make('created_at')
                    ->label('Created')
                    ->since()
                    ->sortable(),

                // ACTIONS (your blade component)
                TextColumn::make('id')
                    ->label('Actions'),
            ])

            ->filters([
                // STATUS FILTER
                SelectFilter::make('status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                        'Lead' => 'Lead',
                    ]),

                // DELETED FILTER (SoftDeletes support)
                SelectFilter::make('deleted')
                    ->label('Deleted')
                    ->options([
                        'all' => 'All',
                        'deleted' => 'Deleted',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (($data['value'] ?? null) === 'deleted') {
                            $query->onlyTrashed();
                        }
                    }),
            ])

            ->actions([
                // SINGLE DELETE (optional if you already have custom actions)
                Action::make('delete')
                    ->requiresConfirmation()
                    ->action(fn(Client $record) => $record->delete()),
            ])

            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('deleteSelected')
                        ->label('Delete Selected')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            DB::transaction(function () use ($records) {
                                foreach ($records as $record) {
                                    if ($record->user_id === auth()->id()) {
                                        $record->delete();
                                    }
                                }
                            });
                        }),
                ]),
            ])

            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(10);
    }

    public function render()
    {
        return view('livewire.client-list');
    }
}
