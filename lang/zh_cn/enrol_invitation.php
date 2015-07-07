<?php
// This file is part of the UCLA Site Invitation Plugin for Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for component 'enrol_invitation'
 *
 * @package    enrol_invitation
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Global strings.
$string['pluginname'] = '邀请选课';
$string['pluginname_desc'] = '邀请模块允许发送电子邮件邀请。这些邀请只能用一次。用户点击电子邮件中的链接自动选课。';

// Email message strings.
$string['reminder'] = '提醒：';

$string['emailmsgtxt'] =
    '您好：' . "\n" .
    '------------------------------------------------------------' . "\n" .
    '您已经被邀请访问：“{$a->fullname}”。' . "\n" .
    '您将需要登录确认访问网站。' . "\n" .
    '如果您没有帐号，您将需要创建一个帐号。' . "\n\n" .
    '注意，点击此邮件提供的链接您需要确认：' . "\n" .
    '  --您是此邮件所涉及和针对的人' . "\n" .
    '  --下面的链接到({$a->expiration})过期。' . "\n\n" .
    '访问链接：' . "\n" .
    '------------------------------------------------------------' . "\n" .
    '{$a->inviteurl}' . "\n\n" .
    '如果您认为您误接受了此邮件并且需要帮助，请联系{$a->supportemail}.';

$string['instructormsg'] =
    '来自教员的消息：' . "\n" .
    '------------------------------------------------------------' . "\n" .
    '{$a}' . "\n\n";

// Invite form strings.
$string['assignrole'] = '指定脚色';
$string['defaultrole'] = '默认脚色指定';
$string['defaultrole_desc'] = '选择邀请选课时所指定给用户的脚色';
$string['default_subject'] = '邀请您参加“{$a}”';
$string['editenrollment'] = '编辑选课';
$string['header_email'] = '您要邀请谁？';
$string['emailaddressnumber'] = '电子邮箱';

$string['notifymsg'] = '您好，我要通知您用户$a->username（电子邮箱$a->email）已经成功得到访问您的课程$a->course的权限';


$string['emailtitleuserenrolled'] = '{$a->userfullname}已经接受邀请参加{$a->coursefullname}.';
$string['emailmessageuserenrolled'] = '您好：

    {$a->userfullname} ({$a->useremail})已经接受您的邀请作为"{$a->rolename}"{$a->coursefullname}。您可以通过察看以下来验证邀请的状态：

        * 参加者名单：{$a->courseenrolledusersurl}
        * 邀请历史：{$a->invitehistoryurl}

    {$a->sitename}
    -------------
    {$a->supportemail}';

$string['enrolenddate'] = '访问结束日期';
$string['enrolenddate_help'] = '如果启用，其将是被邀请用户不再能够访问该网站的日期。';
$string['enrolenddaterror'] = '访问结束日期不能早于当天';
$string['enrolperiod'] = '报名时间';
$string['enrolperiod_desc'] = '默认有效报名时间（以秒为单位）。如果设置为零，默认注册时间将是无限的。';
$string['enrolperiod_help'] = '从用户报名时刻的有效报名时间。如果禁用，报名时间将是无限的。';
$string['enrolstartdate'] = '开始日期';
$string['enrolstartdate_help'] = '如果启用，用户只可以从该日起报名。';
$string['editenrolment'] = '编辑报名';
$string['inviteexpiration'] = '邀请过期';
$string['inviteexpiration_desc'] = '有效邀请时间（以秒为单位）。默认为2周。';

$string['show_from_email'] = '允许被邀用户通过{$a->email}联系我（您的电子邮箱地址将显示在“FROM”字段上。如果没选择，“FROM”字段上将显示{$a->supportemail}）';
$string['inviteusers'] = '邀请用户';
$string['maxinviteerror'] = '必须是数字。';
$string['maxinviteperday'] = '每天最多邀请数';
$string['maxinviteperday_help'] = '即每天可为课程发送最多邀请数。';
$string['message'] = '消息';

$string['message_help_link'] = '向被邀用户发送的说明';
$string['message_help'] =
    '说明:' . "\n" .
    '------------------------------------------------------------' . "\n" .
    '您已经被邀请访问：【课程或测试名】。' . "\n" .
    '您将需要登录确认访问网站。' . "\n" .
    '如果您没有帐号，您将需要创建一个帐号。' . "\n\n" .
    '注意，点击此邮件提供的链接您需要确认：<br />' .
    '  --您是此邮件所涉及和针对的人；<br />' .
    '  --下面的链接到（【截止日期】）过期。<br /><br />'  .
    '访问链接：' . 
   '<hr />'.
    '【邀请网址】<br />' . 
    '<hr />'.
    '如果您认为您误接受了此邮件并且需要帮助，请联系【帮助电子邮箱】.';

