<?php $this->layout('app:layout');
$tree = array();
foreach ($price as $pric) {
    $tree[$pric->id] = $pric;
}
foreach ($tree as $k => $pric) {
    if ($pric->parentId!=0) {
        if ( empty($tree[$pric->parentId]->children) ){
            $tree[$pric->parentId]->children = array();
        }
        $tree[$pric->parentId]->children[] = $k;
    }
}

echo '<ul class="uk-nav uk-nav-parent-icon"  data-uk-nav>';

$tree1 = $tree;
foreach ($tree1 as $pric) {

    if ($pric->parentId==0) {
        echo '<li class="uk-parent">';
        echo '<a href="#" class="category">' . $pric->name . '</a>';
        if ( !empty($pric->children) ){
            echo '<ul class="uk-nav-sub">';
            foreach ($pric->children as $child) {
                if ( !empty($tree1[$child]) ){
                    $children = false;
                    if ( !empty($tree1[$child]->children) ){
                        $children .= '<ul>';
                        foreach ($tree1[$child]->children as $chil) {
                            if ( !empty($tree1[$chil]) ){
                                $children .= '<li>';
                                $children .= '<div class="price" data-id="' . $tree1[$chil]->id . '">';
                                $children .=  '<div class="cat">' . $pric->name . ': ' . $tree1[$child]->name . '</div>';
                                $children .= '<div class="name"><span class="namei">' . $tree1[$chil]->name . '</span>';
                                if ( !empty($tree1[$chil]->price) ){
                                    $children .=  '<div class="cost uk-badge">' . $tree1[$chil]->price . '</div>';
                                    $children .=   '<div class="costtimes">&times;<input type="text" value="1" class="times"> <span class="uk-badge plusminus" data-sign="-1">&minus;</span> <span class="uk-badge plusminus" data-sign="1">+</span></div>';
                                }
                                $children .= '<a class="remove"></a>';
                                $children .= '</div>';
                                if ( !empty($tree1[$chil]->description) ) $children .=  '<div class="description">' . $tree1[$chil]->description . '</div>';
                                $children .= '</div>';
                                $children .= '</li>';
                                unset($tree1[$chil]);
                            }
                        }
                        $children .= '</ul>';
                    }
                    $class = ( empty($children) ) ? 'price' : 'parent';
                    echo '<li>';
                    echo '<div class="' . $class . '" data-id="' . $tree1[$child]->id . '">';
                    echo '<div class="cat">' . $pric->name . '</div>';
                    echo '<div class="name"><span class="namei">' . $tree1[$child]->name . '</span>';
                    if ( !empty($tree1[$child]->price) ){
                        echo '<div class="cost uk-badge">' . $tree1[$child]->price . '</div>';
                        echo '<div class="costtimes">&times;<input type="text" value="1" class="times"> <span class="uk-badge plusminus" data-sign="-1">&minus;</span> <span class="uk-badge plusminus" data-sign="1">+</span></div>';
                    }
                    echo '<a class="remove"></a>';
                    echo '</div>';
                    if ( !empty($tree1[$child]->description) ) echo '<div class="description">' . $tree1[$child]->description . '</div>';
                    echo '</div>';
                    if ( !empty($children) ) echo $children;
                    echo '</li>';
                    unset($tree1[$child]);
                }
            }
            echo '</ul>';
        }
        echo '</li>';
    }

}

echo '</ul>';