<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeShiftResource\Pages;
use App\Models\EmployeeShift;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeeShiftResource extends Resource
{
    protected static ?string $model = EmployeeShift::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Human Resource';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Shift Details')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->prefixIcon('heroicon-o-identification')
                                    ->maxLength(255),
                                Forms\Components\Group::make()->schema([
                                    Forms\Components\TimePicker::make('start_time')
                                        ->required()
                                        ->prefixIcon('heroicon-o-sun'),
                                        
                                    Forms\Components\TimePicker::make('end_time')
                                        ->required()
                                        ->prefixIcon('heroicon-o-moon'),
                                       
                                ])->columns(2),
                                Forms\Components\TextInput::make('grace_period')
                                    ->numeric()
                                    ->prefixIcon('heroicon-o-clock')
                                    ->label('Grace Period (minutes)'),
                            ]),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status & Appearance')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active')
                                    ->onIcon('heroicon-o-check')
                                    ->offIcon('heroicon-o-x-mark')
                                    ->required(),
                                Forms\Components\ColorPicker::make('color')
                                    ->prefixIcon('heroicon-o-swatch'),
                            ]),
                    ])->columnSpan(['lg' => 1]),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull(),
                    ])->columnSpanFull(),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->icon('heroicon-o-sun'),
                Tables\Columns\TextColumn::make('end_time')
                    ->icon('heroicon-o-moon'),
                Tables\Columns\TextColumn::make('grace_period')
                    ->icon('heroicon-o-clock')
                    ->label('Grace (mins)'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\ColorColumn::make('color'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListEmployeeShifts::route('/'),
            'create' => Pages\CreateEmployeeShift::route('/create'),
            'edit' => Pages\EditEmployeeShift::route('/{record}/edit'),
        ];
    }
}