$string['noinvitationinstanceset'] = '没有找到邀请报名实例。请先添加加邀请报名实例到课程。';
$string['nopermissiontosendinvitation'] = '没有权限发送邀请';
$string['norole'] = '请选择一个脚色';
$string['notify_inviter'] = '当被邀用户接受邀请时通知我';
$string['header_role'] = '您要给被邀用户指定什么脚色？';
$string['email_clarification'] = '您可以指定多个电子邮箱，电子邮箱可以用分号 逗号空格或换行分隔。';
$string['subject'] = '标题';
$string['status'] = '允许邀请';
$string['status_desc'] = '默认允许用户邀请报名课程。';
$string['unenrol'] = 'Unenroll user';
$string['unenroluser'] = '您确实要从课程"{$a->course}"取消"{$a->user}"的注册？';
$string['unenrolselfconfirm'] = '您确实要从课程"{$a}"取消您自己的注册?';

// After invite sent strings.
$string['invitationsuccess'] = '邀请已成功发出';
$string['revoke_invite_sucess'] = '邀请已成功撤销';
$string['extend_invite_sucess'] = '邀请已成功延长';
$string['resend_invite_sucess'] = '邀请已成功重发';
$string['returntocourse'] = '返回课程';
$string['returntoinvite'] = '发另一个邀请';

// Processing invitation acceptance strings.
$string['invitation_acceptance_title'] = '邀请接受';
$string['expiredtoken'] = '邀请令牌过期或已用过。';
$string['loggedinnot'] = '<p>这个作为"{$a->rolename}"访问"{$a->coursefullname}"的邀请是发给{$a->email}的。
    如果您不是涉及的收件人，请不要接受此邀请。</p>
    <p>
        在您接受此邀请之前，请登录。
    </p>';
$string['invitationacceptance'] = '<p>这个作为"{$a->rolename}"访问"{$a->coursefullname}"的邀请
     是发给{$a->email}的。
     如果您不是涉及的收件人，请不要接受此邀请。</p>';
$string['invitationacceptancebutton'] = '接受邀请';

// Invite history strings.
$string['invitehistory'] = '邀请历史';
$string['noinvitehistory'] = '尚未发出邀请';
$string['historyinvitee'] = '被邀请者';
$string['historyrole'] = '脚色';
$string['historystatus'] = '状态';
$string['historydatesent'] = '发送日期';
$string['historydateexpiration'] = '截止日期';
$string['historyactions'] = '操作';
$string['historyundefinedrole'] = '无法找到脚色，请U重发邀请并选择其它脚色。';
$string['historyexpires_in'] = '截止到';
$string['used_by'] = ' 由 {$a->username} ({$a->roles}, {$a->useremail}) 在 {$a->timeused}';

// Invite status strings.
$string['status_invite_invalid'] = '无效';
$string['status_invite_expired'] = '过期';
$string['status_invite_used'] = '已接受';
$string['status_invite_used_noaccess'] = '（不再可访问）';
$string['status_invite_used_expiration'] = '（访问截止于{$a}）';
$string['status_invite_revoked'] = '已被撤销';
$string['status_invite_resent'] = '已重发';
$string['status_invite_active'] = '活跃';

// Invite action strings.
$string['action_revoke_invite'] = '撤销邀请';
$string['action_extend_invite'] = '延长邀请';
$string['action_resend_invite'] = '重发邀请';

// Capabilities strings.
$string['invitation:config'] = '配置邀请实例';
$string['invitation:enrol'] = '邀请用户';
$string['invitation:manage'] = '管理邀请任务';
$string['invitation:unenrol'] = '从课程取消用户';
$string['invitation:unenrolself'] = '从课程取消自己';

// Strings for datetimehelpers.
$string['less_than_x_seconds'] = '少于{$a}秒';
$string['half_minute'] = '半分钟';
$string['less_minute'] = '少于一分钟';
$string['a_minute'] = '一分钟';
$string['x_minutes'] = '{$a}分钟';
$string['about_hour'] = '大约一小时';
$string['about_x_hours'] = '大约{$a}小时';
$string['a_day'] = '一天';
$string['x_days'] = '{$a}天';
