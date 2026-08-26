<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\PwaSetting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PwaSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-device-phone-mobile';

    protected static ?string $navigationLabel = 'PWA Settings';

    protected static ?string $slug = 'pwa-settings';

    protected static ?string $title = 'PWA Settings';

    protected string $view = 'filament.pages.pwa-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $setting = PwaSetting::query()->first() ?? PwaSetting::query()->create([]);

        $this->data = $setting->toArray();
        $this->form->fill($this->data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('App Identity')
                    ->schema([
                        TextInput::make('app_name')->required(),
                        TextInput::make('short_name')->required(),
                        Textarea::make('description')->rows(3)->required(),
                    ])->columns(2),
                Section::make('Manifest')
                    ->schema([
                        TextInput::make('theme_color')->required(),
                        TextInput::make('background_color')->required(),
                        FileUpload::make('icon_192')
                            ->directory('pwa')
                            ->visibility('public')
                            ->image()
                            ->required(),
                        FileUpload::make('icon_512')
                            ->directory('pwa')
                            ->visibility('public')
                            ->image()
                            ->required(),
                        TextInput::make('start_url')->required(),
                        Select::make('display')
                            ->options([
                                'fullscreen' => 'Fullscreen',
                                'standalone' => 'Standalone',
                                'minimal-ui' => 'Minimal UI',
                                'browser' => 'Browser',
                            ])
                            ->required(),
                        TextInput::make('scope')->required(),
                        TextInput::make('cache_version')->required(),
                        Toggle::make('offline_enabled')->required(),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $setting = PwaSetting::query()->first() ?? new PwaSetting;
        $setting->fill($this->data ?? []);
        $setting->save();

        Notification::make()
            ->title('PWA settings updated')
            ->success()
            ->send();
    }
}
