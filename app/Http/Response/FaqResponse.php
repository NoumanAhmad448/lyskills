<?php

namespace App\Http\Response;

use App\Http\Contracts\FaqContract;
use Exception;
use App\Models\Faq;


class FaqResponse implements FaqContract

{
    public function toResponse($request)
    {
        try {
            $title = __("messages.faqs", ["site" => ucfirst(config("app.name"))]);
            $faqs = Faq::where('status', 'published')->orderByDesc('created_at')->simplePaginate(15);
            return $request->wantsJson()
                ? response()->json([
                    "title" => $title,
                    "faqs" => $faqs,
                ])
                :  view('faq', compact('title', 'faqs'));
        } catch (Exception $th) {
            debug_logs($th->getMessage());
            return back()->with("error", __("messages.universal_err_msg"));
        }
    }
}
