<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    public function __invoke(Request $request)
    {
        $success = $request->session()->get('success', false);
        $errors = null;
        if ($request->isMethod('post')) {
            $errors = $this->getErrorMessages($request->input());
            if (count($errors) > 0) {
                $request->flash();
            } else {
                $appeal = new Appeal();
                $appeal->name = $request->input('name');
                $appeal->message = $request->input('message');
                $appeal->email = $request->input('email');
                $appeal->phone = $request->input('phone');

                $appeal->save();
                return redirect()
                    ->route('appeal')
                    ->with('success', true);
            }
        }
        return view('appealForm', ['errors' => $errors, 'success' => $success]);
    }

    private function getErrorMessages(Array $request): array
    {
        $errors = [];
        if ($request['name'] === null) {
            $errors[] = 'Name is empty';
        }
        if ($request['message'] === null) {
            $errors[] = 'Message is empty';
        }
        if ($request['email'] === null && $request['phone'] === null) {
            $errors[] = 'You have specified neither an email nor a phone';
        }
        return $errors;
    }
}
