<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use App\Filament\Resources\UserResource\Widgets\UserOverview;
use App\Filament\Resources\UserResource\Widgets\InactiveUserOverview;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Administration';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Information')
                    ->description('Provide basic information about the user.')
                    ->schema([
                        TextInput::make('name')
                            ->prefixIcon('heroicon-o-user')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->prefixIcon('heroicon-o-envelope')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('password')
                            ->password()
                            ->required()
                            ->prefixIcon('heroicon-o-lock-closed')
                            ->maxLength(255)
                            ->hiddenOn('edit'),
                        TextInput::make('phone_number')
                            ->tel()
                            ->prefixIcon('heroicon-o-phone')
                            ->maxLength(255)
                            ->nullable(),
                    ])->columns(2),
                Section::make('Status')
                    ->schema([
                        Checkbox::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Inactive users will not be able to log in.'),
                    ]),





            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('phone_number'),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('changePassword')
                    ->form([
                        TextInput::make('new_password')
                            ->password()
                            ->label('New Password')
                            ->required()
                            ->autocomplete('new-password')
                            ->maxLength(255)
                            ->confirmed(),
                        TextInput::make('new_password_confirmation')
                            ->password()
                            ->label('Confirm New Password')
                            ->required()
                            ->autocomplete('new-password')
                            ->maxLength(255),
                    ])
                    ->action(function (User $record, array $data): void {
                        $record->update(['password' => \Hash::make($data['new_password'])]);
                    })
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            UserOverview::class,
        ];
    }
}
