<?php

namespace App\Repositories\Board;

use App\Models\Board;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class BoardRepository
 * @package App\Repositories\Board
 */
class BoardRepository extends BaseRepository implements BoardRepositoryInterface
{

    /**
     * @return mixed|string
     */
    public function getModel()
    {
        return Board::class;
    }


    /**
     * @param $isUpdateRequest
     * @return array
     */
    public function validator($isUpdateRequest = false)
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['max:255']
        ];
    }

    public function getUpdateAttributes($request)
    {
        return [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ];
    }

    public function getCreateAttributes($request)
    {
        $data = (object) [
            'backgroundUrl' => ($request->input('backgroundUrl')) ? $request->input('backgroundUrl') : '{}'
        ];

        return [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'data' => jsonEncode($data),
            'creator_id' => Auth::id(),
        ];
    }

    public function onBeforeCreate(){}
    public function onAfterCreate(){}
    public function onBeforeUpdate(){}
    public function onAfterUpdate(){}
}