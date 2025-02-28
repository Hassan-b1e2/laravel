<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return Message::orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'taskId' => 'required',
            'from' => 'required',
            'to' => 'required',
            'message' => 'required',
            'seen' => 'required|boolean',
        ]);

        Message::create($validatedData);

        return response()->json(['message' => 'Message added successfully'], 201);
    }

    public function show(Request $request)
    {
        $Id = $request->query('id');

        $messages = Message::where('taskId', $Id)->get();

        return response()->json($messages);
    }

    public function update(Request $request, $id)
    {
        $message = Message::find($id);
        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        $validatedData = $request->validate([
            'taskId' => 'required',
            'from' => 'required',
            'to' => 'required',
            'message' => 'required',
            'seen' => 'required|boolean',
        ]);

        $message->update($validatedData);

        return response()->json(['message' => 'message updated successfully']);
    }

    public function destroy($id)
    {
        $message = Message::find($id);
        if (!$message) {
            return response()->json(['message' => 'message not found'], 404);
        }

        $message->delete();

        return response()->json(['message' => 'message deleted successfully']);
    }
}
