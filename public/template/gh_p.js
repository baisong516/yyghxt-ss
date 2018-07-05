(function() {
    if (window.Guahao) return false;
    window.Guahao = window.Guahao || {};
    var documentTitle = document.title;
    var documentURL = window.location.href;
    var URL = decodeURIComponent(document.referrer);
    if (URL.indexOf("baidu.com") > 0 || URL.indexOf("sogou.com") > 0 || URL.indexOf("so.com") > 0 || URL.indexOf("sm.cn") > 0) {
        var beforeURL = (function(url) {
            var urlArr = url.match(/utm_term=(.*?)\&|keyword=(.*?)\&|wd=(.*?)\&|q=(.*?)\&|word=(.*?)\&/);
            urlStr = urlArr.filter(function(item) {
                return item != undefined
            })[1];
            localStorage.kw = urlStr
        })(URL)
    }
    Guahao = {
        "that": this,
        SubmitForm: function() {
            var that = this;
            var isVerifi = that.isExitsFunction(that.Config_ApiName[0]) ? window[that.isExitsFunction(that.Config_ApiName[0])]() : that.CheckForm();
            if (isVerifi) that.AjaxSubmit()
        },
        AjaxSubmit: function() {
            that.$.ajax({
                url: that.Config_AjaxURL,
                dataType: "jsonp",
                data: that.Obj_Form.serialize() + that.Config_Query + "&gh_docTitle=" + documentTitle + "&gh_kw=" + localStorage.kw,
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
        SetFocus: function(obj) {
            obj.focus()
        },
        ShowMsg: function(msg, obj) {
            layer.msg(msg, {
                icon: 2,
                shade: [0.3, '#000']
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
                console.log("[Guahao]", FunVal + " \u81ea\u5b9a\u4e49\u63a5\u53e3\u4e0d\u662f\u6709\u6548\u7684\u51fd\u6570\u3002");
                return false
            } else {
                return false
            }
        },
        ShowTips: function(type, text, msg) {
            if (type == "loading") {
                that.Obj_Submit.attr("disabled", "disabled").css("cursor", "not-allowed");
                layer.msg(that.StrMsg_SendLoading, {
                    time: 0,
                    icon: 16,
                    shade: [0.3, '#000']
                })
            }
            if (type == "success") {
                if (this.isExitsFunction(that.Config_ApiName[3])) {
                    layer.closeAll();
                    window[that.isExitsFunction(that.Config_ApiName[3])](msg)
                } else {
                    layer.alert(msg, {
                        icon: 6,
                        area: '460px'
                    });
                    typeof that.Obj_Form[0].reset == "function" ? that.Obj_Form[0].reset() : that.Obj_Form[0].reset.click()
                }
            }
            if (type == "error") {
                if (this.isExitsFunction(that.Config_ApiName[4])) {
                    window[that.isExitsFunction(that.Config_ApiName[4])](text)
                } else {
                    layer.alert(text, {
                        icon: 5
                    })
                }
            }
            if (type == "faile") {
                layer.alert(that.StrMsg_SendNetError, {
                    icon: 5
                })
            }
            if (type == "done") {
                that.Obj_Submit.attr("disabled", false).css("cursor", "")
            }
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
                if (typeof(that.Laydateinit) == "undefined") {
                    that.Laydateinit = true;
                    Dates.addClass("laydate-icon");
                    Dates.attr("onclick", 'laydate({isclear: false,issure: false,event: "focus",min: laydate.now(0)})');
                    that.$.getScript(that.Config_DateScriptURL, setTimeout(function() {
                        laydate.skin(layskin)
                    }, 1500))
                } else {
                    Dates.addClass("laydate-icon");
                    Dates.attr("onclick", 'laydate({isclear: false,issure: false,event: "focus",min: laydate.now(0)})')
                }
            }
            Submit.on("click", function(e) {
                that.Setinitobj(that.$(this));
                that.SubmitForm()
            })
        },
        initialize: function() {
            if (typeof(BsSwt) != "undefined" && typeof(BsSwt.$) != "undefined") {
                this.$ = BsSwt.$;
                this.jQuery = BsSwt.$
            } else if (typeof(window.$) != "undefined") {
                this.$ = window.$;
                this.jQuery = window.$
            } else {
                alert("[Guahao]\u9875\u9762\u6ca1\u6709\u52a0\u8f7d\u006a\u0051\u0075\u0065\u0072\u0079\u002e");
                return false
            } if (!this.CompareJQ(this.$)) {
                alert("[Guahao]\u006a\u0051\u0075\u0065\u0072\u0079\u7248\u672c\u6700\u4f4e\u8981\u6c42\u0031\u002e\u0039\u002c\u8bf7\u66f4\u6362\u5426\u5219\u5c06\u4e0d\u80fd\u6b63\u5e38\u4f7f\u7528\uff01");
                return false
            }
            this.$.getScript(that.Config_LayScriptURL, function() {
                layer.config({
                    path: that.Config_LayPath,
                    shadeClose: true,
                    move: false
                })
            });
            var Forms = this.$("form[name='gh_form']");
            for (i = 0; i < Forms.length; i++) {
                this.Setinitialize(Forms.eq(i))
            }
        }
    };
    var that = this.Guahao;
    that.StrMsg_NameNull = "\u59d3\u540d\u4e0d\u80fd\u4e3a\u7a7a\uff0c\u8bf7\u586b\u5199\u60a8\u7684\u59d3\u540d\uff01";
    that.StrMsg_NameError = "\u59d3\u540d\u683c\u5f0f\u6709\u8bef\uff0c\u8bf7\u586b\u5199\u6b63\u786e\u7684\u59d3\u540d\uff01";
    that.StrMsg_SexNull = "\u6027\u522b\u4e0d\u80fd\u4e3a\u7a7a\u002c\u8bf7\u9009\u62e9\u60a8\u7684\u6027\u522b\uff01";
    that.StrMsg_AgeNull = "\u5e74\u9f84\u4e0d\u80fd\u4e3a\u7a7a\uff0c\u8bf7\u586b\u5199\u60a8\u7684\u5e74\u9f84\uff01";
    that.StrMsg_TelNull = "\u8054\u7cfb\u7535\u8bdd\u4e0d\u80fd\u4e3a\u7a7a\uff0c\u8bf7\u586b\u5199\u60a8\u7684\u8054\u7cfb\u65b9\u5f0f\uff01";
    that.StrMsg_TelError = "\u8054\u7cfb\u7535\u8bdd\u683c\u5f0f\u4e0d\u6b63\u786e\uff0c\u6b63\u786e\u7684\u53f7\u7801\u5e94\u8be5\u662f\u0031\u0031\u4f4d\u624b\u673a\u53f7\uff01";
    that.StrMsg_QQNull = "\u0051\u0051\u53f7\u7801\u4e0d\u80fd\u4e3a\u7a7a\uff0c\u8bf7\u586b\u5199\u60a8\u7684\u0051\u0051\u53f7\u7801\uff01";
    that.StrMsg_QQError = "\u0051\u0051\u53f7\u7801\u683c\u5f0f\u4e0d\u6b63\u786e\uff0c\u8bf7\u586b\u5199\u6b63\u786e\u7684\u0051\u0051\u53f7\u7801\uff01";
    that.StrMsg_DateNull = "\u9884\u7ea6\u65f6\u95f4\u4e0d\u80fd\u4e3a\u7a7a\uff0c\u8bf7\u9009\u62e9\u60a8\u7684\u9884\u7ea6\u65f6\u95f4\uff01";
    that.StrMsg_DateError = "\u9884\u7ea6\u65f6\u95f4\u683c\u5f0f\u4e0d\u6b63\u786e\uff0c\u8bf7\u91cd\u65b0\u8f93\u5165\uff01";
    that.StrMsg_DiseasesNull = "\u9884\u7ea6\u79d1\u5ba4\u4e0d\u80fd\u4e3a\u7a7a\uff0c\u8bf7\u9009\u62e9\u60a8\u8981\u9884\u7ea6\u7684\u79d1\u5ba4\uff01";
    that.StrMsg_DiseasesError = "\u9884\u7ea6\u79d1\u5ba4\u4e0d\u80fd\u4e3a\u7a7a\uff0c\u8bf7\u9009\u62e9\u60a8\u8981\u9884\u7ea6\u7684\u79d1\u5ba4\uff01";
    that.StrMsg_DoctorNull = "\u8bf7\u9009\u62e9\u8981\u9884\u7ea6\u7684\u4e13\u5bb6\uff01";
    that.StrMsg_DescriptNull = "\u75c5\u60c5\u63cf\u8ff0\u4e0d\u80fd\u4e3a\u7a7a\uff0c\u8bf7\u7528\u7b80\u77ed\u7684\u8bdd\u8bed\u63cf\u8ff0\u60a8\u7684\u75c5\u60c5\uff01";
    that.StrMsg_SendOkOnline = "\u60a8\u7684\u7533\u8bf7\u5df2\u63d0\u4ea4\u6210\u529f\uff0c\u5982\u6709\u7591\u95ee\u53ef\u62e8\u6253{$_hospitalTel}\u8054\u7cfb\u3002";
    that.StrMsg_SendOkOffline = "\u60a8\u7684\u7533\u8bf7\u5df2\u63d0\u4ea4\u6210\u529f\uff0c\u5982\u6709\u7591\u95ee\u53ef\u62e8\u6253{$_hospitalTel}\u8054\u7cfb\u3002";
    that.StrMsg_SendError = "\u63d0\u4ea4\u5931\u8d25\uff0c\u8bf7\u7a0d\u540e\u518d\u8bd5\uff01";
    that.StrMsg_SendLoading = "\u6b63\u5728\u63d0\u4ea4\u6302\u53f7\u4fe1\u606f\u4e2d\u002c\u8bf7\u7a0d\u5019\u002e\u002e\u002e";
    that.StrMsg_SendLoadingSmaill = "\u63d0\u4ea4\u4e2d";
    that.StrMsg_SendNetError = "\u7f51\u7edc\u53d1\u751f\u9519\u8bef\uff0c\u8bf7\u7a0d\u540e\u518d\u8bd5\uff01";
    that.StrMsg_CactapError = "\u9a8c\u8bc1\u9519\u8bef\uff0c\u8bf7\u91cd\u8bd5\uff01";
    that.Config_Domain = "//www.yyyygh.com/";
    that.Config_DateScriptURL = that.Config_Domain + "js/laydate/laydate.js";
    that.Config_LayPath = "//yygh.oss-cn-shenzhen.aliyuncs.com/layer/";
    that.Config_LayScriptURL = that.Config_LayPath + "layer.js";
    that.Config_TelReg = /^1\d{10}$/;
    that.Config_NameReg = /^[\u4e00-\u9fa5]{2,5}$/;
    that.Config_QQReg = /^[1-9]\d{4,8}$/;
    that.Config_DateReg = /^\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$/;
    that.Config_AjaxURL = that.Config_Domain + "api/gh";
    // that.Config_RefURL = encodeURIComponent(document.referrer);
    that.Config_RefURL = encodeURIComponent(document.location.href);
    that.Config_Hosptial = "{$_hospitalId}";
    that.Config_Offices = "{$_officeId}";
    that.Config_Query = "&gh_sms=1&gh_hosptial=" + that.Config_Hosptial + "&gh_refurl=" + that.Config_RefURL + "&gh_offices=" + that.Config_Offices;
    that.Config_SexHtml = '<option value="male">男</option><option value="female">女</option>';
    that.Config_DiseasesHtml = '{$_diseaseOptions}';
    that.Config_OnlineDate = "07:00-11:59";
    that.Config_OfflineDate = "00:00-06:59";
    that.Config_strDomtel = "{$_hospitalTel}";
    that.Config_strDateSkin = "default";
    that.Config_ApiName = ['verify', 'before', 'success', 'suc', 'err', 'error', 'complete'];
    that.initialize()
})();