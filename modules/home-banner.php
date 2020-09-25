<section class="home-banner">
    <div class="container">
        <h1 id="name-logo-brand">Chủ nhật Vàng</h1>
        <div class="row bg-fff">
            <div class="col-md-9">
                <div class="wrap-banner">
                    <?php
                    $res_banners = SysGetList('tbl_slider', [], "AND isactive=1");
                    if(count($res_banners) > 0){
                        ?>
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <?php
                                foreach ($res_banners as $key => $value) {
                                    if($key==0){
                                        echo '<li data-target="#carouselExampleIndicators" data-slide-to="'.$key.'" class="active"></li>';
                                    }else{
                                        echo '<li data-target="#carouselExampleIndicators" data-slide-to="'.$key.'"></li>';
                                    }
                                }
                                ?>
                            </ol>
                            <div class="carousel-inner">
                                <?php
                                foreach ($res_banners as $key => $value) {
                                    if($key==0){
                                        echo '<div class="carousel-item active">
                                        <img class="" src="'.$value['thumb'].'" alt="'.$value['slogan'].'">
                                        </div>';
                                    }else{
                                        echo '<div class="carousel-item">
                                        <img class="" src="'.$value['thumb'].'" alt="'.$value['slogan'].'">
                                        </div>';
                                    }
                                }
                                ?>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="widget-calendar" style="overflow: hidden;">
                    <?php
                    $time = time();
                    $res_events = SysGetList('tbl_events', [], "AND isactive=1 AND stime > ".$time." ORDER BY stime ASC LIMIT 0,10");
                    foreach ($res_events as $key => $value) {
                        $link = ROOTHOST.'su-kien-'.$value['alias'].'-'.$value['id'];
                        echo '<div class="event-item"><span class="date">'.date('d/m, H:i', $value['stime']).'</span><a href="'.$link.'" title="'.$value['title'].'">'.$value['title'].'</a></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>