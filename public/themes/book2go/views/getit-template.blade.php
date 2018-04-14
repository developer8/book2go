@php 
if(!empty($page)) $post = $page; @endphp

<section id="get-it">
    <div class="container-fluid sub-banner">
        <div class="sub-banner-header">
            <h3>Khuyến Mãi</h3>
        </div>
    </div>
    <div class="container breadcrumb-list mt-5">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Khuyến mãi</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <!--form tìm kiếm tour và khách sạn - căn hộ-->
    <div class="container">
            <div class="promo-caption my-4">
                <form action="#" method="post">
                    <select class="form-control text-md-right search-select" name="searchGetIt">
                        <option value="ks-ch">Khách sạn - Căn hộ</option>
                        <option value="tour">Tour</option>
                    </select>
                    <input type = "submit" class="btn btn-warning" value="Tìm kiếm"/>
                </form>
            </div>
        </div>
    <!--end form tìm kiếm tour và khách sạn - căn hộ-->

    <div class="container">
        <div class="promo-caption text-center my-4">
            <h1 class="caption-number">
                <span>01</span>
            </h1>
            <h2 class="caption-title">
                <span>Chương trình khuyến mãi</span>
            </h2>
        </div>
    </div>

    <div class="container">
        <div class="row news-list">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="block-article">
                    <div class="block-image">
                        <img class="img-fluid" src="{{ Theme::asset()->url('main-project/img/new1.jpg') }}" alt="Image">
                        <div class="like">
                            <!-- <i class="fa fa-thumbs-up">&nbsp;</i> -->
                            <div>- 10%</div>
                        </div>
                    </div>
                    <h5 class="block-description">						
                        <a class="mod-articles-category-title " href="./ks-detail.html">
                            Khách sạn A Khuyến Mãi
                        </a>
                    </h5>
                    <div class="date">21-May-2018</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="block-article">
                    <div class="block-image">
                        <img class="img-fluid" src="{{ Theme::asset()->url('main-project/img/new1.jpg') }}" alt="Image">
                        <div class="like">
                            <!-- <i class="fa fa-thumbs-up">&nbsp;</i> -->
                            <div>- 10%</div>
                        </div>
                    </div>
                    <h5 class="block-description">						
                        <a class="mod-articles-category-title " href="#">
                            Căn Hộ B Giảm Giá
                        </a>
                    </h5>
                    <div class="date">21-May-2018</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="block-article">
                    <div class="block-image">
                        <img class="img-fluid" src="{{ Theme::asset()->url('main-project/img/new1.jpg') }}" alt="Image">
                        <div class="like">
                            <!-- <i class="fa fa-thumbs-up">&nbsp;</i> -->
                            <div>- 10%</div>
                        </div>
                    </div>
                    <h5 class="block-description">						
                        <a class="mod-articles-category-title " href="#">
                            Tour Bình Ba Giảm 10%
                        </a>
                    </h5>
                    <div class="date">21-May-2018</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="block-article">
                    <div class="block-image">
                        <img class="img-fluid" src="{{ Theme::asset()->url('main-project/img/new1.jpg') }}" alt="Image">
                        <div class="like">
                            <!-- <i class="fa fa-thumbs-up">&nbsp;</i> -->
                            <div>- 10%</div>
                        </div>
                    </div>
                    <h5 class="block-description">						
                        <a class="mod-articles-category-title " href="#">
                            Airport Hotels The Right Way To Start
                        </a>
                    </h5>
                    <div class="date">21-May-2016</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="block-article">
                    <div class="block-image">
                        <img class="img-fluid" src="{{ Theme::asset()->url('main-project/img/new1.jpg') }}" alt="Image">
                        <div class="like">
                            <!-- <i class="fa fa-thumbs-up">&nbsp;</i> -->
                            <div>- 10%</div>
                        </div>
                    </div>
                    <h5 class="block-description">						
                        <a class="mod-articles-category-title " href="#">
                            Airport Hotels The Right Way To Start
                        </a>
                    </h5>
                    <div class="date">21-May-2016</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="block-article">
                    <div class="block-image">
                        <img class="img-fluid" src="{{ Theme::asset()->url('main-project/img/new1.jpg') }}" alt="Image">
                        <div class="like">
                            <!-- <i class="fa fa-thumbs-up">&nbsp;</i> -->
                            <div>- 10%</div>
                        </div>
                    </div>
                    <h5 class="block-description">						
                        <a class="mod-articles-category-title " href="#">
                            Airport Hotels The Right Way To Start
                        </a>
                    </h5>
                    <div class="date">21-May-2016</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="block-article">
                    <div class="block-image">
                        <img class="img-fluid" src="{{ Theme::asset()->url('main-project/img/new1.jpg') }}" alt="Image">
                        <div class="like">
                            <!-- <i class="fa fa-thumbs-up">&nbsp;</i> -->
                            <div>- 10%</div>
                        </div>
                    </div>
                    <h5 class="block-description">						
                        <a class="mod-articles-category-title " href="#">
                            Airport Hotels The Right Way To Start
                        </a>
                    </h5>
                    <div class="date">21-May-2016</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="block-article">
                    <div class="block-image">
                        <img class="img-fluid" src="{{ Theme::asset()->url('main-project/img/new1.jpg') }}" alt="Image">
                        <div class="like">
                            <!-- <i class="fa fa-thumbs-up">&nbsp;</i> -->
                            <div>- 10%</div>
                        </div>
                    </div>
                    <h5 class="block-description">						
                        <a class="mod-articles-category-title " href="#">
                            Airport Hotels The Right Way To Start
                        </a>
                    </h5>
                    <div class="date">21-May-2016</div>
                </div>
            </div>
        </div>
        <div class="btn-block text-center">
            <a class="btn btn-default btn-outline" href="">Xem thêm</a>
        </div>
    </div>
</section>