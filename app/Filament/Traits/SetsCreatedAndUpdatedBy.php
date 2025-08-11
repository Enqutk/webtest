<?php

namespace App\Filament\Traits;

use Illuminate\Support\Facades\Auth;

trait SetsCreatedAndUpdatedBy
{
  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['created_by'] = Auth::id();
    $data['updated_by'] = Auth::id();
    return $data;
  }
}
