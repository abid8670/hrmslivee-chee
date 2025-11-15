<?php

namespace App\Filament\Resources\EmployeesResource\Pages;

use App\Filament\Resources\EmployeesResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;

class EditEmployees extends EditRecord
{
    protected static string $resource = EmployeesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Print')
                ->icon('heroicon-o-printer')
                ->action(function () {
                    return response()->stream(function () {
                        echo View::make('employees.print', ['employee' => $this->record])->render();
                    }, 'employee-{$this->record->id}.html');
                }),
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeValidate(): void
    {
        $data = $this->form->getState();

        // Only apply this logic if the user is intended to be a web user
        if (!empty($data['is_web_user'])) {
            // Get the original employee record before any changes in the form
            $employeeRecord = $this->getRecord();
            // Check if a user account already exists for this employee's email
            $user = User::where('email', $employeeRecord->email)->first();

            // If no user exists and no password has been entered in the form,
            // we must force the user to enter a password.
            if (!$user && empty($data['password'])) {
                throw ValidationException::withMessages([
                    'data.password' => 'A password is required to create a new web user.',
                ]);
            }
        }
    }

    protected function afterSave(): void
    {
        $employee = $this->getRecord();
        $formData = $this->form->getState();

        if ($employee->is_web_user) {
            $userData = [
                'name' => $employee->first_name . ' ' . $employee->last_name,
            ];

            // Only add the password to the update/create data if a new one was provided in the form.
            if (!empty($formData['password'])) {
                // The password in the form data is already hashed by the form's `dehydrateStateUsing` function.
                $userData['password'] = $formData['password'];
            }

            // Use updateOrCreate to either create a new user or update an existing one.
            User::updateOrCreate(
                ['email' => $employee->email], // The key to find the user
                $userData                      // The data to update or create with
            );
        }
    }
}
