<?php
function isSSL(){
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') return true;
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') return true;
	else return false;
}
$REQUEST_PROTOCOL = isSSL()? 'https://' : 'http://';
// define('ROOTHOST',$REQUEST_PROTOCOL.$_SERVER['HTTP_HOST'].'/');
define('ROOTHOST','http://localhost/chunhatvang/admin/');
define('ROOTHOST_WEB','http://localhost/chunhatvang/');
define('ROOTHOST_ADMIN',$REQUEST_PROTOCOL.$_SERVER['HTTP_HOST'].'/admin/');
define('WEBSITE',$REQUEST_PROTOCOL.$_SERVER['HTTP_HOST'].'/');
define('DOMAIN','ott.ecohub.asia');
define('ROOT_IMAGE','/home/admin/web/ecohub.asia/public_html/');
define('ROOT_MEDIA','/home/admin/web/ecohub.asia/public_html/uploads/media/');
define('BASEVIRTUAL0','/home/admin/web/ecohub.asia/public_html/uploads/');
define('MEDIA_HOST',$_SERVER['DOCUMENT_ROOT'].'/chunhatvang/medias/');
define('IMAGE_HOST',ROOTHOST_WEB.'medias/');
define('IMAGE_CONTENTS_HOST', $_SERVER['DOCUMENT_ROOT'].'/chunhatvang/medias/contents/');
define('AVATAR_DEFAULT',ROOTHOST.'global/img/avatars/male.png');
define('IMAGE_DEFAULT',ROOTHOST.'global/img/no-photo.jpg');

define('PIT_API_KEY','6b73412dd2037b6d2ae3b2881b5073bc');
define('APP_ID','1663061363962371');
define('APP_SECRET','dd0b6d3fb803ca2a51601145a74fd9a8');

define('ROOT_PATH',''); 
define('TEM_PATH',ROOT_PATH.'templates/');
define('COM_PATH',ROOT_PATH.'components/');
define('MOD_PATH',ROOT_PATH.'modules/');
define('INC_PATH',ROOT_PATH.'includes/');
define('LAG_PATH',ROOT_PATH.'languages/');
define('EXT_PATH',ROOT_PATH.'extensions/');
define('EDI_PATH',EXT_PATH.'editor/');
define('DOC_PATH',ROOT_PATH.'documents/');
define('DAT_PATH',ROOT_PATH.'databases/');
define('IMG_PATH',ROOT_PATH.'images/');
define('MED_PATH',ROOT_PATH.'media/');
define('LIB_PATH',ROOT_PATH.'libs/');
define('JSC_PATH',ROOT_PATH.'js/');
define('LOG_PATH',ROOT_PATH.'logs/');

define('ADMIN_LOGIN_TIMEOUT',-1);
define('URL_REWRITE','1');
define('USER_TIMEOUT',3000);
define('MEMBER_TIMEOUT',300);
define('ACTION_TIMEOUT',600);
define('MEMBER_STATUS',1);
define('NAME_2FA','ecohub.asia');
define('KEY_AUTHEN_COOKIE','OTT_260584');

define('SMTP_SERVER','smtp.gmail.com');
define('SMTP_PORT','465');
define('SMTP_USER','hoangtucoc321@gmail.com');
define('SMTP_PASS','nsn2651984');
define('SMTP_MAIL','hoangtucoc321@gmail.com');

define('SITE_NAME','Chu Nhat Vang');
define('SITE_TITLE','Chu Nhat Vang');
define('SITE_DESC','');
define('SITE_KEY','');
define('SITE_IMAGE','');
define('SITE_LOGO','');
define('COM_NAME','Copyright &copy; IGF.COM.VN');
define('COM_CONTACT','');
$_FILE_TYPE=array('docx','excel','pdf');
$_MEDIA_TYPE=array('mp4','mp3');
$_IMAGE_TYPE=array('jpeg','jpg','gif','png');
// 1 	:	Thêm mới bài viết
// 2 	:	Cập nhật bài viết (Sửa bài viết)
// 3 	:	Xóa bài viết
// 4 	:	Phê duyệt
// 5 	:	Xuất bản
// 6 	:	Gỡ bài
// 7 	:	Trả bài cho phóng viên
// 8 	:	Trả bài cho biên tập viên

$_GROUP_USER = array(
	"1" 	=> 'Cộng tác viên',
	"2" 	=> 'Phóng viên',
	"3"		=> 'Biên tập viên',
	"4" 	=> 'Thư ký',
	"5" 	=> 'Phó biên tập',
	"6" 	=> 'Tổng biên tập',
	"7" 	=> 'Admin',
);
define('GROUP_USER', $_GROUP_USER);


$_CONTENT_TYPE = array(
	"3" 	=> 'Tin thường',
	"2" 	=> 'Video',
	"1"		=> 'Audio',
);
define('CONTENT_TYPE', $_CONTENT_TYPE);

$_CONTENT_PERMISSION = array(
	"1" 	=> 'Quyền viết bài',
	"2" 	=> 'Quyền biên tập',
	"3"		=> 'Quyền xuất bản',
	"4"		=> 'Quyền gỡ bài',
);
define('CONTENT_PERMISSION', $_CONTENT_PERMISSION);

$_MENU_VIEW_TYPES = array(
	'link'		=> 'Link',
	'block'		=> 'Nhóm tin',
	'article'	=> 'Bài viết'
);
define('MENU_VIEW_TYPES', $_MENU_VIEW_TYPES);

$_MODULE_TYPES = array(
	'mainmenu'		=> 'Main menu',
	'html'			=> 'HTMl',
	'category'		=> 'Nhóm bài viết',
	'news'			=> 'Bài viết',
	'slide'			=> 'Slideshow',
	'video'			=> 'Tin Video',
	'more'			=> 'Mở rộng'
);
define('MODULE_TYPES', $_MODULE_TYPES);


?>