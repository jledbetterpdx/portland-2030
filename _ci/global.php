<?php

/* API Keys */
require_once('keys.php');

/* Global definitions */
if (!defined('GLOBAL_SYSPATH')) define('GLOBAL_SYSPATH', ROOT . '/_ci/2.1.4/system');
define('GLOBAL_TIMEZONE', 'America/Los_Angeles');
define('GLOBAL_TEMPLATE', 'default');
define('GLOBAL_TITLE_SEPARATOR', ' // ');

/* Path declarations */
define('SEP', '/');
define('PATH_IMAGE_UPLOADS_ROOT', ROOT . '/_uploads');
define('PATH_IMAGE_UPLOADS_WWW', WWW . '/iu');
define('PATH_IMAGE_UPLOADS_WWW_REDIR', WWW . '/uploads');
define('PATH_IMAGE_TEMP', sys_get_temp_dir());
define('PATH_IMAGE_APP_BLOG', 'blog');
define('PATH_IMAGE_APP_ROTATOR', 'rotator');
define('PATH_IMAGE_APP_SPONSORS', 'sponsors');
define('PATH_IMAGE_SIZE_BANNER', 'banner');
define('PATH_IMAGE_SIZE_ICON', 'icon');
define('PATH_IMAGE_SIZE_ORIGINAL', 'original');
define('PATH_IMAGE_SIZE_THUMB', 'thumb');
define('PATH_IMAGE_SUFFIX_BANNER', ''); // Banner is considered "default", so use blank instead of "b"
define('PATH_IMAGE_SUFFIX_ICON', 'i');
define('PATH_IMAGE_SUFFIX_ORIGINAL', 'o');
define('PATH_IMAGE_SUFFIX_THUMB', 't');

/* Event statuses */
define('EVENT_STATUS_CONFIRMED', 1);
define('EVENT_STATUS_CANCELLED', 0);
define('EVENT_STATUS_TENTATIVE', null);

/* System Member ID */
define('SYSTEM_MEMBER_ID', 0);

/* Member status definitions */
define('MEMBER_STATUS_DELETED', 0);
define('MEMBER_STATUS_ACTIVE', 1);
define('MEMBER_STATUS_PROSPECTIVE', 2);
define('MEMBER_STATUS_PROBATIONARY', 3);
define('MEMBER_STATUS_INACTIVE', 4);

/* Member permissions definitions */
define('GOD_MODE', 0);  // sudo make me a sandwich
define('MEMBER_PERMISSION_ADD_EVENTS', 1);
define('MEMBER_PERMISSION_EDIT_EVENTS', 2);
define('MEMBER_PERMISSION_CANCEL_EVENTS', 3);
define('MEMBER_PERMISSION_ADD_MEMBERS', 4);
define('MEMBER_PERMISSION_EDIT_MEMBERS', 5);
define('MEMBER_PERMISSION_REMOVE_MEMBERS', 6);
define('MEMBER_PERMISSION_RESET_PASSWORDS', 7);
define('MEMBER_PERMISSION_VIEW_INQUIRIES', 8);
define('MEMBER_PERMISSION_RESPOND_INQUIRIES', 9);
define('MEMBER_PERMISSION_CHANGE_MEMBER_ACCESS', 10);
define('MEMBER_PERMISSION_CHANGE_MEMBER_ROLE', 11);
define('MEMBER_PERMISSION_DELETE_EVENTS', 12);
define('MEMBER_PERMISSION_VIEW_LOG', 13);
define('MEMBER_PERMISSION_ADD_ROTATOR_IMAGES', 14);
define('MEMBER_PERMISSION_EDIT_ROTATOR_IMAGES', 15);
define('MEMBER_PERMISSION_ARCHIVE_ROTATOR_IMAGES', 16);
define('MEMBER_PERMISSION_DELETE_ROTATOR_IMAGES', 17);
define('MEMBER_PERMISSION_ADD_SPONSORS', 18);
define('MEMBER_PERMISSION_EDIT_SPONSORS', 19);
define('MEMBER_PERMISSION_PAUSE_SPONSORS', 20);
define('MEMBER_PERMISSION_DELETE_SPONSORS', 21);
define('MEMBER_PERMISSION_WRITE_BLOG_POSTS', 22);
define('MEMBER_PERMISSION_UNPUBLISH_BLOG_POSTS', 23);
define('MEMBER_PERMISSION_DELETE_BLOG_POSTS', 24);
define('MEMBER_PERMISSION_DISEMVOWEL_COMMENTS', 25);
define('MEMBER_PERMISSION_DELETE_COMMENTS', 26);
define('MEMBER_PERMISSION_MARK_COMMENT_SPAM', 27);

/* Member committee definitions */
define('MEMBER_COMMITTEE_WEBSITE', 1);
define('MEMBER_COMMITTEE_AWARDS', 2);
define('MEMBER_COMMITTEE_PAST_ACTIVE', 3);
define('MEMBER_COMMITTEE_VOLUNTEER', 4);
define('MEMBER_COMMITTEE_NEWSLETTER', 5);
define('MEMBER_COMMITTEE_FUNDRAISING', 6);

/* Member position definitions */
define('MEMBER_POSITION_PRESIDENT', 1);
define('MEMBER_POSITION_VICE_PRESIDENT', 2);
define('MEMBER_POSITION_IPP', 3);
define('MEMBER_POSITION_SECRETARY', 4);
define('MEMBER_POSITION_TREASURER', 5);
define('MEMBER_POSITION_DIRECTOR', 6);

/* Log actions */
define('LOG_ACTION_ADD', 1);
define('LOG_ACTION_EDIT', 2);
define('LOG_ACTION_CANCEL', 3);
define('LOG_ACTION_UNCANCEL', 4);
define('LOG_ACTION_REMOVE', 5);
define('LOG_ACTION_DELETE', 6);
define('LOG_ACTION_RESET', 7);
define('LOG_ACTION_RESPOND', 12);
define('LOG_ACTION_ARCHIVE', 13);
define('LOG_ACTION_PAUSE', 14);
define('LOG_ACTION_WRITE', 15);
define('LOG_ACTION_UNPUBLISH', 16);
define('LOG_ACTION_DISEMVOWEL', 17);
define('LOG_ACTION_MARK_SPAM', 18);

/* Log levels */
define('LOG_LEVEL_ALERT', 1);
define('LOG_LEVEL_WARNING', 2);
define('LOG_LEVEL_INFO', 3);
define('LOG_LEVEL_SUCCESS', 4);

/* Log objects */
define('LOG_OBJECT_EVENT', 1);
define('LOG_OBJECT_MEMBER', 2);
define('LOG_OBJECT_INQUIRY', 3);
define('LOG_OBJECT_PASSWORD', 4);
define('LOG_OBJECT_ROTATOR_IMAGE', 5);
define('LOG_OBJECT_SPONSOR', 6);
define('LOG_OBJECT_BLOG_POST', 7);
define('LOG_OBJECT_BLOG_COMMENT', 8);

/* Deprecated constants */
define('LOG_ACTION_ALERT', 8);   // Deprecated
define('LOG_ACTION_INFO', 9);   // Deprecated
define('LOG_ACTION_SUCCESS', 10);   // Deprecated
define('LOG_ACTION_WARNING', 11);   // Deprecated
define('MEMBER_POSITION_DIRECTOR_I', 6);    // Deprecated
define('MEMBER_POSITION_DIRECTOR_II', 6);   // Deprecated
define('MEMBER_POSITION_PRESIDENT_ELECT', 7);   // Deprecated
define('MEMBER_PERMISSION_REMOVE_EVENTS', 3);   // Deprecated
