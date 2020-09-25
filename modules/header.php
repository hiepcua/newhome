<header class="header"> 
    <div class="container">
        <nav class="navbar navbar-expand-md">
            <!-- Brand -->
            <a class="navbar-brand" href="<?php echo ROOTHOST;?>"><img src="<?php echo ROOTHOST;?>images/logo1.png" class="logo-brand"></a>

            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="main-menu">
                <ul class="navbar-nav">
                    <?php
                    $str_mnuitem = '';
                    $res_mnuitems = SysGetList('tbl_mnuitems', [], "AND par_id=0 AND isactive=1");
                    foreach ($res_mnuitems as $key => $value) {
                        switch ($value['viewtype']) {
                            case 'link':
                                $link = $value['link'];
                                break;
                            case 'block':
                                $res_cates = SysGetList('tbl_categories', [], "AND id=".$value['cate_id']." AND isactive=1");
                                $link = ROOTHOST.$res_cates[0]['alias'];
                                break;
                            case 'article':
                                $res_cons = SysGetList('tbl_content', [], "AND id=".$value['con_id']."AND isactive=1");
                                $link = ROOTHOST.$res_cons[0]['code'].'.html';
                                break;
                            default:
                                $link ='#';
                                break;
                        }
                        $res_childs = SysGetList('tbl_mnuitems', [], " AND `path` LIKE '".$value['path']."_%' AND isactive=1");
                        $str_mnuitem.='<li class="nav-item">';

                        if(count($res_childs)>0){
                            $str_mnuitem.='<a class="nav-link dropdown-toggle" href="'.$link.'">'.$value['name'].'</a>';
                            $str_mnuitem.='<div class="dropdown-menu">';

                            foreach ($res_childs as $key2 => $value2) {
                                switch ($value['viewtype']) {
                                    case 'link':
                                        $link2 = $value2['viewtype'];
                                        break;
                                    case 'block':
                                        $res_cates2 = SysGetList('tbl_categories', [], "AND id=".$value2['cate_id']." AND isactive=1");
                                        $link2 = ROOTHOST.$res_cates2[0]['alias'];
                                        break;
                                    case 'article':
                                        $res_cons2 = SysGetList('tbl_content', [], "AND id=".$value2['con_id']."AND isactive=1");
                                        $link = ROOTHOST.$res_cons2[0]['code'].'.html';
                                        break;
                                    default:
                                        $link2 ='#';
                                        break;
                                }
                                $str_mnuitem.='<a class="dropdown-item" href="'.$link2.'">'.$value2['name'].'</a>';
                            }

                            $str_mnuitem.='</div>';
                        }else{
                            $str_mnuitem.='<a class="nav-link" href="'.$link.'">'.$value['name'].'</a>';
                        }

                        $str_mnuitem.='</li>';
                    }
                    echo $str_mnuitem;
                    ?>
                    
                </ul>
            </div>

            <form id="frm-search-home" method="get" class="form-inline" action="<?php echo ROOTHOST;?>/tim-kiem">
                <input id="ip-search-home" name="q" class="form-control" type="text" placeholder="Tìm kiếm chương trình, lịch...">
                <i class="fa fa-search bi-desk-search" aria-hidden="true"></i>
                <button type="button" class="btn-mobile-site-search">
                    <i class="fa fa-search bi-search bi-mb-search" aria-hidden="true"></i>
                </button>
            </form>
        </nav>
    </div>
</header>