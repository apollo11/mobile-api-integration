function resetValues(){
    $('.rate-user-content .rate-jobname').html('');
    $('.rate-user-content .rate-jobdate').html('');
    $('.rate-user-content .rate-jobcompany').html('');
    $('.rate-user-content .rate-jobloc').html('');
    $('.rate-user-content .rate-checkin').html('');
    $('.rate-user-content .rate-checkout').html('');
    $('.rate-user-content .rate-totalhours').html('');
    $('.rate-user-content .rating-comment').val('');
    $('#rating_point').val('');
    $('.rating-input i').removeClass('glyphicon-star').addClass('glyphicon-star-empty');

    $('.submit-rating-btn').data('user_id',null);
    $('.submit-rating-btn').data('rate_id',null);
    $('.rating-submit-info').html('').removeClass('alert alert-danger');
    $('.rating-submit-info').removeClass('alert-success');

    $('.submit-rating-btn').addClass('hide');

    $('#rating_point').show();
    $('.rating-input').show();
    $('.rating-stars-temp').remove();
    $('.rating-comment').removeAttr("disabled");
}

function fillindata(detail){
    $('.rate-user-content .rate-jobname').html(detail.job_title);
    $('.rate-user-content .rate-jobdate').html(detail.job_date);
    $('.rate-user-content .rate-jobcompany').html(detail.company_name);
    $('.rate-user-content .rate-jobloc').html(detail.location);
    $('.rate-user-content .rate-checkin').html(detail.checkin_datetime);
    $('.rate-user-content .rate-checkout').html(detail.checkout_datetime);
    $('.rate-user-content .rate-totalhours').html(detail.total_working_hours);
    $('.rating-comment').val(detail.rating_comment);
}

function setStar(rating){
    $('#rating_point').hide();
    $('.rating-input').hide();

    var rating_str = '';
    for(var i = 0; i< 5; i++){
        if(i < rating){
            rating_str += "<i class='glyphicon  glyphicon-star'></i>";
        }else{
            rating_str += "<i class='glyphicon glyphicon-star-empty'></i>";
        }
    }
    $('.star-rating').prepend("<div class='rating-stars-temp'>"+rating_str+"</div>");
}

function rate_getPopUpJobDetail(url,user_id,rate_id){
    $.ajax({
          url: url,
          method: 'GET',
          dataType: 'json',
          success: function(data){
            var detail = data.data;
            if(data.success==true){
                fillindata(detail);

                $('.submit-rating-btn').removeClass('hide');
                $('.submit-rating-btn').data('user_id',user_id);
                $('.submit-rating-btn').data('rate_id',rate_id);

                $('.rating-submit-info').html('').removeClass('alert alert-danger alert-success');
            }else{
                $('.rating-comment').attr("disabled","disabled");
                if(detail.error){
                    $('.rating-submit-info').html('').removeClass('alert-success');
                    $('.rating-submit-info').html(detail.error).addClass('alert alert-danger');
                }
                if(detail.jobdetail !=null){
                    fillindata(detail.jobdetail);
                    setStar(detail.jobdetail.rating_point);
                }
            }
          }
    });
}

function rate_submitJobRating(url){
    $.ajax({
          url: url,
          method: 'POST',
          dataType: 'json',
          data : $('#rating-form').serialize(),
          success: function(data){
            var detail = data.data;
            if(data.success==true){
               $('.rating-submit-info').html('').removeClass('alert alert-danger');
               $('.rating-submit-info').html(detail.msg).addClass('alert alert-success');
                $('.submit-rating-btn').addClass('hide');
                $('.rating-comment').attr("disabled","disabled");

                setTimeout(function(){
                    window.location.reload(true);
                },3000);
            }else{
                $('.rating-submit-info').html('').removeClass('alert-success');
                if(detail.error){
                    $('.rating-submit-info').html(detail.error).addClass('alert alert-danger');
                }
            }
          }
    });
}