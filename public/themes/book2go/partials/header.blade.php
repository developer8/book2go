<!-- Section Header -->
<section id="section-header">
    <div class="top-nav">
        <div class="container">
            <div class="row col-md-12">
                <div class="col-md-6 col-left">
                    <a class="mr-3" href="mailto:contact@book2govn.com"><i class="far fa-envelope"></i> contact@book2govn.com</a>
                    <a href="tel:0909090909"><i class="fas fa-mobile-alt"></i> 0909 090 909</a>
                </div>
                <div class="col-md-6 col-right">
                    <a id="modal_trigger" href="#modal-login"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
                </div>
                
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ theme_option('logo') }}" alt="{{ setting('site_title') }}"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
        
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    {!!
                        Menu::generateMenu([
                            'slug' => 'main-menu',
                            'options' => ['class' => 'navbar-nav ml-auto'],
                            'view' => 'main-menu'
                        ])
                    !!}
                    </div>
                </nav>
            </div>
        </div> 
    </div>
</section>
<!-- End / Section Header -->