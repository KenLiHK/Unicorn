<?php

$_targetPage = UNICORN_RECOMMEND;
$_goToPage = UNICORN_RECOMMEND_PAGE;

if (isset($_GET['target_page'])) {
	$_targetPage = $_GET['target_page'];
}

switch ($_targetPage) {
	case UNICORN_INDEX:
		$_goToPage = UNICORN_INDEX_PAGE;
		break;
	case UNICORN_LOGIN:
		$_goToPage = UNICORN_LOGIN_PAGE;
		break;
	case UNICORN_USER_PROFILE:
		$_goToPage = UNICORN_USER_PROFILE_PAGE;
		break;
	case UNICORN_REGISTER:
		$_goToPage = UNICORN_REGISTER_PAGE;
		break;
	case UNICORN_RECOMMEND:
		$_goToPage = UNICORN_RECOMMEND_PAGE;
		break;
	case UNICORN_SEARCH:
		$_goToPage = UNICORN_SEARCH_PAGE;
		break;
	case UNICORN_CART:
		$_goToPage = UNICORN_CART_PAGE;
		break;
	case UNICORN_NOTIFICATION:
		$_goToPage = UNICORN_NOTIFICATION_PAGE;
		break;
	case UNICORN_COMMENT:
		$_goToPage = UNICORN_COMMENT_PAGE;
		break;
	case UNICORN_CONTACT_US:
		$_goToPage = UNICORN_CONTACT_US_PAGE;
		break;
}

include_once($_goToPage);


?>