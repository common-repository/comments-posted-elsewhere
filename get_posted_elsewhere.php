<?php
/*
Plugin Name: Comments Posted Elsewhere
Plugin URI: http://wordpress.org/extend/plugins/comments-posted-elsewhere/
Description: Retrieves a list of comments posted on other sites (with the help of a hidden post and trackbacks). <a href="http://www.neiluchitel.com/index.php?p=179">Tutorial</a>
Version: 1.1
Author: Nick Momrik
Author URI: http://nickmomrik.com/
*/

function mdv_posted_elsewhere($comment_post_no = -1, $no_comments = 5, $comment_lenth = 15, $before = '<li>', $after = '</li>') {
	global $wpdb;
	$request = "SELECT comment_ID, comment_content, comment_author, comment_author_url FROM $wpdb->comments WHERE comment_post_ID='$comment_post_no' ORDER BY comment_ID DESC LIMIT $no_comments";
	$comments = $wpdb->get_results($request);
    $output = '';
    if($comments) {
		foreach ($comments as $comment) {
			$commented_at = stripslashes($comment->comment_author);
			$permalink = stripslashes($comment->comment_author_url);
			$comment_content = $comment->comment_content;
			$split_pos = strpos($comment_content, '</strong>') + 9;
			$post_title = strip_tags(substr($comment_content, 0, $split_pos));
			$words=split(" ",stripslashes(substr($comment_content, $split_pos)));
			$comment_excerpt = join(" ",array_slice($words,0,$comment_lenth));
			$output .= $before . '<a href="' . $permalink . '"><strong>' . $commented_at . '</strong>: ' . $post_title . '</a> - ' . $comment_excerpt . '...' . $after;

		}
	}
	else {
		$output = $before . 'None' . $after;
	}

    echo $output;
}
?>
