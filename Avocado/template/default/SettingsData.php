<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$tblSettingsData = "(1,'IncYear','','',NULL,'',0,'1',10,'Organisation founding year','','General'),
    (2,'Organisation',NULL,'',NULL,'',0,'3',50,'Organisation Name','','General'),
    (3,'Articles','10','',NULL,'',0,'N',5,'Maximum number of articles per page\n- Total Articles dictated by Menu\n','','General'),
    (4,'Security','Admin\r\nSetTypes\r\nEditor\r\nCalendar\r\nRota\r\nMember\r\nAttendee\r\nView','',NULL,'',0,'10',20,'List all security options','','Security'),
    (5,'UserReg','0','',NULL,'',0,'B',0,'Can a user Register for themselves?','','Security'),
    (6,'Description','','',NULL,'',0,'3',50,'Meta Tags Description','','Meta'),
    (7,'Keywords','','',NULL,'',0,'3',50,'Meta Tag keywords','','Meta'),
    (8,'copyright',NULL,'',NULL,NULL,0,'1',50,'Copyright text, overrites default for copyright notice, and meta tag copyright','','Meta'),
    (9,'author','','',NULL,'',0,'1',50,'Meta Tag for Author information','','Meta'),
    (10,'ShortLength','400','',NULL,'',0,'N',50,'Enter the number of characters to display for short articles, choose short in menu to to show short articles.\n','','General'),
    (11,'SSL','1','',NULL,'',0,'B',0,'Can you use SSL','','Security'),(12,'SSLURL','','',NULL,'',0,'1',50,'If your SSL URL is not the https version of the primary URL, enter the SSL URL here., please enclude https:// infront of the URL.','','Security'),
    (13,'ArticleEditor','Editor','',NULL,'',0,'D',20,'Who has permission to edit Artiles.\nOnly enter a single security group','parameter:Security','Security'),
    (14,'ArticleApproval','Editor','',NULL,'',0,'D',20,'Assign who can approve / activate articles','parameter:Security','Security'),
    (16,'ContactEmail','','',NULL,'',0,'1',50,'Enter the email address for the Contact Us form','','General'),
    (17,'Header','<div class=\"logo\">
<a href=\"?\"><img src=\"images/logo_mobile.png\" height=\"50\" hspace=\"0\" vspace=\"0\" border=\"0\" alt=\":Organisation Logo\" title=\":Organisation Logo\" /></a>
</div>

<div class=\"MobileLogo\">
<a href=\"?\"><img src=\"images/logo_mobile.png\" width=\"40\" hspace=\"0\" vspace=\"0\" border=\"0\" alt=\":Organisation Logo\" title=\":Organisation Logo\" /></a>
</div>

<h1>:Organisation</h1>','',NULL,'',0,'10',50,'Please enter any HTML for the header','','General'),
    (18,'Podcast_Title','','',NULL,'',0,'1',50,'Enter the title for the Podcast page','','Podcast'),
    (19,'Podcast_URL','','',NULL,'',0,'1',50,'URL for podcast, build automatically, use this to overrise the automatic URL','','Podcast'),
    (20,'Podcast_Folder','','',NULL,'',0,'1',50,'Enter a value here to overrise the default forlder for postacsts.  The default is Podcasts.','','Podcast'),
    (21,'Podcast_Text','','',NULL,'',0,'5',50,'Enter some informative test to descibe the podcast','','Podcast'),
    (22,'CalendarStyle','Week','',NULL,'',0,'D',10,'Select the default Calendar view','List\nCompactList\nCalendar\nDay\nWeek\nThreeMonth\nrss\nList2','Calendar'),
    (23,'SendNewsSecurity','Admin','',NULL,'',0,'D',20,'Assign who can Send News letters / See the news letter subscription list','parameter:Security','News'),
    (25,'NewsReg','0','',NULL,'',0,'B',0,'Can users sign up for news letter.','','News'),
    (29,'NewsFromEmail','','',NULL,NULL,0,'1',50,'News letter registration from email address.','','News'),(30,'PublicVenues','',' ',NULL,'',0,'10',20,'List all Public Venues for calendar',' ','Calendar'),
    (31,'AllowLogins','1',' ',NULL,'',0,'B',0,'Are Logins allowed from pages other than the direct login page. ',' ','Security'),
    (32,'CalendarEditor','Calendar',' ',NULL,'',0,'D',20,'Security group that can create Calendar Entries','parameter:Security','Calendar'),
    (33,'CalendarRestrictedText','',' ',NULL,'',0,'1',20,'Enter text to appear on venue for restricted calendar items',' ','Calendar'),
    (34,'Style','Square_Menu',' ',NULL,'',0,'D',20,'Select the Style for the site','parameter:AvailableStyles','Style'),
    (35,'AvailableStyles','Blue_Square_Menu\r\nWhite_Square_Menu\r\nWhite_Rounded_Steel_Menu\r\nSquare_Menu\r\n3colum_vertical_Menu\r\nTop_Right_Menu',' ',NULL,'',0,'10',20,'Available Styles, Sperate by Carraadge Return','parameter:AvailableStyles','Style'),
    (36,'Breadcrumbs','0',' ',NULL,'',0,'B',0,'Show Breadcrums',' ','Style'),
    (37,'GoogleSearch','',' ',NULL,'',0,'D',20,'Show Google Search Box','Header\nFooter\nRight\nLeft\n','Style'),
    (38,'MainFont','Georgia, serif',' ',NULL,'',0,'F',30,'Which Font would you like to use','parameter:AvailableFonts','Style'),
    (39,'CalendarPublicPost','0',' ',NULL,'',0,'B',0,'Allow Public posting to calander',' ','Calendar'),
    (40,'CalendarTimeSlots','20',' ',NULL,'',0,'1',3,'Time of a slot in Mins',' ','Calendar'),
    (41,'StartTime','09:00',' ',NULL,'',0,'1',5,'Start time of day',' ','Calendar'),
    (42,'EndTime','17:00',' ',NULL,'',0,'1',5,'End time of day',' ','Calendar'),
    (43,'CalendarEditPageTitle',NULL,' ',NULL,NULL,0,'1',30,'Enter a title for the public posting calendar',' ','Calendar'),
    (44,'CalendarSlotMaxBookings','1',' ',NULL,NULL,0,'N',3,'Enter the maximum number of bookings in a slot',' ','Calendar'),
    (45,'CalendarBookableDays','Sun\nMon\nTue\nWed\nThu\nFri\nSat',' ',NULL,'',0,'10',20,'Select Bookable Days','Sun\nMon\nTue\nWed\nThu\nFri\nSat','Calendar'),
    (46,'homepage','',' ',NULL,'',0,'1',30,'Set the default homepage',' ','General'),
    (47,'GlobalLoginFails', '500', NULL, NULL, NULL, '0', 'N', '10', 'Enter number of failed logins before lockout', ' ', 'Security'),
    (48,'LoginFails', '5', NULL, NULL, NULL, '0', 'N', '3', 'Enter number of failed logins before lockout', ' ', 'Security'),
    (49,'FailedLoginDelay', '5', NULL, NULL, NULL, '0', 'N', '3', 'Enter the delay for failed logins', ' ', 'Security'),
    (54,'CalendarCreateRecordText', 'Event Created', NULL, NULL, NULL, '0', '1', '50', 'Enter the text for successfully creating a calendar entry', ' ', 'Calendar'),
    (55,'CalendarUpdateRecordText', 'Event Updated', NULL, NULL, NULL, '0', '1', '50', 'Enter the text for successfully updating a calendar entry', ' ', 'Calendar'),
    (56,'ShowNonBookableDays', '1', NULL, NULL, NULL, '0', 'B', '0', 'Select if you want to see non-bookable days in calendar', ' ', 'Calendar'),
    (57,'PublicCalendarViews', 'List\nCompactList\nCalendar\nDay\nWeek\nThreeMonth\nrss\nList2', NULL, NULL, NULL, '0', 'M', '50', 'Select any Calendar views you wish to be visible to public visitors', 'List\nCompactList\nCalendar\nDay\nWeek\nThreeMonth\nrss\nList2', 'Calendar'),
    (59,'SystemPages', 'Calendar\nContact\nData\ncalendar/WeekView\ncalendar/ThreeMonthView\ncalendar/CompactListView\nYouTube\npodcast\nnews/subscribe', NULL, NULL, NULL, '0', '5', '50', 'List of System pages that can be selected in page edit.', ' ', 'General'),
    (60, 'DataUsage', '<p>
We store data on this site for the sole provision of the service to you, by registering you agree that we can use this data for this purpose.
the data we hold is:
<ul>
<li>Your Username</li>
<li>Your Password</li>
<li>Your email address</li>
<li>Your Name</li>
<li>Your IP address</li>
</ul>
</p>
<div class=\"small\">
All data is encrypted, and stored on a shared hosting server which is not controlled by us.<br />
For more information see our Privicy Notice
</div>

', NULL, NULL, NULL, '0', '10', '50', 'Enter a Data Usage Details', ' ', 'General'),
(61, 'NewsDefaultSubject', NULL, NULL, NULL, NULL, '0', '1', '30', 'Enter the default subject to use for news letters', NULL, 'News'),
(62, 'NewsDefaultMessage', NULL, NULL, NULL, NULL, '0', '10', '30', 'Enter the default message to use for news letters, use :name to enter the name of the recipient', NULL, 'News'),
(63, 'NewsSubscribeConformationSubject', NULL, NULL, NULL, NULL, '0', '1', '30', NULL, ' ', 'News'),
(64, 'NewsSubscriptionDefaultMessage', 'Dear  :name,

Thank you for choosing to subscribe to our news letter.

Please click the link below to activate your account.', NULL, NULL, NULL, '0', '10', '30', NULL, NULL, 'News'),
(65, 'maxfileuploadsize', '20000000', NULL, NULL, NULL, '0', 'N', '10', 'Enter the maximim size of a file for uploading in Bytes, default is 20000000. Note your server settings myst be sert to allow this size too.', NULL, 'Security'),
(66, 'newsletterfails', '5', NULL, NULL, NULL, '0', 'N', '10', 'Enter the number of failed newsletter sends before deleting the subscribed user, 0 allows for unlimited. This only covers send failures, not bounceback emails.', NULL, 'News'),
(67, 'PasswordResetEmailMessage', 'Thank you for requesting to reset your username and/or password.

Please click the link below to reset your account details

:link', NULL, NULL, NULL, '0', '10', '30', 'Enter the message to email for password resets use :link to include the reset link', NULL, 'User'),
(68, 'PasswordResetEmailSubject', 'Password Reset', NULL, NULL, NULL, '0', '1', '30', 'Enter the subject for the password reset email', NULL, 'User'),
(69, 'UserRegistrationFromAddress', NULL, NULL, NULL, NULL, '0', '1', '30', 'Enter email address which sends the user registration email', NULL, 'User'),
(70, 'ArticleApproverEmailAddress', NULL, NULL, NULL, NULL, '0', '1', '30', 'Enter the email address for Artcile approvers', NULL, 'General'),
(71, 'ExternalSiteDisclaimer', 'We are not responsible for the content of external sites', NULL, NULL, NULL, '0', '1', '50', 'Enter some text as a disclaimer for external sites', NULL, 'General'),
(72, 'Bookshop_Affiliate_Tag', NULL, NULL, NULL, NULL, '0', '1', '30', 'Enter your bookshop Afiliate tag.', NULL, 'Bookshop'),
(73, 'Junk_Check', 'bit.ly\r\nviagra\r\nv1agra\r\nincrease sales\r\nprofitability\r\nGet a quote\r\nget more leads\r\nSEO\r\nincrease sales\r\nLive Demo\r\nFREE TEST\r\nready to buy\r\npayment systems\r\nwebsite upgrades\r\nMagento\r\naffordable prices\r\nHere_s\r\nyou_d\r\ngenerate more leads\r\nPay a ransom\r\n', NULL, NULL, NULL, '0', '10', '30', 'Enter words and phrases as spam check, each line represets a phrase, entering a single word on a line any ocurrance of that word will triger a spam falure,  ', NULL, 'Security'),
(74, 'JunkCheckFailMessage', 'Invalid input', NULL, NULL, NULL, '0', '1', '30', 'Enter message for failed junk input check', NULL, 'Security'),
(75, 'AvailableFonts','Georgia=Georgia, serif\r\nPalatino Linotype=Palatino Linotype, Book Antiqua, Palatino, serif\r\nTimes New Roman=Times New Roman, Times, serif\r\nArial=Arial, Helvetica, sans-serif\r\nArial Black=Arial Black, Gadget, sans-serif\r\nComic Sans MS=Comic Sans MS, cursive, sans-serif\r\nImpact=Impact, Charcoal, sans-serif\r\nLucida Sans Unicode=Lucida Sans Unicode, Lucida Grande, sans-serif\r\nTahoma=Tahoma, Geneva, sans-serif\r\nTrebuchet MS=Trebuchet MS, Helvetica, sans-serif\r\nVerdana=Verdana, Geneva, sans-serif\r\nCourier New=Courier New, Courier, monospace\r\nLucida Console=Lucida Console, Monaco, monospace', NULL, NULL, NULL, '0', '10', '50', 'Available Fonts for use, Please only add web compatable fonts in the format:\r\nFont Name=Font 1, Font 2, Font 3...', NULL, 'Style'),
(76, 'TinyMCEKey', '', NULL, NULL, NULL, '0', '1', '50', 'Enter key for TinyMCE editor, get it from tinyMCE www.tiny.cloud', NULL, 'General'),
(77, 'ArticleHeader', '0', NULL, NULL, NULL, '0', 'B', '0', 'Display Article Header field', NULL, 'General'),
(78, 'developer_mode', '0', NULL, NULL, NULL, '0', 'B', '0', 'Use Developer Mode, improves on screen errors for development purposes. Do not turn on in producton environment', NULL, 'Security'),
(79, 'Podcast_Meta_1', NULL, NULL, NULL, NULL, '0', '1', '50', 'Podcast Meta data 1 field label, leave blank to not use.', NULL, 'Podcast'),
(80, 'Podcast_Meta_2', NULL, NULL, NULL, NULL, '0', '1', '50', 'Podcast Meta data 2 field label, leave blank to not use.', NULL, 'Podcast'),
(81, 'Podcast_Meta_3', NULL, NULL, NULL, NULL, '0', '1', '50', 'Podcast Meta data 3 field label, leave blank to not use.', NULL, 'Podcast'),
(82, 'Podcast_Meta_4', NULL, NULL, NULL, NULL, '0', '1', '50', 'Podcast Meta data 4 field label, leave blank to not use.', NULL, 'Podcast'),
(83, 'PermissionsMessage', 'Sorry you do not have the permission to view this page.', NULL, NULL, NULL, '0', '1', '50', 'Text to use when permissions fail..', NULL, 'Security'),
(84, 'Podcast_Limit', '4', NULL, NULL, NULL, '0', 'N', '4', 'Number of Pocast Episodes to diaply, this limit is not applied when another limit / search is used.', NULL, 'Podcast'),
(85, 'Podcast_Explicit', '0', NULL, NULL, NULL, '0', 'B', '0', 'Is the podcast explicit.', NULL, 'Podcast'),
(86, 'Podcast_category', '', NULL, NULL, NULL, '0', '3', '50', 'podcast category, add multiple categorys to new lines .', NULL, 'Podcast'),
(87, 'Podcast_Language', '', NULL, NULL, NULL, '0', '1', '50', 'Enter the standard ISO lanage code for the podacst language, e.g. zh-hk for Hong Kong, en-gb for English Great Britain, etc. .', NULL, 'Podcast'),
(88, 'version', '1.24.1', NULL, NULL, NULL, '0', 'R', '50', 'NULL', NULL, 'System'),
(89, 'build', '2400331', NULL, NULL, NULL, '0', 'R', '50', 'NULL', NULL, 'System'),
(90, 'MenuBackgroundColour', '#0000cc', NULL, NULL, NULL, '0', 'C', '50', 'Select Menu Background Colour', NULL, 'Style'),
(91, 'MenuBorderColour', '#cccccc', NULL, NULL, NULL, '0', 'C', '50', 'Select Menu Background Colour', NULL, 'Style'),
(92, 'MenuItemBackgroundColour', '#0000cc', NULL, NULL, NULL, '0', 'C', '50', 'Select Menu Item Background Colour', NULL, 'Style'),
(93, 'MenuItemBorderColour', '#cccccc', NULL, NULL, NULL, '0', 'C', '50', 'Select Menu item border Colour', NULL, 'Style'),
(94, 'MenuItemBackgroundColourHover', '#cccccc', NULL, NULL, NULL, '0', 'C', '50', 'Select Menu Background Colour for hovers', NULL, 'Style'),
(95, 'MenuItemTextColourHover', '#cccccc', NULL, NULL, NULL, '0', 'C', '50', 'Select Menu Text Colour for hovers', NULL, 'Style'),
(96, 'MenuItemBackgroundColourSelected', '#00000', NULL, NULL, NULL, '0', 'C', '50', 'Select Menu Background Colour for hovers', NULL, 'Style'),
(97, 'MenuItemTextColourSelected', '#cccccc', NULL, NULL, NULL, '0', 'C', '50', 'Select Menu Text Colour for hovers', NULL, 'Style'),
(98, 'MenuItemTextColour', '#000000', NULL, NULL, NULL, '0', 'C', '50', 'Select Menu Text Colour for hovers', NULL, 'Style'),
(99, 'BackgroundColour', '#F7F9FB', NULL, NULL, NULL, '0', 'C', '50', 'Select Main body Background Colour', NULL, 'Style'),
(100, 'TextColour', '#000000', NULL, NULL, NULL, '0', 'C', '50', 'Select Main Body Text Colour', NULL, 'Style'),
(101, 'H1TextColour', '#000000', NULL, NULL, NULL, '0', 'C', '50', 'Select Main Body Text Colour', NULL, 'Style'),
(102, 'AlertTopBackgroundColour', '#8FC1E3', NULL, NULL, NULL, '0', 'C', '50', 'Select Alert Top Background Colour', NULL, 'Style'),
(103, 'AlertTopTextColour', '#000000', NULL, NULL, NULL, '0', 'C', '50', 'Select Alert Top Background Colour', NULL, 'Style')

";

?>
