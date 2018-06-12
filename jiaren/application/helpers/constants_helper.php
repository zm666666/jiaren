<?php
/**
 * 统一定义常量
 * 
 * @copyright 2017-11-28
 */

defined('TIP_UNKNOWN_ERROR') OR define("TIP_UNKNOWN_ERROR", "网络异常!请稍后再试！");//未知错误提示文字
defined('TIP_SAVE_SUC') OR define("TIP_SAVE_SUC", "保存成功！");
defined('TIP_SAVE_FAIL') OR define("TIP_SAVE_FAIL", "保存失败！");
defined('TIP_ADD_SUC') OR define("TIP_ADD_SUC", "新增成功！");
defined('TIP_ADD_FAIL') OR define("TIP_ADD_FAIL", "新增失败！");
defined('TIP_CHANGE_SUC') OR define("TIP_CHANGE_SUC", "修改成功！");
defined('TIP_CHANGE_FAIL') OR define("TIP_CHANGE_FAIL", "修改失败！");
defined('TIP_DELETE_SUC') OR define("TIP_DELETE_SUC", "删除成功！");
defined('TIP_DELETE_FAIL') OR define("TIP_DELETE_FAIL", "删除失败！");
defined('TIP_DELETE_DETRY') OR define("TIP_DELETE_DETRY", "撤销成功！");
defined('TIP_SUC') OR define("TIP_SUC", "成功！");
defined('TIP_JUDGEINFO_SYSTYPE') OR define("TIP_JUDGEINFO_SYSTYPE", "类型重复！");
defined('TIP_JUDGEINFO_CHINESENAME') OR define("TIP_JUDGEINFO_CHINESENAME", "中文名称不能重复！");
defined('TIP_JUDGEINFO_ENGLISHNAME') OR define("TIP_JUDGEINFO_ENGLISHNAME", "英文名称不能重复！");
defined('TIP_JUDGEINFO_GROUP') OR define("TIP_JUDGEINFO_GROUP", "分组已存在！");
defined('TIP_JUDGEINFO_EMPTY') OR define("TIP_JUDGEINFO_EMPTY", "名称不能为空！");
defined('TIP_JUDGETYPE_EMPTY') OR define("TIP_JUDGETYPE_EMPTY", "类别不能为空！");
defined('TIP_JUDGEINFO_OPTID') OR define("TIP_JUDGEINFO_OPTID", "对应选项不能为空！");
defined('TIP_JUDGEINFO_POSTNAME') OR define("TIP_JUDGEINFO_POSTNAME", "职务名称不能重复！");
defined('TIP_JUDGEINFO_POSTTYPE') OR define("TIP_JUDGEINFO_POSTTYPE", "职务分类名称不能重复！");
defined('TIP_JUDGEINFO_ORGNAME') OR define("TIP_JUDGEINFO_ORGNAME", "组织名称不能重复！");
defined('TIP_JUDGEINFO_ORGMOVE') OR define("TIP_JUDGEINFO_ORGMOVE", "不能移动到子部门！");
defined('TIP_JUDGEINFO_ORGMERGE') OR define("TIP_JUDGEINFO_ORGMERGE", "不能合并到子部门！");
defined('TIP_JUDGEINFO_ORGDEL') OR define("TIP_JUDGEINFO_ORGDEL", "删除失败，当前组织架构下还有子组织架构！");
defined('TIP_FILE_SUCCESS') OR define("TIP_FILE_SUCCESS", "文件上传成功！ ");
defined('TIP_FILE_ERROR') OR define("TIP_FILE_ERROR", "未知原因上传失败！ ");
defined('TIP_FILE_FLASE') OR define("TIP_FILE_FLASE", "文件格式错误上传失败！ ");
defined('TIP_FILE_EXIT') OR define("TIP_FILE_EXIT", "文件不存在！ ");
defined('TIP_USER_FALSE') OR define("TIP_USER_FALSE", "通知人不能为空！ ");
defined('TIP_WAIT') OR define("TIP_WAIT", "保存成功，等待核对！ ");
defined('TIP_NOTICE') OR define("TIP_NOTICE", "有新的消息请查看");
defined('TIP_CUSTOMER') OR define("TIP_CUSTOMER", "客户");
defined('TIP_CONTRACT') OR define("TIP_CONTRACT", "合同");
defined('TIP_CONTRACT_INFO') OR define("TIP_CONTRACT_INFO", "补充协议");
defined('TIP_OTP1') OR define("TIP_OTP1", "添加");
defined('TIP_OTP2') OR define("TIP_OTP2", "编辑");
defined('TIP_OTP3') OR define("TIP_OTP3", "删除");
defined('TIP_OTP4') OR define("TIP_OTP4", "还原");
defined('TIP_OTP5') OR define("TIP_OTP5", "彻底删除");
defined('TIP_OTP6') OR define("TIP_OTP6", "通知人变更");
defined('TIP_TIME_ERROR') OR define("TIP_TIME_ERROR", "时间格式错误");
defined('TIP_SAVE_NAME') OR define("TIP_SAVE_NAME", "用户名有重名请注意！");
defined('TIP_SET') OR define("TIP_SET", "成功设置常用！");
defined('TIP_SET_CH') OR define("TIP_SET_CH", "取消设置常用！");
defined('TIP_CUSTOMER_DEL') OR define("TIP_CUSTOMER_DEL", "客户删除失败，因为存在合同关联！");
defined('TIP_DEL_WAIT') OR define("TIP_DEL_WAIT", "删除成功，等待第二人确认！");
defined('TIP_CHECK_WAIT') OR define("TIP_CHECK_WAIT", "信息核对不符，请查看比对信息！");
defined('TIP_CHECK_EDIT') OR define("TIP_CHECK_EDIT", "该信息锁定中，无法编辑");
defined('TIP_CHANGE_NOTICE') OR define("TIP_CHANGE_NOTICE", "通知人发生变更");
//defined('TIP_JUDGEINFO_ORGIMPORT') OR define("TIP_JUDGEINFO_ORGIMPORT", "请先选择文件！");