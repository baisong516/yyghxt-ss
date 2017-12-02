(function() {
    if (window.Guahao) return false;
    window.Guahao = window.Guahao || {};
    Guahao = {
        "that": this,
        SubmitForm: function() {
            var that = this;
            var isVerifi = that.isExitsFunction(that.Config_ApiName[0]) ? window[that.isExitsFunction(that.Config_ApiName[0])]() : that.CheckForm();
            if (isVerifi) that.AjaxSubmit()
        },
        AjaxSubmit: function() {
            console.log(that.Obj_Form.serialize() + that.Config_Query);
            that.$.ajax({
                url: that.Config_AjaxURL,
                dataType: "JSONP",
                data: that.Obj_Form.serialize() + that.Config_Query,
                beforeSend: function() {
                    that.AjaxbeforeSend()
                },
                success: function(data) {
                    that.AjaxSuccess(data)
                },
                error: function(request) {
                    that.AjaxError()
                },
                complete: function() {
                    that.Ajaxcomplete()
                }
            })
        },
        CheckForm: function() {
            var that = this;
            var ObjTotal = ["Name", "Sex", "Age", "Tel", "QQ", "Diseases", "Doctor", "Date", "Descript"];
            for (var i = 0; i < ObjTotal.length; i++) {
                var ObjMsgNull = eval("that.StrMsg_" + ObjTotal[i] + "Null");
                var ObjMsgError = eval("that.StrMsg_" + ObjTotal[i] + "Error");
                var ObjConfigReg = eval("that.Config_" + ObjTotal[i] + "Reg");
                var obj = eval("that.Obj_" + ObjTotal[i]);
                if (obj.length > 0 && obj.attr("data-req") == "true" && (obj.val() == "" || obj.val() == "normal")) {
                    that.ShowMsg(ObjMsgNull, obj);
                    that.SetFocus(obj);
                    return false;
                    break
                }
                if (obj.attr("data-reg") == "true" && !ObjConfigReg.test(obj.val())) {
                    that.ShowMsg(ObjMsgError, obj);
                    that.SetFocus(obj);
                    return false;
                    break
                }
            }
            return true
        },
        AjaxbeforeSend: function() {
            this.isExitsFunction(that.Config_ApiName[1]) ? window[that.isExitsFunction(that.Config_ApiName[1])]() : this.ShowTips('loading')
        },
        AjaxSuccess: function(data) {
            this.isExitsFunction(that.Config_ApiName[2]) ? window[that.isExitsFunction(that.Config_ApiName[2])](data.type, data.content, that.StrMsg_SendOkOnline) : this.ShowTips(data.type, data.content, that.StrMsg_SendOkOnline)
        },
        AjaxError: function() {
            this.isExitsFunction(that.Config_ApiName[5]) ? window[that.isExitsFunction(that.Config_ApiName[5])]() : this.ShowTips('faile')
        },
        Ajaxcomplete: function() {
            this.isExitsFunction(that.Config_ApiName[6]) ? window[that.isExitsFunction(that.Config_ApiName[6])]() : this.ShowTips('done')
        },
        SetFocus: function(obj) {},
        ShowMsg: function(msg, obj) {
            layer.open({
                content: msg,
                style: 'bottom: 0px;',
                skin: 'msg',
                time: 3
            })
        },
        CompareJQ: function(jq) {
            var jqVer = jq.fn.jquery;
            var jqVerArr = new Array();
            var jqVerArr = jqVer.split(".");
            for (i = 0; i < jqVerArr.length; i++) {
                if (jqVerArr[0] < 1 && jqVerArr[0] != 1) {
                    break;
                    return false
                }
                if (jqVerArr[1] < 9 && jqVerArr[1] != 9) {
                    break;
                    return false
                }
                return true
            }
        },
        CompareDate: function(startTime, endTime, daydate) {
            if (endTime > startTime) {
                return daydate > startTime && daydate < endTime
            } else {
                return daydate < startTime && daydate > endTime || daydate == endTime
            }
        },
        isExitsFunction: function(funcName) {
            var FunVal = that.$(that.Obj_Form).data(funcName);
            if (typeof(FunVal) != "undefined" && FunVal != "") {
                try {
                    if (typeof eval(FunVal) == "function") return FunVal
                } catch (e) {}
                console.log("[Guahao]", FunVal + " 自定义接口不是有效的函数。");
                return false
            } else {
                return false
            }
        },
        ShowTips: function(type, text, msg) {
            if (type == "loading") {
                that.Obj_Submit.attr("disabled", "disabled").css("cursor", "not-allowed");
                layer.open({
                    type: 2,
                    content: that.StrMsg_SendLoadingSmaill
                })
            }
            if (type == "success") {
                layer.closeAll();
                if (this.isExitsFunction(that.Config_ApiName[3])) {
                    window[that.isExitsFunction(that.Config_ApiName[3])](msg)
                } else {
                    layer.open({
                        content: '<img src="' + that.StrIconSuccess + '" style="width:32px;height:32px;vertical-align: middle;margin-right: 5px;">' + msg,
                        time: 3
                    });
                    typeof that.Obj_Form[0].reset == "function" ? that.Obj_Form[0].reset() : that.Obj_Form[0].reset.click()
                }
            }
            if (type == "error") {
                layer.closeAll();
                if (this.isExitsFunction(that.Config_ApiName[4])) {
                    window[that.isExitsFunction(that.Config_ApiName[4])](text)
                } else {
                    layer.open({
                        content: '<img src="' + that.StrIconError + '" style="width:32px;height:32px;vertical-align: middle;margin-right: 5px;">' + text,
                        btn: '确定'
                    })
                }
            }
            if (type == "faile") {
                layer.closeAll();
                layer.open({
                    content: '<img src="' + that.StrIconError + '" style="width:32px;height:32px;vertical-align: middle;margin-right: 5px;">' + that.StrMsg_SendNetError,
                    btn: '确定'
                })
            }
            if (type == "done") {
                that.Obj_Submit.attr("disabled", false).css("cursor", "")
            }
        },
        SetinitMobiScroll: function(date, diseases) {
            console.log(date);
            date.mobiscroll().calendar({
                theme: 'mobiscroll',
                display: 'bottom',
                lang: 'zh',
                startYear: (new Date()).getFullYear(),
                endYear: (new Date()).getFullYear(),
                min: new Date((new Date()).getFullYear(), (new Date()).getMonth(), (new Date()).getDate()),
                max: new Date((new Date()).getFullYear(), 11, 31),
            });
            diseases.mobiscroll().select({
                theme: 'mobiscroll',
                lang: 'zh',
                display: 'bottom',
                showInput: false,
            });
            diseases.removeClass("mbsc-sel-hdn")
        },
        Setinitobj: function(o) {
            that.Obj_Form = o.parents("form[name='gh_form']");
            that.Obj_Name = that.Obj_Form.find("input[name='gh_name']");
            that.Obj_Sex = that.Obj_Form.find("select[name='gh_sex']");
            that.Obj_Age = that.Obj_Form.find("input[name='gh_age']");
            that.Obj_Tel = that.Obj_Form.find("input[name='gh_tel']");
            that.Obj_QQ = that.Obj_Form.find("input[name='gh_qq']");
            that.Obj_Date = that.Obj_Form.find("input[name='gh_date']");
            that.Obj_Diseases = that.Obj_Form.find("select[name='gh_disease']");
            that.Obj_Doctor = that.Obj_Form.find("input[name='gh_doctor']");
            that.Obj_Descript = that.Obj_Form.find("textarea[name='gh_des']");
            that.Obj_Submit = that.Obj_Form.find("input[name='gh_submit'],button[name='gh_submit'],a[name='gh_submit']")
        },
        Setinitialize: function(o) {
            var that = this;
            var f = typeof(o) == "string" ? eval("that.$('" + o + "')") : o;
            var layskin = arguments[1] || that.Config_strDateSkin;
            var Submit = f.find("input[name='gh_submit'],button[name='gh_submit'],a[name='gh_submit']");
            var Sex = f.find("select[name='gh_sex']");
            var Dates = f.find("input[name='gh_date']");
            var Diseases = f.find("select[name='gh_disease']");
            Sex.html(that.Config_SexHtml);
            Diseases.html(that.Config_DiseasesHtml);
            if (Dates.length > 0) {
                that.$('head').append('<link href="' + that.Config_MobiScrollCssURL + '" rel="stylesheet" type="text/css" />');
                that.$.getScript(that.Config_MobiScrollJsURL, function() {
                    that.SetinitMobiScroll(Dates, Diseases);
                })
            }
            Submit.on("click", function(e) {
                that.Setinitobj(that.$(this));
                that.SubmitForm();
            })
        },
        initialize: function() {
            if (typeof(window.$) != "undefined") {
                this.$ = window.$;
                this.jQuery = window.$
            } else {
                alert("[Guahao]页面没有加载jQuery.");
                return false;
            }
            if (!this.CompareJQ(this.$)) {
                alert("[Guahao]jQuery版本最低要求1.9,请更换否则将不能正常使用！");
                return false;
            }
            this.$.getScript(that.Config_LayScriptURL);
            var Forms = this.$("form[name='gh_form']");
            for (var i = 0; i < Forms.length; i++) {
                this.Setinitialize(Forms.eq(i));
            }
        }
    };
    var that = this.Guahao;
    that.StrMsg_NameNull = "姓名不能为空，请填写您的姓名！";
    that.StrMsg_NameError = "姓名格式有误，请填写正确的姓名！";
    that.StrMsg_SexNull = "性别不能为空,请选择您的性别！";
    that.StrMsg_AgeNull = "年龄不能为空，请填写您的年龄！";
    that.StrMsg_TelNull = "联系电话不能为空，请填写您的联系方式！";
    that.StrMsg_TelError = "联系电话格式不正确，正确的号码应该是11位手机号！";
    that.StrMsg_QQNull = "QQ号码不能为空，请填写您的QQ号码！";
    that.StrMsg_QQError = "QQ号码格式不正确，请填写正确的QQ号码！";
    that.StrMsg_DateNull = "预约时间不能为空，请选择您的预约时间！";
    that.StrMsg_DateError = "预约时间格式不正确，请重新输入！";
    that.StrMsg_DiseasesNull = "预约科室不能为空，请选择您要预约的科室！";
    that.StrMsg_DiseasesError = "预约科室不能为空，请选择您要预约的科室！";
    that.StrMsg_DoctorNull = "请选择要预约的专家！";
    that.StrMsg_DescriptNull = "病情描述不能为空，请用简短的话语描述您的病情！";
    that.StrMsg_SendOkOnline = "您的申请已提交成功，请注意留意接收手机预约短信，如有疑问可拨打<a style=\"color:#337ab7;\" href=\"tel:{$_hospitalTel}\" target=\"_self\">{$_hospitalTel}</a>联系。";
    that.StrMsg_SendOkOffline = "您的申请已提交成功，请注意留意接收手机预约短信，如有疑问可拨打<a style=\"color:#337ab7;\" href=\"tel:{$_hospitalTel}\" target=\"_self\">{$_hospitalTel}</a>联系。";
    that.StrMsg_SendError = "提交失败，请稍后再试！";
    that.StrMsg_SendLoading = "正在提交挂号信息中,请稍候...";
    that.StrMsg_SendLoadingSmaill = "提交中";
    that.StrMsg_SendNetError = "网络发生错误，请稍后再试！";
    that.StrMsg_CactapError = "验证错误，请重试！";
    that.Config_Oss = "http://yygh.oss-cn-shenzhen.aliyuncs.com";
    that.StrIconSuccess = that.Config_Oss + "/success.png";
    that.StrIconError = that.Config_Oss + "/error.png";
    that.Config_Domain = "http://www.yyyygh.com/";
    that.Config_MobiScrollJsURL = that.Config_Oss + "/mobiscroll/js/mobiscroll.custom-3.0.0-beta2.min.js";
    that.Config_MobiScrollCssURL = that.Config_Oss + "/mobiscroll/css/mobiscroll.custom-3.0.0-beta2.min.css";
    that.Config_LayerMobileUrl = that.Config_Oss + "/layer/mobile/layer.js";
    that.Config_DateScriptURL = that.Config_Oss + "/laydate/laydate.js";
    that.Config_LayPath = that.Config_Oss + "{$_layPath}";
    that.Config_LayScriptURL = that.Config_LayPath + "layer.js";
    that.Config_TelReg = /^1\d{10}$/;
    that.Config_NameReg = /^[一-龥]{2,5}$/;
    that.Config_QQReg = /^[1-9]\d{4,8}$/;
    that.Config_DateReg = /^\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$/;
    that.Config_AjaxURL = that.Config_Domain + "api/gh";
    that.Config_RefURL = encodeURIComponent(document.location.href);
    that.Config_Hosptial = "{$_hospitalId}";
    that.Config_Offices = "{$_officeId}";
    that.Config_Query = "&gh_sms=1&gh_hosptial=" + that.Config_Hosptial + "&gh_refurl=" + that.Config_RefURL + "&gh_offices=" + that.Config_Offices;
    that.Config_SexHtml = '<option value="male">男</option><option value="female">女</option>';
    that.Config_DiseasesHtml = '{$_diseaseOptions}';
    that.Config_OnlineDate = "07:00-11:59";
    that.Config_OfflineDate = "00:00-06:59";
    that.Config_strDomtel = "<a style=\"color:#337ab7;\" href=\"tel:{$_hospitalTel}\" target=\"_self\">{$_hospitalTel}</a>";
    that.Config_strDateSkin = "default";
    that.Config_ApiName = ['verify', 'before', 'success', 'suc', 'err', 'error', 'complete'];
    that.initialize()
})();