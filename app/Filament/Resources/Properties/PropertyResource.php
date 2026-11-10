<?php

namespace App\Filament\Resources\Properties;

use App\Filament\Resources\Properties\Pages\ManageProperties;
use App\Models\Property;
use App\Services\ModuleManager;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationLabel = 'Properties';

    protected static ?string $modelLabel = 'Property';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static string|UnitEnum|null $navigationGroup = 'Portfolio';

    protected static ?int $navigationSort = 0;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('properties');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            TextInput::make('code'),
            TextInput::make('address'),
            TextInput::make('city'),
            TextInput::make('state')->maxLength(2),
            TextInput::make('zip'),
            TextInput::make('unit_count')->numeric()->default(1),
            Select::make('property_type')->options([
                'multifamily' => 'Multifamily',
                'sfr' => 'Single-Family Rental',
                'condo' => 'Condo',
                'mixed' => 'Mixed Use',
            ])->required(),
            Select::make('status')->options([
                'active' => 'Active',
                'lease_up' => 'Lease-Up',
                'disposition' => 'Disposition',
            ])->required(),
            TextInput::make('slug')->disabled(),
            Textarea::make('notes')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('code')->badge(),
                TextColumn::make('city'),
                TextColumn::make('state'),
                TextColumn::make('unit_count')->label('Units'),
                TextColumn::make('property_type')->badge(),
                TextColumn::make('status')->badge(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageProperties::route('/')];
    }
}
