@php
$body = $prop["body"] ?? "";
$footer = $prop["footer"] ?? "";
$modal_id = $prop["id"] ?? "default-modal";
debug_logs($prop);
@endphp
  <!-- Main modal -->
  <div id="{{$modal_id}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden
        left-500 absolute justify-center items-center top-50 z-50 w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative justify-center items-center p-4 w-full max-w-2xl max-h-full">
          <!-- Modal content -->
          <div class="relative rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class=" bg-blue-500 text-white flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-white-900 dark:text-white">
                      {{__("messages.opeation")}}
                  </h3>
                  @include(config("files.svg")."close", ["modal_id" => $modal_id])
              </div>
              <!-- Modal body -->
              <div class="bg-gray-50 p-4 md:p-5 space-y-4" id="modal_body">
                @if($body)
                    @include($body)
                @endif
              </div>
              <!-- Modal footer -->
              <div id="modal_footer" class="@if(empty($footer)) hidden @endif flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">

              </div>
          </div>
      </div>
  </div>