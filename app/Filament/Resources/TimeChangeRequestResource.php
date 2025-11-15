<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimeChangeRequestResource\Pages;
use App\Models\TimeChangeRequest;
use App\Models\Attendance;
use App\Models\Employees;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class TimeChangeRequestResource extends Resource
{
    protected static ?string $model = TimeChangeRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Human Resource';
    
    protected static ?string $navigationLabel = 'Time Change Requests';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('employee_id')
                    ->default(auth()->id()),
                Forms\Components\Hidden::make('manager_id')
                    ->default(fn () => auth()->user()->manager_id ?? auth()->id()),
                
                Section::make('Time and Date')
                    ->schema([
                        DatePicker::make('date')->required(),
                        Grid::make(2)->schema([
                            TimePicker::make('check_in'),
                            TimePicker::make('check_out'),
                        ])
                    ]),
                
                Section::make('Reason for Request')
                    ->schema([
                        Textarea::make('reason')
                            ->required()
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.first_name')->label('Employee')->searchable()->sortable(),
                TextColumn::make('manager.first_name')->label('Manager')->searchable()->sortable(),
                TextColumn::make('date')->date()->sortable(),
                TextColumn::make('check_in')->time(),
                TextColumn::make('check_out')->time(),
                TextColumn::make('reason')->limit(50),
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn ($record) => $record->status === 'pending' && auth()->user()->id === $record->manager_id)
                    ->action(function (TimeChangeRequest $record) {
                        $record->update(['status' => 'approved']);

                        Attendance::create([
                            'employee_id' => $record->employee_id,
                            'date' => $record->date,
                            'check_in' => $record->check_in,
                            'check_out' => $record->check_out,
                            'status' => 'present',
                        ]);

                        Notification::make()
                            ->title('Request Approved')
                            ->success()
                            ->send();
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->visible(fn ($record) => $record->status === 'pending' && auth()->user()->id === $record->manager_id)
                    ->action(function (TimeChangeRequest $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()
                            ->title('Request Rejected')
                            ->success()
                            ->send();
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        $managed_employee_ids = Employees::where('manager_id', $user->id)->pluck('id');

        if ($managed_employee_ids->isNotEmpty()) {
            return $query->where('manager_id', $user->id)
                         ->orWhere('employee_id', $user->id);
        }

        return $query->where('employee_id', $user->id);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTimeChangeRequests::route('/'),
            'create' => Pages\CreateTimeChangeRequest::route('/create'),
        ];
    }
}
