var layerAlertShowTime = 2000; //弹框提示显示时间

//验证手机号码
function verifyPhone(val){
  var  reg= /^1[3|4|5|8|7][0-9]\d{8}$/;
  if(reg.test(val)) return 1;
  return 0;
}

//验证姓名
function verifyRealname(val){
  var reg = /[\u4e00-\u9fa5]/;
  if(reg.test(val)) return 1;
  return 0;
}

//验证邮箱
function veirfyEmail(val){
  var reg = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
  if(reg.test(val)) return 1;
  return 0;
}

//验证身份证
function verifyIdCard(val){
  var reg =/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/;
  if(reg.test(val)) return 1;
  return 0;
}

