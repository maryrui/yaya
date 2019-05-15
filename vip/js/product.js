function productFn (){
    this.isPos = [];//li长度
    this.getArr=[];//获取签到数组,会有重复
    this.init();
}
productFn.prototype={
    constructor: productFn,
    init:function(){
        var me = this,getArr=me.getArr;
        for(var i=0;i<105;i++){
            me.isPos.push(i);
        }
        this.cloneArr=me.isPos.slice(0);
        $.ajax({
            type:"post",
            url:"./data/data.json",
            //url:"http://yxbsve.mmarket.com/index.php?c=Api&a=wall_message",
            async:true,
            success:function(res){
                getArr.push.apply(getArr,res.data)
            }
        })
        setInterval(function(){
            $.ajax({
                type:"post",
                url:"./data/data.json",
                //url:"http://yxbsve.mmarket.com/index.php?c=Api&a=wall_message",
                success:function(res){
                    getArr.push.apply(getArr,res.data)
                }
            })
        },2000)


        me.btnHover();
        document.querySelector(".top-img").addEventListener("click",function(){
            me.clickFn()
        })
        document.querySelector(".closed").addEventListener("click",function(){
            me.close()
        })
        /*
        *  getArr[i]  imgurl头像  content发言内容   nickname微信用户名 msgtype发言类型(event签到未发言 text文字 image图片)
        * */
        var i=0;
        var io=0;
        var olArr = [];

        var timer = setInterval(function(){
            if(getArr.length == 0) return false
            if(olArr.indexOf(getArr[i].id)===-1){
                if(getArr[i].state===0){//0 未签到  1已签到
                    console.log(getArr[i])
                    olArr.push(getArr[i].id);

                    io++;
                    // if(io<106){
                        me.getInfo(io,getArr[i].imgurl,getArr[i].content,getArr[i].nickname,getArr[i].msgtype,getArr[i].id);
                    /*}else{
                        alert(1);
                    }*/
                }
                i++;
            }
        },2000)
    },
    btnHover:function(event){
        var me = this;
        var btnLi = document.querySelectorAll(".btn-li");
        for(var i=0,len=btnLi.length;i<len;i++){
            var chird = btnLi[i];
            chird.index = i;
            var alt = chird.getAttribute("alt");
            var tips = document.createElement("span");
            tips.className="tips";
            tips.innerHTML=alt;
            var pos = me.getMousePos(chird);
            chird.onmouseover=function(){
                document.body.appendChild(tips)
                //下面数值66设置为固定值，疑似未插入dom前没有width，获取为空，不知道怎么获取来计算生成的节点来设置定位居中
                tips.setAttribute("style","position:absolute;top:"+(pos.y-43)+"px;left:"+(pos.x - (66-32)/2 )+"px;padding:0 12px")
            }
            chird.onmouseout=function(){
                document.body.removeChild(tips)
            }
        }
    },
    getMousePos:function(element){
        return {"x":element.offsetLeft,"y":element.offsetTop};
    },
    clickFn:function(){
        document.querySelector(".wall-ul").style.visibility="hidden";
        document.querySelector(".big-code").style.display="block";
    },
    close:function(){
        document.querySelector(".wall-ul").style.visibility="visible";
        document.querySelector(".big-code").style.display="none";
    },
    getInfo:function(classNum,path,content,nickname,msgtype,id){
        var me = this,isPosArr=me.isPos;
        document.querySelector(".joinCount p").innerHTML=classNum;
        var srcStr = path;
        /*
        * isPosArr li排列数组
        * nums 随机获取li之一的下标
        * */
        var arrnum;
        var nums;
        if(classNum<106){
            arrnum = Math.floor(Math.random()*me.cloneArr.length);
            nums = me.cloneArr[arrnum];
            me.cloneArr.splice(arrnum,1);
        }else{
            arrnum = Math.floor(Math.random()*105);
            nums = isPosArr[arrnum];
        }
        //上墙后修改数据状态
        $.ajax({
            type:"post",
            url:"http://yxbsve.mmarket.com/index.php?c=Api&a=wechat_status",
            data:"id="+id,
            success:function(res){

            }
        })
        me.contentShow(srcStr,classNum);
        setTimeout(function(){
            me.drift(classNum,nums);
        },1500)
        me.leftTo(nickname,msgtype,path,content);
    },
    leftTo:function(name,type,path,content){//弹幕拼接
        var barrage = document.createElement("div");
        barrage.className="barrage clearfix";
        var cwith = document.body.clientWidth;
        var chtight = document.body.clientHeight;
        chtight = Math.floor(Math.random()*chtight);
        barrage.setAttribute("style","width: "+cwith+"px;height: 84px;animation: rightTo "+Math.ceil(Math.random()*10)+"s;position:fixed;top:"+chtight+"px;left:"+cwith+"px;padding:0 12px")
        var barrageScu = document.createElement("div");
        barrageScu.className="barrage-scu";
        var barrageScuImg = document.createElement("img");
        barrageScuImg.src=path;
        barrageScu.appendChild(barrageScuImg);
        barrage.appendChild(barrageScu);
        switch (type) {
            case "text" :
                var barrageTxt = document.createElement("div");
                barrageTxt.className="barrage-txt";
                barrageTxt.innerHTML=name+"&nbsp;&nbsp;&nbsp;&nbsp;"+content;
                barrage.appendChild(barrageTxt);
                break;
            case "image" :
                var barrageImg = document.createElement("div");
                barrageImg.className="barrage-img";
                barrageImg.innerHTML=name+"&nbsp;&nbsp;&nbsp;&nbsp;<img src='"+content+"'>";
                barrage.appendChild(barrageImg);
                break;
            case "event" :
                var barrageTxt = document.createElement("div");
                barrageTxt.className="barrage-txt";
                barrageTxt.innerHTML=name+"&nbsp;&nbsp;&nbsp;&nbsp;签到上墙";
                barrage.appendChild(barrageTxt);
                break;
        }
        var barrageIonic = document.createElement("div");
        barrageIonic.className="barrage-ionic";
        barrage.appendChild(barrageIonic);
        document.body.appendChild(barrage);

        //动画完成后移除dom
        var clearTime;
        if(clearTime) clearInterval(clearTime);
        clearTime = setInterval(function(){
            if(document.querySelector(".barrage")){
                document.body.removeChild(document.querySelector(".barrage"));
            }
        },10000)

    },
    contentShow:function(imgSrc,classNum){
        var ul = document.querySelector(".wall-ul");
        var popDiv = document.createElement("div");
        var popImg = document.createElement("img");
        popDiv.className="pop-div"+classNum+" pop-div";
        popImg.src=imgSrc;
        popDiv.appendChild(popImg);
        ul.appendChild(popDiv);
        var popTxt = document.createElement("div");
        popTxt.className="pop-txt"
        popTxt.innerHTML="签到上墙";
        ul.appendChild(popTxt);
    },
    drift:function(classNum,objIndex){//位移
        var me = this;
        var classNmae = ".pop-div"+classNum;
        var ul = document.querySelector(".wall-ul");
        var li = ul.querySelectorAll("li");
        var getInfo,setInfo,getTop,getLeft;
        if(classNum>105){
            //debugger
        }
        var child = li[objIndex];
        getInfo = getpos(child);
        setInfo = getpos(document.querySelector(classNmae));
        getTop = getInfo.top - setInfo.top;
        getLeft = getInfo.left - setInfo.left;

        setcss(getTop,getLeft)

        function setcss(top,left){//移动到getInfo()函数随机到的坐标
            var t1 = "width:70px;height:70px;background:transparent;padding:0px;position:absolute;top:"+top+"px;left:"+left+"px;border-radius:2px;opacity:1;animation: imgshow 4s;transition:all 1s"
            document.querySelector(classNmae).querySelector("img").style.cssText="width:70px;height:70px;transition:all 1s"
            document.querySelector(classNmae).style.cssText=t1
        }
        function getpos(obj){//获取坐标
            var rect = obj.getBoundingClientRect();
            var top = document.documentElement.clientTop;
            var left= document.documentElement.clientLeft;
            return{
                top    :   rect.top - top,
                bottom :   rect.bottom - top,
                left   :   rect.left - left,
                right  :   rect.right - left
            }
        }
    }
}

window.onload=function(){
    var product = new productFn();
}