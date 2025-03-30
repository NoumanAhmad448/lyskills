<?php

namespace App\Http\Response;

use App\Classes\ResponseKeys;
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
                    ResponseKeys::TITLE => $title,
                    ResponseKeys::FAQS => $faqs,
                ])
                :  view('faq', compact(ResponseKeys::TITLE, ResponseKeys::FAQS));
        } catch (Exception $e) {
            return server_logs([true, $e], [false], true);
        }
    }
}
