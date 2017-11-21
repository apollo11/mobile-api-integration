 <form id="rating-form" method="post">
      {{ csrf_field() }}
 <div id="rate_user" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="row rate-user-content" style="" data-always-visible="1" data-rail-visible1="1">
                    <div class="row form-group">
                        <div class="col-sm-4 col-sm-offset-4 rate-user-profileimg"></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-12 form-group">
                            <div class="col-md-6">Job Title</div>
                            <div class="col-md-6 rate-jobname"></div>
                        </div>
                        <div class="col-sm-12 form-group">
                            <div class="col-md-6">Job Date</div>
                            <div class="col-md-6 rate-jobdate"></div>
                        </div>

                        <div class="col-sm-12 form-group">
                            <div class="col-md-6">Employer's Name</div>
                            <div class="col-md-6 rate-jobcompany"></div>
                        </div>

                        <div class="col-sm-12 form-group">
                            <div class="col-md-6">Job Location</div>
                            <div class="col-md-6 rate-jobloc"></div>
                        </div>
                        <div class="col-sm-12 form-group">
                            <div class="col-md-6">Check In Date &amp; Time</div>
                            <div class="col-md-6 rate-checkin"></div>
                        </div>
                        <div class="col-sm-12 form-group">
                            <div class="col-md-6">Check Out Date &amp; Time</div>
                            <div class="col-md-6 rate-checkout"></div>
                        </div>
                        <div class="col-sm-12 form-group">
                            <div class="col-md-6">Total Working Hours</div>
                            <div class="col-md-6 rate-totalhours"></div>
                        </div>

                        <div class="col-sm-12 form-group text-center star-rating">
                            <input type="number" name="rating_point" id="rating_point" class="rating" value="" data-max="5" data-min="1" />
                        </div>

                        <div class="col-sm-12 form-group text-center">
                            <div class="col-sm-12">
                                <textarea name="rating_comment" class="rating-comment form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-10 col-sm-offset-1 text-center rating-submit-info"></div>

                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn green submit-rating-btn hide">SUBMIT</button>
                    </div>

                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>