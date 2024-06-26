<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Noti;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\KeyValue;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Http\Controllers\WebCmNotificationController;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Table Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('logo')->image()->imageEditor()->directory('profile_logos')->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('w2ad_token'),
                Select::make('status')
                ->options([
                    'user' => 'User',
                    'admin' => 'Admin',
                    'adminzynn' => 'ZYNN',
                ])
                ->required()
                ->native(false),
                Select::make('user_token')
                ->options([
                    '1' => 'Need Wait',
                    '2' => 'No Need wait',
                    '3' => 'Ban',
                ])
                ->native(false),
                KeyValue::make('setting')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_token')
                    ->searchable(),
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

                // Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()->before(function (User $user) {
                    foreach ($user->comments as $comment) {
                        $comment->name = 'Deleted user';
                        $comment->save();
                    }

                    foreach ($user->replies as $reply) {
                        $reply->name = 'Deleted user';
                        $reply->save();
                    }

                    foreach ($user->reply_to_name_replies as $reply) {
                        $reply->reply_to = 'Deleted user';
                        $reply->save();
                    }

                    $user->notices()->delete();
                }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('sendNoti')->form([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('text')
                        ->required(),
                    Forms\Components\TextInput::make('link')
                        ->default('https://zynn.games/notices')
                        ->required(),
                    Forms\Components\Toggle::make('also_create_in_database')
                        ->required(),
                ])
                ->action(function (User $user, array $data): void {
                    $webNotificationController = new WebCmNotificationController();

                    // Ensure variables are properly interpolated without quotes
                    $title = $data['title'];
                    $text = $data['text'];
                    $link = $data['link'];

                    if ($data['also_create_in_database']) {
                        Noti::create([
                            'image' => null,
                            'title' => $title,
                            'text' => $text,
                            'user_id' => $user->id,
                            'game_id' => '0',
                            'from_id' => null,
                            'type' => null,
                        ]);
                    }
                    // Send the web notification
                    try {
                        $webNotificationController->sendWebNotification([$user->device_token], $title, $text, $link);

                        Notification::make()
                         ->title('Send successfully')
                         ->success()
                         ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                        ->title('Something went wrong')
                        ->danger()
                        ->send();
                    }
                })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('created_at', 'desc');
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
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
