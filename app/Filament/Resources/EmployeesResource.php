<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeesResource\Pages;
use App\Models\Employees;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\TextInput;
use Illuminate\Validation\Rules\Password;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class EmployeesResource extends Resource
{
    protected static ?string $model = Employees::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Human Resource';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Employee')->tabs([
                    Forms\Components\Tabs\Tab::make('Personal Information')
                        ->icon('heroicon-o-user')
                        ->schema([
                            Forms\Components\Section::make()->schema([
                                Forms\Components\TextInput::make('hr_code')->label('HR Code'),
                                Forms\Components\TextInput::make('machine_id')->label('Machine ID')->required(),
                                Forms\Components\TextInput::make('first_name')->required(),
                                Forms\Components\TextInput::make('middle_name'),
                                Forms\Components\TextInput::make('last_name')->required(),
                                Forms\Components\Select::make('gender')->options([
                                    'male' => 'Male',
                                    'female' => 'Female',
                                    'other' => 'Other',
                                ])->reactive(),
                                Forms\Components\DatePicker::make('date_of_birth'),
                                Forms\Components\Select::make('marital_status')->options([
                                    'single' => 'Single',
                                    'married' => 'Married',
                                    'divorced' => 'Divorced',
                                    'widowed' => 'Widowed',
                                ])->reactive(),
                                Forms\Components\TextInput::make('cnic')->label('CNIC'),
                                Forms\Components\DatePicker::make('cnic_issuance_date')->label('CNIC Issuance Date'),
                                Forms\Components\DatePicker::make('cnic_expiry_date')->label('CNIC Expiry Date'),
                                Forms\Components\TextInput::make('religion'),
                                Forms\Components\Select::make('blood_group')->options([
                                    'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-',
                                    'AB+' => 'AB+', 'AB-' => 'AB-', 'O+' => 'O+', 'O-' => 'O-',
                                ]),
                                Forms\Components\TextInput::make('father_or_husband_name'),
                                Forms\Components\TextInput::make('mother_name'),
                                Forms\Components\TextInput::make('spouse_name')
                                    ->visible(fn (Get $get): bool => $get('marital_status') === 'married'),
                                Forms\Components\TextInput::make('spouse_cnic')->label('Spouse CNIC')
                                    ->visible(fn (Get $get): bool => $get('marital_status') === 'married'),
                                Forms\Components\TextInput::make('child_1'),
                                Forms\Components\TextInput::make('child_2'),
                            ])->columns(3),
                        ]),
                    Forms\Components\Tabs\Tab::make('Official & Contact')
                        ->icon('heroicon-o-briefcase')
                        ->schema([
                            Forms\Components\Section::make('Official Information')->schema([
                                Forms\Components\Select::make('employee_title_id')
                                    ->relationship('employeeTitle', 'name')
                                    ->searchable()
                                    ->preload()
									->label('Title'),
                                Forms\Components\Select::make('employee_type')->options([
                                    'permanent' => 'Permanent',
                                    'contract' => 'Contract',
                                    'intern' => 'Intern',
                                    'probation' => 'Probation',
                                    'terminated' => 'Terminated',
                                    'resigned' => 'Resigned',
                                ])->reactive(),
                                Forms\Components\Select::make('department_id')
                                    ->relationship('department', 'name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('designation_id')
                                    ->relationship('designation', 'name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('manager_id')
                                    ->relationship('manager', 'first_name')
                                    ->searchable()
                                    ->preload()
                                    ->label('Manager'),
                                Forms\Components\DatePicker::make('join_date'),
                                Forms\Components\TextInput::make('grade'),
                                Forms\Components\TextInput::make('over_time_rate'),
                                Forms\Components\Select::make('employee_shift_id')
									->relationship('employeeShift', 'name')
									->searchable()
									->preload(),
                                Forms\Components\TextInput::make('role'),
                                Forms\Components\TextInput::make('work_site_type'),
                                Forms\Components\Select::make('work_location_id')
                                    ->relationship('workLocation', 'name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\DatePicker::make('probation_end_date')
                                    ->label('Probation End Date')
                                    ->visible(fn (Get $get): bool => $get('employee_type') === 'probation'),
                            ])->columns(3),
                            Forms\Components\Section::make('Contact Information')->schema([
                                Forms\Components\TextInput::make('country'),
                                Forms\Components\TextInput::make('city'),
                                Forms\Components\Textarea::make('address')->columnSpanFull(),
                                Forms\Components\Textarea::make('permanent_address')->columnSpanFull(),
                                Forms\Components\TextInput::make('phone_number')->tel(),
                                Forms\Components\TextInput::make('emergency_person_name'),
                                Forms\Components\TextInput::make('emergency_person_number'),
                                Forms\Components\TextInput::make('emergency_relation'),
                            ])->columns(2),
                        ]),
                    Forms\Components\Tabs\Tab::make('Access & Schedule')
                        ->icon('heroicon-o-lock-closed')
                        ->schema([
                            Forms\Components\Section::make('User Access')->schema([
                                Forms\Components\Toggle::make('is_mobile_user')->reactive(),
                                Forms\Components\Toggle::make('is_web_user')->reactive(),
                                Forms\Components\Toggle::make('is_distributor_compulsory_for_attendance')->label('Distributor Compulsory for Attendance'),
                                Forms\Components\Toggle::make('is_mobile_device_register')->label('Mobile Device Registered'),
                                Forms\Components\TextInput::make('email')->email()->unique(ignoreRecord: true)
                                    ->required(fn (Get $get): bool => $get('is_web_user') || $get('is_mobile_user'))
                                    ->visible(fn (Get $get): bool => $get('is_web_user') || $get('is_mobile_user')),
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                    ->dehydrated(fn (?string $state): bool => filled($state))
                                    ->required(fn (string $operation, Get $get): bool => $operation === 'create' && ($get('is_web_user') || $get('is_mobile_user')))
                                    ->rule(Password::default())
                                    ->label('Password')
                                    ->visible(fn (Get $get): bool => $get('is_web_user') || $get('is_mobile_user')),
                                Forms\Components\TextInput::make('password_confirmation')
                                    ->password()
                                    ->dehydrated(false)
                                    ->required(fn (string $operation, Get $get): bool => $operation === 'create' && ($get('is_web_user') || $get('is_mobile_user')))
                                    ->same('password')
                                    ->label('Confirm Password')
                                    ->visible(fn (Get $get): bool => $get('is_web_user') || $get('is_mobile_user')),
                            ])->columns(2),
                            Forms\Components\Section::make('Working Days')->schema([
                                Forms\Components\Toggle::make('works_monday'), Forms\Components\Toggle::make('works_tuesday'),
                                Forms\Components\Toggle::make('works_wednesday'), Forms\Components\Toggle::make('works_thursday'),
                                Forms\Components\Toggle::make('works_friday'), Forms\Components\Toggle::make('works_saturday'),
                                Forms\Components\Toggle::make('works_sunday'),
                            ])->columns(7),
                        ]),
                    Forms\Components\Tabs\Tab::make('Salary & Benefits')
                        ->icon('heroicon-o-currency-dollar')
                        ->schema([
                            Forms\Components\Section::make('Salary & Tax')
                                ->schema([
                                    Forms\Components\TextInput::make('basic_salary')
                                        ->numeric()
                                        ->prefix('PKR'),
                                    Forms\Components\TextInput::make('tax')
                                        ->numeric()
                                        ->prefix('PKR'),
                                ])->columns(2),
                            Forms\Components\Section::make('Allowances & Deductions')
                                ->schema([
                                    Forms\Components\Repeater::make('allowances')
                                        ->relationship()
                                        ->schema([
                                            Forms\Components\TextInput::make('name')->required(),
                                            Forms\Components\TextInput::make('amount')->numeric()->required(),
                                            Forms\Components\DatePicker::make('date')->required(),
                                        ])
                                        ->columns(3),
                                    Forms\Components\Repeater::make('deductions')
                                        ->relationship()
                                        ->schema([
                                            Forms\Components\TextInput::make('name')->required(),
                                            Forms\Components\TextInput::make('amount')->numeric()->required(),
                                            Forms\Components\DatePicker::make('date')->required(),
                                        ])
                                        ->columns(3),
                                ])->columns(2),
                        ]),
                    Forms\Components\Tabs\Tab::make('Financials & Documents')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            Forms\Components\Section::make('Bank Information')->schema([
                                Forms\Components\TextInput::make('bank_name'),
                                Forms\Components\TextInput::make('account_holder_name'),
                                Forms\Components\TextInput::make('bank_account_iban')->label('IBAN'),
                                Forms\Components\TextInput::make('bank_account_no')->label('Account No.'),
                            ])->columns(2),
                            Forms\Components\Section::make('Documents')->schema([
                                Forms\Components\FileUpload::make('hiring_documents'),
                                Forms\Components\FileUpload::make('joining_report'),
                                Forms\Components\FileUpload::make('police_verification_clearance_certificate')->label('Police Clearance'),
                                Forms\Components\FileUpload::make('cnic_copy')->label('CNIC Copy'),
                                Forms\Components\FileUpload::make('educational_certificates'),
                                Forms\Components\FileUpload::make('resignation_current_employer')->label('Resignation (Current Employer)'),
                                Forms\Components\FileUpload::make('experience_certificates'),
                            ])->columns(3),
                        ]),
                    Forms\Components\Tabs\Tab::make('Other')
                        ->icon('heroicon-o-cog')
                        ->schema([
                            Forms\Components\Section::make('Other Information')->schema([
                                Forms\Components\TextInput::make('leave_group'),
                                Forms\Components\Textarea::make('education')->columnSpanFull(),
                                Forms\Components\DatePicker::make('date_of_confirmation'),
                                Forms\Components\Toggle::make('is_resigned'),
                                Forms\Components\TextInput::make('last_company'),
                                Forms\Components\Textarea::make('relevant_experience')->columnSpanFull(),
                                Forms\Components\Textarea::make('total_work_experience')->columnSpanFull(),
                                Forms\Components\TextInput::make('reference'),
                                Forms\Components\Textarea::make('remarks')->columnSpanFull(),
                            ])->columns(2),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hr_code')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('machine_id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('first_name')->searchable(),
                Tables\Columns\TextColumn::make('last_name')->searchable(),
                Tables\Columns\TextColumn::make('manager.first_name')->label('Manager')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('phone_number')->searchable(),
                Tables\Columns\TextColumn::make('department.name'),
				Tables\Columns\TextColumn::make('employeeTitle.name'),
                Tables\Columns\TextColumn::make('designation.name')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('is_web_user')->boolean(),
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
                SelectFilter::make('department')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('designation')
                    ->relationship('designation', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('employee_type')
                    ->options([
                        'permanent' => 'Permanent',
                        'contract' => 'Contract',
                        'intern' => 'Intern',
                        'probation' => 'Probation',
                        'terminated' => 'Terminated',
                        'resigned' => 'Resigned',
                    ]),
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

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployees::route('/create'),
            'edit' => Pages\EditEmployees::route('/{record}/edit'),
        ];
    }
}
