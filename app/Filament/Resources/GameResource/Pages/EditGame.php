<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Models\Game;
use App\Models\Noti;
use Filament\Actions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\GameResource;
use Filament\Resources\Pages\EditRecord;
use App\Http\Controllers\Admin\GameController;

class EditGame extends EditRecord
{
    protected static string $resource = GameResource::class;

    protected function getHeaderActions(): array
    {
        $game = $this->record;

        $banAction = Actions\Action::make($game->post_status === 'Ban' ? 'Unban' : 'Ban')->action(function (Game $game) {
            $game->post_status = $game->post_status === 'Ban' ? 'Reviewing' : 'Ban';
            Noti::create([
                'title' => 'Game deleted!',
                'text' => "Your $game->name game has been deleted!",
                'user_id' => $game->user_id,
                'game_id' => $game->id,
            ]);
            $game->save();
        });

        if ($game->post_status === 'Ban') {
            $banAction->color('success');
        } else {
            $banAction->color('danger');
        }

        return [$banAction, Actions\DeleteAction::make()];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $gameController = new GameController;
        $request = new Request($data);
        $gameController->update($request, $record->id);

        return $record;
    }
}
