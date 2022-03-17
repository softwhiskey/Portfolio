<?php

function get_stores($limit, $offset) {
    
    global $link;
    
    $sql = "SELECT * FROM stores LIMIT $limit OFFSET $offset";
    
    $result = mysqli_query($link, $sql);
    
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    return $posts;
    
}

function get_posts($limit, $offset) {
    
    global $link;
    
    $sql = "SELECT * FROM posts LIMIT $limit OFFSET $offset";
    
    $result = mysqli_query($link, $sql);
    
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    return $posts;
    
}

function get_stores_by_id($stores_id) {
    global $link;
    
    $sql = "SELECT * FROM stores WHERE id = ".$stores_id;
    
    $result = mysqli_query($link, $sql);
    
    $post = mysqli_fetch_assoc($result);
    
    return $post;
}

function generate_code($length = 8) {
    $string = '';
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ1234567890';
    $num_chars = strlen($chars);
    
    for ($i = 0; $i < $length; $i++) {
        $string .= substr($chars, rand(1, $num_chars) - 1 ,1);
    }
    
    return $string;
}

function get_stores_by_category($post_id) {
    
    global $link;
    
    $post_id = mysqli_real_escape_string($link, $post_id);
    
    $sql = 'SELECT * FROM posts WHERE id = "'.$post_id.'"';
    
    $result = mysqli_query($link, $sql);
    
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    return $posts;
    
}

function get_category_title($post_id)  {
    
    global $link;
    
    $category_id = mysqli_real_escape_string($link, $post_id);
    
    $sql = 'SELECT name FROM stores WHERE post_id = "'.$post_id.'"';
    
    $result = mysqli_query($link, $sql);
    
    $category = mysqli_fetch_assoc($result);
    
    return $category['name'];

}

function get_post() {
    global $link;

    $sql = "SELECT * FROM posts";

    $result = mysqli_query($link, $sql);

    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $posts;
}
