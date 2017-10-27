
<div class="page-content-wrapper\">
    <div class="page-content">
        <div class="page-bar">
            <div class="row">
                <div class="col-md-12 page-404">
                    <div class="number font-green"> 404</div>
                    <div class="details">
                        <h3>Oops! You're lost.</h3>
                        <p> We can not find the page you're looking for.
                            <br/>
                            <a href="{{ url()->previous()  }}"> Return home </a> or try the search bar below. </p>
                        <form action="#">
                            <div class="input-group input-medium">
                                <input type="text" class="form-control" placeholder="keyword...">
                                <span class="input-group-btn">
                                            <button type="submit" class="btn green">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                            </div>
                            <!-- /input-group -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
