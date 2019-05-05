

layui.define('form', function(exports){
    var $ = layui.$
        ,layer = layui.layer
        ,laytpl = layui.laytpl
        ,setter = layui.setter
        ,view = layui.view
        ,admin = layui.admin
        ,form = layui.form;
    form.verify({
        must: function(value, item){ //value：表单的值、item：表单的DOM对象
            if (!value || value == '0'){
                return item.placeholder;
            }
        },
        tips:function (value,item) {
            if (!value || value.length == 0)
            {
                return '请输入'+item.placeholder;
            }
        }
    });
    exports('publictools', {});
});