<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteCollection;
use App\Http\Resources\NoteResource;
use App\Note;
use App\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function show(Travel $travel)
    {
        //
    }

    /**
     * Displays all Notes tied to this Travel
     * @param Travel $travel
     * @return NoteCollection
     */
    public function showNotes(Travel $travel)
    {
        $notes = $travel->notes()->get();

        return new NoteCollection($notes);
    }

    /**
     * Adds a Note to the given Travel
     * @param Request $request
     * @param Travel $travel
     * @return \Illuminate\Http\JsonResponse
     */
    public function addNote(Request $request, Travel $travel)
    {
        $request->validate([
            'content' => 'string|required'
        ]);

        $note = Note::firstOrCreate([
            'user_id' => $request->user()->id,
            'pointer_id' => $travel->id,
            'pointer_type' => Travel::class
        ], [
            'body' => $request->input('content'),
            'user_id' => $request->user()->id,
            'pointer_id' => $travel->id,
            'pointer_type' => Travel::class
        ]);
        $note->body = $request->input('content');
        $note->save();

        $travel->notes()->save($note);

        $vm = [
            'message' => "Successfully added note.",
            'note' => new NoteResource($note)
        ];

        return response()->json($vm);
    }

    /**
     * Updates the currently logged in user's note tied to the given activity
     * @param Request $request
     * @param Travel $travel
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateNote(Request $request, Travel $travel)
    {
        $request->validate([
            'content' => 'string|required'
        ]);

        $user = $request->user();

        $note = Note::where([
            ['user_id', $user->id],
            ['pointer_type', Travel::class],
            ['pointer_id', $travel->id],
        ])->first();
        $note->body = $request->input('content');
        $note->save();

        $vm = [
            'message' => "Successfully updated note.",
            'note' => new NoteResource($note)
        ];

        return response()->json($vm);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function edit(Travel $travel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Travel $travel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Travel $travel)
    {
        //
    }
}
