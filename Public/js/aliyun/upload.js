
accessid = ''
accesskey = ''
host = ''
policyBase64 = ''
signature = ''
callbackbody = ''
filename = ''
key = ''
expire = 0
now = timestamp = Date.parse(new Date()) / 1000; 
var upload_file = new Object();
var upload_i = 0;

 

function send_request()
{
    var xmlhttp = null;
    if (window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  
    if (xmlhttp!=null)
    {
    	var upload_state = $('input[name=upload_state]').val();
        phpUrl = 'http://'+window.location.host+'/Aliyun/get_config/state/'+upload_state;
        xmlhttp.open( "GET", phpUrl, false );
        xmlhttp.send( null );
        return xmlhttp.responseText
    }
    else
    {
        alert("Your browser does not support XMLHTTP.");
    }
};

function get_signature()
{
    //可以判断当前expire是否超过了当前时间,如果超过了当前时间,就重新取一下.3s 做为缓冲
    now = timestamp = Date.parse(new Date()) / 1000; 

    if (expire < now + 3)
    {
        
        body = send_request()
        var obj = eval ("(" + body + ")");
        host = obj['host']
        policyBase64 = obj['policy']
        accessid = obj['accessid']
        signature = obj['signature']
        expire = parseInt(obj['expire'])
        callbackbody = obj['callback'] 
        key = obj['dir']
        return true;
    }
    return false;
};

function set_upload_param(up)
{
    var ret = get_signature()
    if (ret == true)
    {
        new_multipart_params = {
            'key' : key + '${filename}',
            'policy': policyBase64,
            'OSSAccessKeyId': accessid, 
            'success_action_status' : '200', //让服务端返回200,不然，默认会返回204
            'callback' : callbackbody,
            'signature': signature,
        };
        
        up.setOption({
            'url': host,
            'multipart_params': new_multipart_params
        });

        
        //uploader.start();
    }
}


var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : ['selectfiles','selectfiles1','selectfiles2'], 
 
	flash_swf_url : 'lib/plupload-2.1.2/js/Moxie.swf',
	silverlight_xap_url : 'lib/plupload-2.1.2/js/Moxie.xap',
    url : 'http://oss.aliyuncs.com',
    filters: {
     
      max_file_size : '10mb', //最大只能上传400kb的文件
      // prevent_duplicates : true //不允许选取重复文件
    },
	multi_selection:false,
	unique_names:true,
	init: {
		PostInit: function() {
			 
		},	
        //选择图片
		FilesAdded: function(up, files) {
			plupload.each(files, function(file) { 
                if(!checkFileExt(file.name)){
                    up.stop();
                    layer.msg(file.name+"文件不合法！" ,{icon: 2,shade:0.5, time:2000,closeBtn:1});
                    
                    up.removeFile(file.id);
                    return;
                }
				$('#'+use_obj).addClass(file.id);
	            previewImage(file,function(imgsrc){
                   
	                $('.'+file.id).parent().append('<div><img class="upload_files" src="'+imgsrc+'" width="200" height="200"/><a href="javascript:;" onClick="del_img($(this));" id="del_img" data-id="'+file.id+'" class="sc">删除</a></div>');
	                $('.'+file.id).hide();
	                $('.'+file.id).parent().find('input[type=file]').attr('disabled','disabled');
                    
	            })
			});
		},
		 
        //上传中
		UploadProgress: function(up, file) {
            $('#mes').html('上传中，当前进度'+up.total.percent+'%').attr('onClick','');
		},
        //上传完成
		FileUploaded: function(up, file, info) {
            //console.log(info);
            set_upload_param(up);
            if (info.status == 200){
                var json = JSON.parse(info.response);   //console.log(json);
                upload_file[upload_i] = json.file;
                upload_i++;
            }else{
                document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = info.response;
            } 
		},
        //上传完成触发
        UploadComplete:function(up,files){
            //console.log(upload_file);
            subData(upload_file); //上传完成回调函数
        },
        //错误信息
		Error: function(up, err) {
            set_upload_param(up);
            console.log(err.response);
			// document.getElementById('console').appendChild(document.createTextNode("\nError xml:" + err.response));
		},

	}
});



    uploader.init();
    //绑定文件添加进队列事件
    uploader.bind('FilesAdded',function(uploader,files){
    
    });
    //plupload中为我们提供了mOxie对象
    //有关mOxie的介绍和说明请看：https://github.com/moxiecode/moxie/wiki/API
    //如果你不想了解那么多的话，那就照抄本示例的代码来得到预览的图片吧
    function previewImage(file,callback){//file为plupload事件监听函数参数中的file对象,callback为预览图片准备完成的回调函数
        if(!file || !/image\//.test(file.type)) return; //确保文件是图片
        if(file.type=='image/gif'){//gif使用FileReader进行预览,因为mOxie.Image只支持jpg和png
            var fr = new mOxie.FileReader();
            fr.onload = function(){
                callback(fr.result);
                fr.destroy();
                fr = null;
            }
            fr.readAsDataURL(file.getSource());
        }else{
            var preloader = new mOxie.Image();
            preloader.onload = function() {
                preloader.downsize( 300, 300 );//先压缩一下要预览的图片,宽300，高300
                var imgsrc = preloader.type=='image/jpeg' ? preloader.getAsDataURL('image/jpeg',80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
                callback && callback(imgsrc); //callback传入的参数为预览图片的url
                preloader.destroy();
                preloader = null;
            };
            preloader.load( file.getSource() );
        }   
    }
    
    //点击删除前台显示的图片，同时删除上传队列中的该图片文件 
    function del_img(obj,id){
        $('.'+obj.attr('data-id')).show();
        $('.'+obj.attr('data-id')).parent().find('input[type=file]').removeAttr('disabled');
        obj.parent().remove();  

        var toremove = '';
        var id=obj.attr("data-id");
        for(var i in uploader.files){
            if(uploader.files[i].id === id){
                toremove = i;
            }
        }
        //splice(start, length)     从上传队列中移除一部分文件，start为开始移除文件在队列中的索引，length为要移除的文件的数量，该方法的返回值为被移除的文件。该方法会触发FilesRemoved 和QueueChanged事件
        uploader.files.splice(toremove, 1);  
        console.log("XXX"+$(this).attr("data-id"));
    }
   
	var use_obj = ''; 
	$('.upload').click(function(){
		use_obj= $(this).attr('data-id');
	})


    //3、（字符）检查文件上传表单控件，如果含有[jpg,jpeg,gif,png]则显示“文件类型合法”，否则“显示文件类型错误”
 

    //JS图片文件后缀验证
    function checkFileExt(filename){
        var flag = false; //状态
        var arr = ["jpg","gif","png",'jpeg'];
        //取出上传文件的扩展名
        var index = filename.lastIndexOf(".");
        var ext = filename.substr(index+1);
        //循环比较
        for(var i=0;i<arr.length;i++){
          if(ext == arr[i]){
            flag = true; //一旦找到合适的，立即退出循环
            break;
          }
        }

        //条件判断
        if(!flag){
            return 0;
        }

        return 1;
    }
