<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Symfony\Component\HttpFoundation\Request;
use App\Models\Sector;
use App\Models\UserSectors;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $formatedData = [];
        $currentUserData = [];
        $sectorData = Sector::where('parent_id', '=', NULL)->orderBy('name', 'ASC')->get();

        //Sort and get the indent level of the sectors
        foreach($sectorData as $sector){

            $formatedData[$sector->id] = ['indentLevel' => 0, 'name' => $sector->name];

            $children = $sector->children()->orderBy('name', 'ASC')->get();
            if(count($children)){
                $this->formatChildren($children, $formatedData);
            }
            
        }

        //If a session is active, get the active user's data. 
        if(session('user_id') !== null){
            $userId = session('user_id');
            $userData = User::find($userId);
            if($userData){

                $currentUserData = ['id' => $userId, 'name' => $userData->name, 'sectors' => [], 'agree_to_terms' => $userData->agree_to_terms];

                $sectors = $userData->sectors()->get();
                foreach($sectors as $sector){
                    array_push($currentUserData['sectors'], $sector->id);
                }
            }else{
                session()->forget('user_id');
            }

        }

        return view('user', ['sectorData' => $formatedData, 'currentUserData' => $currentUserData]);
    }

    /**
     * Sort and get the indent level of child sectors
     */
    protected function formatChildren($children, &$data, $level = 1){
        foreach($children as $sector){

            $data[$sector->id] = ['indentLevel' => $level, 'name' => $sector->name];

            $new_children = $sector->children()->orderBy('name', 'ASC')->get();
            if(count($new_children)){
                $this->formatChildren($new_children, $data, $level += 1);
                $level -= 1;
            }
        }
    }

    /**
     * Validate form data and store it in the database
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        User::create(['name' => $data['name'], 'agree_to_terms' => 1]);
        $last_insert_id = User::getLastInsertId();

        foreach($data['sectors'] as $sector_id){
            UserSectors::create(['user_id' => $last_insert_id, 'sector_id' => $sector_id]);
        }

        session(['user_id' => $last_insert_id]);

        return redirect('/')->with('successMessage', 'New user created!');

    }

    /**
     * Update active user's data.
     */
    public function update(UpdateUserRequest $request, $user_id): RedirectResponse
    {
        $data = $request->validated();
        $user = User::find($user_id);

        $user->name = $data['name'];
        
        $currentSectors = UserSectors::where(['user_id' => $user_id])->get();

        foreach($currentSectors as $sector){
            $sector->delete();
        }

        foreach($data['sectors'] as $sector_id){
            UserSectors::create(['user_id' => $user_id, 'sector_id' => $sector_id]);
        }

        $user->save();

        return redirect('/')->with('successMessage', 'User updated!');
    }

    /**
     * Terminate active session
     */
    public function terminate(Request $request): RedirectResponse
    {
        session()->forget('user_id');
        return redirect('/')->with('successMessage', 'Session terminated!');
    }
}
