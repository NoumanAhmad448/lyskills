@php
use Illuminate\Support\Facades\Cache;
@endphp

<div class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" id="pop-message">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-static-website" >
        <h5 class="modal-title" id="model_title">Message</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <section id="modal-body"></section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary bg-static-website" data-dismiss="modal" id="close-modal"
        onclick="location.reload()">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="update-coupon-form" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-static-website" >
        <h5 class="modal-title" id="model_title">Update Coupon</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <section id="modal-body">
            <form class="coupon_update ml-3" url="">
            <div class="err_msg_update text-danger my-2"> </div>
                <div class="row create_btn_row">
                    <section class="c_con mt-4" >
                    <div class="form-group">
                        <label for="coupon_no"> Coupon Name </label>
                        <input type="text" class="form-control" id="modal_coupon_no" placeholder="Coupon" name="coupon_no">
                        <small class="form-text text-muted">write any specific word of your choice and share it with others
                            to let them access your course at specific cost or totally free.
                        </small>
                    </div>
                    <div class="row my-2">
                        <div class="col">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="modal_is_free" name="is_free">
                                <label for="is_free" class="form-check-label">set free?</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group" id="modal_set_free">
                        <div class="row">
                        <div class="col-3">
                            <label for="date_time">Until Valid Date?</label>
                            <input type="text" class="form-control date-picker" id="modal_date_time" name="date_time" autocomplete="off">
                        </div>
                        <div class="col-3">
                            <label for="no_of_coupons">Allowed Coupons?</label>
                            <input type="number" class="form-control" id="modal_no_of_coupons" name="no_of_coupons">
                        </div>
                        <div class="col-5">
                            <label for="percent"> Set Percentage %</label>
                            <select class='form-control' id='modal_percentage' name='percentage'>
                                <option value="">--select an option -- </option>
                                @for($i=1;$i<=100;$i++)
                                    <option value="{{ $i }}"> {{ $i }} % </option>
                                @endfor
                            </select>
                        </div>
                        </div>
                    </div>
                    <input type="hidden" name="coupon_id" id="coupon_id" value="">
                    <button type="submit" class="btn btn-info"> Update </button>
                </section>
                </div>
            </form>
        </section>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" id="show-video">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-static-website" >
        <h5 class="modal-title" id="model_title">Course Video</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <section id="modal-body">
                <media-player
                src=""
                id="video-source"
                aspect-ratio="16/9"
                >
                <media-outlet>
                <media-seek-button seconds="+30">
                    <media-tooltip position="top center">
                        <span>Seek +30s</span>
                    </media-tooltip>
                </media-seek-button>
                <media-seek-button seconds="-30">
                <media-tooltip position="top center">
                        <span>Seek -30s</span>
                    </media-tooltip>
                </media-seek-button>
                </media-outlet>
                <media-community-skin></media-community-skin>
                </media-player>
        </section>
      </div>
    </div>
  </div>
</div>

<section class="d-flex justify-content-center align-items-center loader loading-section loader">
    <div id="loading" class="spinner-border text-info text-center" style="width: 90px; height: 90px" role="status" >
        <span class="sr-only">Loading...</span>
    </div>
</section>

<div class="modal fade" tabindex="-1" id="submitCourseModal" data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-static-website">
        <h5 class="modal-title "> Course Status </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



