<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Game;
use App\Models\Noti;
use App\Models\User;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Http\Request;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\KeyValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\GameResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GameResource\RelationManagers;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static ?string $navigationGroup = 'Table Management';

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()->where('user_id', auth()->user()->id);
    // }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Select::make('post_status')
                ->options([
                    'Private' => 'Private',
                    'Published' => 'Published',
                    'Reviewing' => 'Reviewing',
                    'Ban' => 'Ban',
                ])
                ->required()
                ->native(false),
            // ->disabled(fn(string $operation) => auth()->user()->user_token === 1 && $operation === 'create')
            // ->default(fn(callable $get) => auth()->user()->user_token === 1 ? 'Reviewing' : null)
            // ->hidden(fn(callable $get) => $get('post_status') === 'Reviewing' && $get('user_id') != 1),
            Forms\Components\Textarea::make('about')->required()->columnSpanFull(),
            Forms\Components\TextInput::make('size')->required()->maxLength(255),
            Select::make('online_or_offline')
                ->options([
                    'online' => 'online',
                    'offline' => 'offline',
                    'online/offline' => 'online/offline',
                ])
                ->required()
                ->native(false),
            Forms\Components\TextInput::make('category')->required()->maxLength(255),
            Forms\Components\TextInput::make('downloads')->required()->hidden(fn(string $operation) => $operation === 'create'),
            KeyValue::make('download_links')->columnSpanFull(),
            KeyValue::make('setting')->columnSpanFull(),
            Forms\Components\FileUpload::make('image')->image()->multiple()->minFiles(1)->maxFiles(5)->directory('games_images')->required(),
            Forms\Components\FileUpload::make('logo')->image()->imageEditor()->directory('game_logos')->required(),
            Forms\Components\TextInput::make('user_id')
                ->readonly()
                ->default(auth()->user()->id)
                ->required()
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable(),
                ImageColumn::make('logo')->label('Logo'),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('size'),
                Tables\Columns\TextColumn::make('user_id')->searchable(),
                Tables\Columns\TextColumn::make('post_status')->badge()->color(
                    fn(string $state): string => match ($state) {
                        'Private' => 'gray',
                        'Reviewing' => 'warning',
                        'Published' => 'success',
                        'Ban' => 'danger',
                    },
                ),
                Tables\Columns\TextColumn::make('downloads')->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('image')->label('Screenshot')->stacked()->limit(3)->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()->before(function (Game $game) {
                    // Create a new category
                    $game = Game::findOrFail($game->id);
                    Noti::create([
                        'title' => 'Game deleted!',
                        'text' => "Your $game->name game has been deleted!",
                        'user_id' => $game->user_id,
                        'game_id' => $game->id,
                    ]);
                    // Delete the game's comments
                    $game->comments()->delete();
                    $game->replies()->delete();

                    // Delete the game's images
                    foreach ($game->image as $image) {
                        $fileExists = Storage::disk('public')->exists(str_replace('/storage/', '', $image));

                        if ($fileExists) {
                            Storage::disk('public')->delete(str_replace('/storage/', '', $image));
                        }
                    }

                    // Delete the game's logo
                    $logoExists = Storage::disk('public')->exists(str_replace('/storage/', '', $game->logo));
                    if ($logoExists) {
                        Storage::disk('public')->delete(str_replace('/storage/', '', $game->logo));
                    }
                }),
                Tables\Actions\EditAction::make()->before(function (Game $game, array $data){
                    Log::info($game);
                    Log::info("okk");

                    return $game;
                }),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'view' => Pages\ViewGame::route('/{record}'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
        ];
    }
}
