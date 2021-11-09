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
        if ($request->input('suggested') !== null)
            return redirect()->route('appeal')->with('suggested', true);
        $success = $request->session()->get('success', false);
        return view('appealForm', ['success' => $success]);
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
