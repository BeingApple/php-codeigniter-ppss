<nav>
    <div class="wrap">
        <ul class="menu">
            <li class="menu-item <?php echo ($template_name == "main")?"current-menu":""; ?>"><a href="/"><span>HOME</span></a></li>
            <?php
                if(count($categoryList) > 0){
                    $categoryLevel = 1;
                    $class = "menu-item";
                    $openTag = FALSE;

                    foreach($categoryList as $index => $data){
                        if($data->CATEGORY_LEVEL != $categoryLevel){
                            if($openTag){
                                echo "</ul></li>";
                                $openTag = FALSE;
    
                                $class = "menu-item";
                            }

                            if($data->CATEGORY_LEVEL > 1){
                                echo "<ul>";

                                $class = "sub-menu-item";
                                $openTag = TRUE;
                            }
                        } 
            ?>
                        <li class="<?php echo $class; ?> <?php echo (isset($category) && $category == $data->CATEGORY_NAME)?"current-menu":""; ?>">
                            <a href="/archives/category/<?php echo $data->CATEGORY_SLUG; ?>"><span><?php echo $data->CATEGORY_NAME; ?></span></a>
                        
            <?php
                        if($openTag){
                            echo "</li>";
                        }

                        $categoryLevel = $data->CATEGORY_LEVEL;
                    }
                    if($openTag){
                        echo "</ul></li>";
                    }else{
                        echo "</li>";
                    }
                }
            ?>
            <li class="menu-item <?php echo ($template_name == "author" && (isset($header) && $header == "전체글"))?"current-menu":""; ?>"><a href="/archives"><span>전체글</span></a></li>
            <li class="menu-item search-box">
                <form method="get" action="#">
                    <div class="input-box">
                        <input type="text" name="search" id="search" placeholder="검색 시 상세 검색으로 이동합니다." />
                    </div>
                    <div class="btn-box">
                        <button type="submit" id="searchBtn">
                            <img src="/images/ico_search.png" width="13" height="13" alt="검색 버튼"/>
                        </button>
                    </div>
                </form>
            </li>
        </ul>
        <ul class="mobile-menu">
            <li class="menu-btn"><a href="#"><span>MENU</span></a>
                <ul>
                    <li class="mobile-menu-item <?php echo ($template_name == "main")?"current-menu":""; ?>"><a href="/"><span>Home</span></a></li>
                    <?php
                        if(count($categoryList) > 0){
                            $categoryLevel = 1;

                            $openTag = FALSE;

                            foreach($categoryList as $index => $data){
                                if($data->CATEGORY_LEVEL != $categoryLevel){
                                    if($openTag){
                                        echo "</ul></li>";
                                        $openTag = FALSE;
                                    }

                                    if($data->CATEGORY_LEVEL > 1){
                    ?>
                                    <a href="#" class="sub-menu-btn"><span>▼</span></a>
                    <?php
                                        echo "<ul>";
                                        $openTag = TRUE;
                                    }
                                } 
                    ?>
                                <li class="mobile-menu-item <?php echo (isset($category) && $category == $data->CATEGORY_NAME)?"current-menu":""; ?>">
                                    <a href="/archives/category/<?php echo $data->CATEGORY_SLUG; ?>"><span><?php echo $data->CATEGORY_NAME; ?></span></a>
                                
                    <?php
                                if($openTag){
                                    echo "</li>";
                                }

                                $categoryLevel = $data->CATEGORY_LEVEL;
                            }
                            if($openTag){
                                echo "</ul></li>";
                            }else{
                                echo "</li>";
                            }
                        }
                    ?>
                    <li class="mobile-menu-item <?php echo ($template_name == "author" && (isset($header) && $header == "전체글"))?"current-menu":""; ?>"><a href="/archives"><span>전체글</span></a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="search-box mobile-search-box">
        <form method="get" action="#">
            <div class="input-box">
                <input type="text" name="search" id="search" placeholder="검색 시 상세 검색으로 이동합니다." />
            </div>
            <div class="btn-box">
                <button type="submit" id="searchBtn">
                    <img src="/images/ico_search.png" width="13" height="13" alt="검색 버튼"/>
                </button>
            </div>
        </form>
    </div>
</nav>