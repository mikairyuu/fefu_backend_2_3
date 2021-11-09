<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppealPostRequest;
use App\Http\Sanitizers\PhoneSanitizer;
use App\Models\Appeal;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    public function handleGet(Request $request)
    {
        $showSuggestionMessage = false;
        if ($request->input('suggested') !== null) {
            $showSuggestionMessage = !session('popup_message_shown', false);
            if ($showSuggestionMessage) session()->put('popup_message_shown', true);
        }
        $success = $request->session()->get('success', false);
        return view('appealForm', ['success' => $success, 'showSuggestionMessage' => $showSuggestionMessage]);
    }

    public function handlePost(AppealPostRequest $request)
    {
        $appeal = new Appeal();
        $appeal->name = $request->input('name');
        $appeal->surname = $request->input('surname');
        $appeal->patronymic = $request->input('patronymic');
        $appeal->age = $request->input('age');
        $appeal->gender = $request->input('gender');
        $appeal->message = $request->input('message');
        $appeal->email = $request->input('email');
        $appeal->phone = PhoneSanitizer::sanitize($request->input('phone'));

        $appeal->save();
        session()->put('appealed', true);
        return redirect()
            ->route('appeal')
            ->with('success', true);
    }
}
