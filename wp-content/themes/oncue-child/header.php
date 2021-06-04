<?php
/**
 * Header of oncue theme
 * @package oncue
 * @subpackage oncue
 * @since oncue 1.0
 * */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-2021.css">
	<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-2020.css">
	<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-2019.css">
	
	
    <link rel="profile" href="https://gmpg.org/xfn/11">

	<!-- Minh added Header -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<!-- End of added -->
	
    <?php wp_head();?>
</head>

<body <?php body_class();?>>
<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
?>
<?php
/**
 * Hook - oncue_action_header
 *
 * @hooked oncue_header - 10
 */
	do_action( 'oncue_action_header' );
?>